<?php

namespace App\Livewire\Reagents;

use Livewire\Component;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\Elab\Reagent;
use App\Models\Elab\Units;
use App\Models\Elab\Repository;
//Traits
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
use App\Traits\TUpdates\TProductConsumptionUpdate;
use App\Traits\TUpdates\TReagentConsumptionUpdate;
use App\Traits\TUpdates\TSampleConsumptionUpdate;

//helpers
use Log;
use Validator;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RemakeReagent extends Component
{
    use TProductConsumptionUpdate;
	use TSampleConsumptionUpdate;
	use TReagentConsumptionUpdate;

    //models
    public $units, $repositories;

    //form variables
    public $reagentCode, $rmName, $rmNickName, $rmDesc, $rmUnitDesc;
    public $rmReagentClassCode, $usedReagents, $altProdInfo=[];
    public $rmQuantity, $rmUnits_desc, $rmExpiryDate;
    public $rmStorContId, $rmShelfRackId, $rmBoxSackId, $rmLocationCode;
    public $rmOpenRestrict;
    public $rmNotes;
    public $rmMakeSame;
    public $rmMakeSameError;
    public $rmQuantityErrors=[];

    //flags
    public $stopFlag = false;

    //panels
    public $showFineChemPanel, $showSamplePanel, $showReagentPanel;

    public function render()
    {
        $this->repositories = Repository::all();
        $this->units = Units::all();
				$this->showReagentPanel = true;
        return view('livewire.reagents.remake-reagent');
    }

		/*
    public function showPanelReagents()
    {
        $this->showReagentPanel = true;
        $this->showSamplePanel = false;
        $this->showFineChemPanel = false;
    }

    public function showPanelSamples()
    {
        $this->showReagentPanel = false;
        $this->showSamplePanel = true;
        $this->showFineChemPanel = false;
    }

    public function showPanelFineChems()
    {
        $this->showReagentPanel = false;
        $this->showSamplePanel = false;
        $this->showFineChemPanel = true;
    }
		*/

    public function selectedReagent($params)
	{
		$regs = [];
		$reagent_id = $params['reagent_id'];
		
		$reagentBy_id = Reagents::with('units')
										->where('reagent_id', $reagent_id)
										->first();
										
		$ingradients = json_decode($reagentBy_id->ingradients);
		//dd($ingradients);
		
		$this->selectedReagentID = $reagentBy_id;
		//set the selected reagemt code
		$this->reagentCode = $reagentBy_id->reagent_code;
		
		foreach($ingradients as $row)
		{
			$regs['pmc'] = $row->pmc;
			$regs['name'] = $row->name;
			$regs['cat_num'] = $row->cat_num;
			$unit_def = " ".$row->unit_desc1.$row->unit_desc2;
			$regs['quantity'] = $row->quantity.$unit_def;
			$pmcProdInfo = Products::where('pack_mark_code', $row->pmc)->first();
			$regs['quantity_left'] = $pmcProdInfo->quantity_left.$unit_def;
			
			if( $pmcProdInfo->quantity_left < $row->quantity)
			{
				$regs['row_flag'] = "true";
				$regs['unitDef'] = $unit_def;
	
				// this query works and give total quantity left 
				// summing all packs having same catalog number.
				$quantityCheck =	Products::where('catalog_id', $row->cat_num)
												->selectRaw('sum(quantity_left) as qty_left , catalog_id')
												->groupBy('catalog_id')
												->get();
												
				foreach($quantityCheck as $valx)
				{
					if($valx->qty_left <= $row->quantity )
					{
						$quantityErrors[] = "Error: Insufficient Quantity of [ ".$row['cat_num']." ] ";
					}
					else {
						$this->altProdInfo = Products::with('units')->where('catalog_id', $row->cat_num)
													->where('quantity_left', '>=', $row->quantity)->get();
						$this->stopFlag = false;
					}
				}
			}
			else {
			    $this->stopFlag = false;
			}
			//dd($this->usedReagents, $this->stopFlag);
			array_push($this->usedReagents, $regs);
			$regs = [];
		}
		//$cap = count($this->altProdInfo);
		//dd($this->usedReagents, $this->altProdInfo, $cap, $this->stopFlag);
		
		$this->rmReagent_id = $reagentBy_id->reagent_id;
		$this->rmName = $reagentBy_id->name;
		$this->rmDesc = $reagentBy_id->description;
		$this->rmNickName = $reagentBy_id->nick_name;
		$this->rmIngradients = $ingradients;
		$this->rmMadebyID = $reagentBy_id->madeby_id;
		$this->rmDateMade = $reagentBy_id->date_made;
		$this->rmRegClassCode = $reagentBy_id->reagent_class_code;
		$this->rmRegCode = $reagentBy_id->reagent_code;
		$this->rmQuantity = $reagentBy_id->quantity_made;
		$this->rmUnitDesc = $reagentBy_id->units->description;
		
		$this->rmStorContId = $reagentBy_id->sotrage_container_id;
		$this->rmShelfRackId = $reagentBy_id->shelf_rack_id;
		$this->rmBoxSackId = $reagentBy_id->box_sack_id;
		$this->rmLocationCode = $reagentBy_id->location_code;
		$this->rmOpenRestrict = $reagentBy_id->open_restricted;
		$this->rmNotes = $reagentBy_id->notes;
		
		$this->openRemakeReagentFields = true;
		//dd($reagentBy_id);
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] remade reagent with id [ '.$reagentBy_id->nick_name.' ]');
	}

    public function postRemakeReagentInfo($reagentCode)
	{
		if($this->rmMakeSame != null )
		{
			// goals
			// 1. first get vials that have less than required quantity
			// 2. get ticked vial pack_mark_code and empty the vial from previous step
			// 3. remove the remaining quantity from the current selected vial.
			// dump validations

			$validatedData = $this->validate(
			[
        'rmCodePM' 		    => 'required|min:1',
        'rmReagentClassCode'  => 'required',
        'rmQuantity'          => 'required|numeric',
        'rmUnits_desc'        => 'required|numeric',
        'rmExpiryDate'        => 'required|date',

        'rmStorContId'        => 'required|numeric',
        'rmShelfRackId'       => 'required|numeric',
        'rmBoxSackId'         => 'required|numeric',
        'rmLocationCode'      => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/', 

        'rmOpenRestrict'      => 'required|numeric', 
        'rmNotes'             => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/'
			],
			[
        'rmCodePM.required'	=> 'The :attribute must check one box',
        'rmCodePM.rmCodePM'	=> 'The :attribute must check one box',
        'rmReagentClassCode.required' => 'The :attribute cannot be empty.',
        'rmReagentClassCode.rmReagentClassCode' => 'The :attribute must be selected.',
        'rmQuantity.required' => 'The :attribute cannot be empty.',
        'rmQuantity.rmQuantity' => 'The :attribute must be a whole number.',  
        'rmUnits_desc.required' => 'The :attribute cannot be empty.',
        'rmUnits_desc.rmUnits_desc' => 'The :attribute must be selected.',
        'rmExpiryDate.required' => 'The :attribute cannot be empty.',
        'rmExpiryDate.rmExpiryDate' => 'The :attribute must be date.',
        
        'rmStorContId.required' => 'The :attribute cannot be empty.',
        'rmStorContId.rmStorContId' => 'The :attribute must be a whole number.',
        'rmShelfRackId.required' => 'The :attribute cannot be empty.',
        'rmShelfRackId.rmShelfRackId' => 'The :attribute must be a whole number.',
        'rmBoxSackId.required' => 'The :attribute cannot be empty.',
        'rmBoxSackId.rmBoxSackId' => 'The :attribute must be a whole number.',
        'rmLocationCode.required' => 'The :attribute cannot be empty.',
        'rmLocationCode.rmLocationCode' => 'The :attribute must be a alpha numeric.',	
                
        'rmOpenRestrict.required' => 'The :attribute cannot be empty.',
        'rmOpenRestrict.rmOpenRestrict' => 'The :attribute must be selected.', 
        'rmNotes.rmNotes' => 'The :attribute must be alpha numeric only.'
			],
			[
        'rmCodePM'			 => 'Catalog ID',
        'rmReagentClassCode' => 'Reagent Class Code',
        'rmQuantity'         => 'Quantity',
        'rmUnits_desc'       => 'Units',
        'rmExpiryDate'       => 'Expiry Date',

        'rmStorContId'       => 'Container ID',
        'rmShelfRackId'      => 'Rack/Shelf ID',
        'rmBoxSackId'        => 'Box/Savk ID',
        'rmLocationCode'     => 'Loocation', 

        'rmOpenRestrict'     => 'Open/Restricted', 
        'rmNotes'            => 'Notes'
			]);
			
			
			$this->rmUnitDesc = $this->selectedReagentID->unit_id;
			
			//first determine whether the vials have enough quantity.
			$quantityErrors = [];
			foreach($this->rmIngradients as $row)
			{
				$this->rmNotes = "";
				
				$regs['pmc'] = $row['pmc'];
				$pmcProdInfo = Products::with('units')->where('pack_mark_code', $row['pmc'])->first();
				
				$regs['name'] = $row['name'];
				$regs['cat_num'] = $row['cat_num'];
				
				$regs['unit_desc1'] = $pmcProdInfo->units->symbol;
				$regs['unit_desc2'] = $pmcProdInfo->units->symbol_add;
				
				$regs['quantity'] = $row['quantity']; //original quantity must be taken for reagent
				$regs['usage'] = "same as earlier";	
				
				if( $pmcProdInfo->quantity_left < $row['quantity'] )
				{
					
					$this->rmNotes = $this->rmNotes."Vial PMC [ ".$row['pmc']." ] has less than needed";
					
					$subProdInfo = Products::where('catalog_id', $row['cat_num'])
													->where('quantity_left', '>=', $row['quantity'])->get();
					
					$qtyTakenFromOld = intval($pmcProdInfo->quantity_left);
					
					//now zero the quantity left in the db table and save it.
					$subProdInfo = $pmcProdInfo->quantity_left = 0;
					$subProdInfo->save();
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for id [ '.$row['pmc'].' ]'); 
					
					//now post to consumption table
					//create object for storage
					$newConsumption = new Consumption();
					$newConsumption->pack_mark_code = $row['pmc'];
					$newConsumption->user_id = Auth::user()->id;
					$newConsumption->date_used = date('Y-m-d');
					$newConsumption->product_id = $pmcProdInfo->product_id;
					//get unit_id
					$newConsumption->unit_id = $pmcProdInfo->unit_id;
					$newConsumption->quantity_consumed = $qtyTakenFromOld;
					//get Expt date
					$newConsumption->experiment_id = 0;
					$newConsumption->experiment_date = date('Y-m-d');
					$newConsumption->notes = $this->rmNotes;
					//dd($newConsumption);
					$newConsumption->save();
				    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for id [ '.$row['pmc'].' ]');
				    
					//get the vial id selected by user
					foreach($this->rmCodePM as $key => $val)
					{
						if($val)
						{
							// we are now setting to new vial 
							// as old was closed.
							$regs['pmc'] = $key;
						}
					}

					//here this $regs['quantity'] refers to the new vial 				
					$regs['quantity'] = $row['quantity'] - $qtyTakenFromOld;
					 
					//get quantity of the new vial, wrote here for verification
					$subProdInfo2 = Products::where('pack_mark_code', $regs['pmc'])
													->where('quantity_left', '>=', $regs['quantity'])->get();
													
					foreach($subProdInfo2 as $xval)
					{
						$qtyLeft = $xval->quantity_left - $regs['quantity'];
					}						
					
					if($qtyLeft >= 0 )
					{
						$this->stopFlag = false;
					}
					
					$this->rmNotes = $this->rmNotes." From new vial [ ".$row['pmc']." ] ". $row['quantity']." taken";
					//now set the newVialQuanity left as the value qtyLeft
				}
			
				array_push($this->reagentsUsed, $regs);
				$regs = [];
			}
		
			dd($stopFlag,$this->reagentsUsed );

			if(!$stopFlag)
			{
				$ingradients = json_encode($this->reagentsUsed);
			
				//dd($ingradients, $this->reagentsUsed);
				
				$newReagent = new Reagents();
				
				$newReagent->name                  = $this->rmName;
				$newReagent->nick_name             = $this->rmNickName;
				$newReagent->description           = $this->rmDesc;
				$newReagent->madeby_id             = Auth::user()->id;
				$newReagent->date_made             = date('Y-m-d');
				$newReagent->reagent_class_code    = $this->rmRegClassCode;
				
				// let it generate a new code, since old code may be valid or invalid
				// also a new primary key is also getting generated due to new entry
				$newReagent->reagent_code          = $this->generateCode(6);
				
				$newReagent->ingradients           = $ingradients;
				
				$newReagent->quantity_made         = $this->rmQuantity;
				
				$newReagent->unit_id               = $this->rmUnitDesc;
				
				$newReagent->quantity_left         = $this->rmQuantity;
				$newReagent->expiry_date           = $this->rmExpiryDate;
				$newReagent->storage_container_id  = $this->rmStorContId;
				$newReagent->shelf_rack_id         = $this->rmShelfRackId;
				$newReagent->box_sack_id           = $this->rmBoxSackId;
				$newReagent->location_code         = $this->rmLocationCode;
				$newReagent->open_restricted       = $this->rmOpenRestrict;
				$newReagent->notes                 = $this->rmNotes;
				//dd($newReagent);
				$newReagent->save();
				
				Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] save new reagent with id [ '.$newReagent->nick_name.' ]');
				
				//now using the inputs array process the usage information
				//especially the quantity left in products 
				//table and consumptions tables
				foreach($this->reagentsUsed as $row)
				{
					//now get the chemical detail from products table
					//reduce the quantity in products table
					$cProd = Products::where('pack_mark_code', $row['pmc'])->first();
					$cProd->quantity_left = $cProd->quantity_left - $row['quantity'];
					$cProd->status_date = date('Y-m-d');
					
					if( $cProd->quantity_left < $cProd->pack_size )
					{
						$cProd->status_open_unopened = 0;
					}
					
					//ensure it is not negative, 
					//it must be unsigned
					if($cProd->quantity_left < 0 )
					{
						$cProd->quantity_left = 0;
					}
					
					$cProd->save();
					
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for id [ '.$row['pmc'].' ]');

					//now post to consumption table
					//create object for storage
					$newConsumption = new Consumption();
					$newConsumption->pack_mark_code = $row['pmc'];
					$newConsumption->user_id = Auth::user()->id;
					$newConsumption->date_used = date('Y-m-d');
					$newConsumption->product_id = $cProd->product_id;
					//get unit_id
					$newConsumption->unit_id = $cProd->unit_id;
					$newConsumption->quantity_consumed = $row['quantity'];
					//get Expt date
					$newConsumption->experiment_id = 0;
					$newConsumption->experiment_date = date('Y-m-d');
					$newConsumption->notes = "General Open reagent.";
					//dd($newConsumption);
					$newConsumption->save();
					
					Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for id [ '.$row['pmc'].' ]');
					
				}		
			}	
			//now reset form fields
			$this->resetRemakeReagentForm();
			
			//close the form
			$this->openRemakeReagentFields = false;
		}
		else {
			$this->rmMakeSameError = "Make Same not checked";
		}
	}
	
	public function resetRemakeReagentForm()
	{
		$this->reagentCode = null;
		$this->rmMakeSame = null;
		
		$this->rmCodePM 		     = null;
		$this->rmReagentClassCode = null;
		$this->rmQuantity     = null;
		$this->rmUnits_desc   = null;
		$this->rmExpiryDate   = null;
			  
		$this->rmStorContId   = null;
		$this->rmShelfRackId  = null;
		$this->rmBoxSackId    = null;
		$this->rmLocationCode = null; 
			  
		$this->rmOpenRestrict = null;
		$this->rmNotes = null;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset form');
	}
}

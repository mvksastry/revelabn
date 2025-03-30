<?php

namespace App\Livewire\Reagents;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\Elab\Categories;
use App\Models\Elab\Consumption;
use App\Models\Elab\Products;
use App\Models\Elab\Reagents;
use App\Models\Elab\Repository;
use App\Models\Elab\Supplier;
use App\Models\Elab\Units;
//use App\Models\User;

//Traits
use App\Traits\Base;
use Validator;

//use File;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

use App\Livewire\Elab\Reagents\NewReagentForm;

class MakeNewReagent extends Component
{
	//validation of inputform
	public NewReagentForm $form;
	public $message;
	protected array $rules = [];
	use Base;
	//use Fileupload;
	//use WithFileUploads;
	
	//models
	public $repositories;
	public $categories;
	public $units;
	public $suppliers;
	public $products;

	//common panel titles
	public $panel_title = "Select Action";
	
	//consumption form inputs
	public $prodResult, $expt_id, $expt_date, $consumed;
	
	//reagent variables
  public $reagentCode;
	public $reagent_name, $reagent_nickname, $reagent_desc, $reagentClassCode;
	public $quantity_made, $units_id, $units_desc, $expiry_date, $unit_desc;
	public $container_id, $rack_shelf, $box_sack, $location_code, $note_remark;
	public $openrestriced = 1;
	
	public $product_id, $pack_mark_code, $prod_name;
	public $inputs = [], $pmcProd = [], $nameProd = [];
	public $quantityProd = [], $usageProd = [];
	public $i = 0;
	public $sampCode, $catalogNumber, $itemDesc, $unit_desc1, $unit_desc2;
	
	//panels
	public $searchResultBox1 = false;
	public $left_panel_title, $right_panel_title;
	
	//remake reagents
	public $selectedReagentID, $rmReagentClassCode;
	public $rmReagent_id,$rmName,$rmDesc,$rmNickName,$rmIngradients=[];
	public $rmMadebyID, $rmDateMade, $rmRegClassCode, $rmRegCode;
	public $rmQuantity, $rmUnits_desc, $rmUnitDesc, $rmExpiryDate;
	public $rmStorContId,$rmShelfRackId,$rmBoxSackId,	$rmLocationCode;
	public $rmOpenRestrict, $rmNotes, $rmMakeSame, $usedReagents = [];
	public $altProdInfo = [], $rmCodePM = [], $reagentsUsed = [];
	public $openRemakeReagentFields = false;
	
	//flags
	public $stopFlag = true;
	
	//errors
	public $rmMakeSameError, $rmQuantityErrors = [];
	
	//listeners
	protected $listeners = [
		'itemSelected' => 'selectedItem',
		'reagentSelected' => 'selectedReagent',
		'tableLoaded' => 'fineChemTable',
		'FineChemSelected' => 'fineChemItemSelected'
  ];
	
	//panels
	public $viewNewReagentForm = false;
	public $showNewReagentEntry = false;
	public $viewRemakeReagentForm = false;
	public $showRemakeReagentEntry = false;

	public $showFineChemPanel = false;
	public $showSamplePanel = false;
	public $showReagentPanel = false;


	public function render()
	{
		$this->units = Units::all();
		$this->suppliers = Supplier::all();
		$this->categories = Categories::all();
		//$this->products = Products::all();
		//$this->showFineChemPanel = true;
		$this->repositories = Repository::all();
		$this->reagentCode = $this->generateCode(6);
		//$this->left_panel_title = "Make Reagents";
		//$this->right_panel_title = "Current Inventory";
		$this->showNewReagentEntry = true;
		$this->showRemakeReagentEntry = false;
		//$this->dispatch("dataTableInit2");
		return view('livewire.reagents.make-new-reagent');
	}

	public function fineChemTable()
	{
			//++$this->dispatch("dataTableInit2");
	}

	public function fineChems()
	{
		$this->showFineChemPanel = true;
		$this->showSamplePanel = false;
		$this->showReagentPanel = false;
		//$this->dispatch("dataTableInit2");
		$message="Fine Chem Inventory Loaded";
		$this->dispatch('swal:confirm', ['title' => $message]);
	}

	public function samples()
	{
		$this->showFineChemPanel = false;
		$this->showSamplePanel = true;
		$this->showReagentPanel = false;
		$message="Experiment Samples Loaded";
		$this->dispatch('swal:confirm', ['title' => $message]);
	}

	public function reagents()
	{
		$this->showFineChemPanel = false;
		$this->showSamplePanel = false;
		$this->showReagentPanel = true;
		$message="Reagents Loaded";
		$this->dispatch('swal:confirm', ['title' => $message]);
	}

  public function fineChemItemSelected($params)
	{
       // dd($params);
		$this->product_id = $params['product_id'];
		
		$res = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('product_id', $this->product_id)
								->first();
		$this->sampCode = $res->pack_mark_code;						
		$this->inputs[$this->i]['pmc'] = $this->sampCode;
		$this->inputs[$this->i]['name'] = $res->name;
		$this->inputs[$this->i]['cat_num'] = $res->catalog_id;
		$this->inputs[$this->i]['unit_desc1'] = $res->units->symbol;
		$this->inputs[$this->i]['unit_desc2'] = $res->units->symbol_add;
		$this->inputs[$this->i]['quantity'] = '';
		$this->inputs[$this->i]['usage'] = '';
		
		//open the result box
		$this->searchResultBox1 = true;
		
		//keep ready for next item
		$this->i = $this->i + 1;
		
		//array_push($this->inputs ,$this->i);
		//dd($this->inputs);
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] selected the reagent ['.$this->sampCode.' ]');
	}

	public function removeFineChemFromList($key)
	{
		unset($this->inputs[$key]);
	}

  public function postReagentInfo()
	{	
		//$this->validate();

		//implement validations here
		$validatedData = $this->validate(
		[
			'reagent_name'     => 'required|numeric',
			'reagent_nickname' => 'required|numeric',
			'reagent_desc'     => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',

			'reagentClassCode' => 'required|numeric',
			
			'quantity_made'    => 'required|regex:/^[0-9.]+$/',
			'units_desc'       => 'required|numeric',
			'expiry_date'      => 'required|date',

			'container_id'     => 'required|numeric',
			'rack_shelf'       => 'required|numeric',
			'box_sack'         => 'required|numeric',
			'location_code'    => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',

			'note_remark'      => 'nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/',
		],
		[
			'reagent_name.required'             => 'The :attribute required',
			'reagent_name.reagent_name'         => 'The :attribute must be numeric input only',

			'reagent_nickname.required'         => 'The :attribute required',
			'reagent_nickname.reagent_nickname' => 'The :attribute must be numeric input only',

			'reagent_desc.required'             => 'The :attribute required',
			'reagent_desc.reagent_desc'         => 'The :attribute must be numeric input only',		

			'unit_desc.required'                => 'The :attribute required',
			'unit_desc.unit_desc'               => 'The :attribute must be selected',

			'sampleCode.sampleCode'             => 'The :attribute must be alpha, numeric input only',

			'reagentClassCode.reagentClassCode' => 'The :attribute must be alpha, numeric input only',

			'expiry_date.expiry_date'           => 'The :attribute must be Date',

			'container_id.required'             => 'The :attribute required',
			'container_id.container_id'         => 'The :attribute must be selected',
			'rack_shelf.required'               => 'The :attribute required',
			'rack_shelf.rack_shelf'             => 'The :attribute must be selected',

			'box_sack.required'                 => 'The :attribute required',
			'box_sack.box_sack'                 => 'The :attribute must be selected',

			'location_code.location_code'       => 'The :attribute must be alpha, numeric characters only',

			'note_remark.note_remark'           => 'The :attribute must be alpha, numeric characters only',
		],
		[
			'reagent_name'     => 'Reagent Name',
			'reagent_nickname' => 'Nickname',
			'reagent_desc'     => 'Reagent Description',

			'unit_desc'        => 'Units',

			'reagentClassCode' => 'Reagent Category',
			'sampCode'         => 'Sample Code',

			'quantity_made'    => 'Quantity',
			'expiry_date'      => 'Expiry Date',

			'container_id'     => 'Container',
			'rack_shelf'       => 'Rack-Shelf',
			'box_sack'         => 'Box-Sack',
			'location_code'    => 'Location Details',

			'openrestriced'    => 'Open / Restricted',
			'note_remark'      => 'Notes',
		]);

		$i=0;
		
		foreach($this->inputs as $row)
		{
			$this->inputs[$i]['quantity'] = $this->quantityProd[$i];
			$this->inputs[$i]['usage'] = $this->usageProd[$i];
			$i = $i + 1;
		}
	
		$ingradients = json_encode($this->inputs);

		$newReagent = new Reagents();
		
		$newReagent->name  = $this->form->reagent_name;
		$newReagent->nick_name  = $this->form->reagent_nickname;
		$newReagent->description  = $this->form->reagent_desc;
		$newReagent->madeby_id  = Auth::user()->id;
		$newReagent->date_made  = date('Y-m-d');
		$newReagent->reagent_class_code  = $this->form->reagentClassCode;
		$newReagent->reagent_code  = $this->form->sampCode;
		$newReagent->ingradients  = $ingradients;
		$newReagent->quantity_made  = $this->form->quantity_made;
		$newReagent->unit_id  = $this->form->units_desc;
		$newReagent->quantity_left  = $this->form->quantity_made;
		$newReagent->expiry_date  = $this->form->expirty_date;

		$newReagent->storage_container_id  = $this->form->container_id;
		$newReagent->shelf_rack_id  = $this->form->rack_shelf;
		$newReagent->box_sack_id  = $this->form->box_sack;
		$newReagent->location_code  = $this->form->location_code;
		$newReagent->open_restricted  = $this->form->openrestriced;
		$newReagent->notes  = $this->form->note_remark;
		$newReagent->save();
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved new reagent with id [ '.$newReagent->nick_name.' ]'); 
		
		//now using the inputs array process the usage information
		//especially the quantity left in products table and consumptions tables
		foreach($this->inputs as $row)
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
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity for reagent with id [ '.$row['pmc'].' ]'); 
			
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
			
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for reagent with id [ '.$row['pmc'].' ]');
			
		}
		//now clear theform
		$this->resetReagentForm();
		$ingradients = [];
	}
	
	public function resetReagentForm()
	{
		$this->form->reagent_name = null;
		$this->form->reagent_nickname = null;
		$this->form->reagent_desc = null;
		$this->form->sampCode = null;
		$this->form->quantity_made = null;
		$this->form->units_desc = null;
		$this->form->expirty_date = null;
		$this->form->container_id = null;
		$this->form->rack_shelf = null;
		$this->form->box_sack = null;
		$this->form->location_code = null;
		$this->form->openrestriced = null;
		$this->form->note_remark = null;
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reagent form reset');
	}
}

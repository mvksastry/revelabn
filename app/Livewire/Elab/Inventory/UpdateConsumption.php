<?php

namespace App\Livewire\Elab\Inventory;


use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\ELab\Products;
use App\Models\ELab\Consumption;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class UpdateConsumption extends Component
{
    //swal messages
	public $msgx;
	public $message;

	//consumption details
	public $stock_products, $selected_product;
	public $sampCode, $itemDesc, $catalogNumber, $category_name;
	public $vendor_name = null;
	public $unit_desc1, $unit_desc2, $open_status, $status_date;
	public $quantity_left, $full_empty, $prodResult = null;

	//consumption form
	public $expt_id, $expt_date, $consumed, $notes_ifany;

	//panels
	public $viewConsumptionForm = false;
	public $showConsumptionUpdate = false;

  public function render()
  {
		$this->stock_products = Products::with('categories')
														->with('units')
														->with('vendor')
														->get();
														 
		$msg = "Product Update Displayed";
		$this->dispatch('swal:confirm', ['title' => $msg]);
    return view('livewire.elab.inventory.update-consumption');
  }

	#[On('page-loaded')] 
	public function startDataTable()
	{
		//$this->dispatch('inventorylistInit'); 
	}

  public function selectedFineChem($param)
	{
		//dd($params);
		$this->sampCode = $param;
		
		$res = Products::with('categories')
														->with('units')
														->with('vendor')
														->where('pack_mark_code', $param)
														->first();

		$this->catalogNumber = $res->catalog_id;
		$this->itemDesc = $res->name;
		$this->catalogNumber = $res->catalog_id;
		$this->category_name = $res->categories->name;
		if($res->vendor != null)
		{
		$this->vendor_name = $res->vendor->name;
		}
		else {
			$this->vendor_name = "NA";
		}
		$this->unit_desc1 = $res->units->symbol;
		$this->unit_desc2 = $res->units->symbol_add;
		$this->open_status  = $res->status_open_unopened;
		$this->status_date  = $res->status_date;
		$this->quantity_left  = $res->quantity_left;
		$this->full_empty  = $res->full_empty;
		
		$this->prodResult = $res;
		
		$this->viewConsumptionForm = true;
		$this->showConsumptionUpdate = true;
		$this->dispatch('productdataTableInit');
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] selected item id [ '.$param.' ]');
	}

  public function postConsumptionInfo()
	{	
		//create object for storage
		$newConsumption = new Consumption();
		$newConsumption->pack_mark_code = $this->sampCode;
		$newConsumption->user_id = Auth::user()->id;
		$newConsumption->date_used = date('Y-m-d');
		$newConsumption->product_id = $this->prodResult->product_id;
		//get unit_id
		$newConsumption->unit_id = $this->prodResult->unit_id;
		$newConsumption->quantity_consumed = $this->consumed;
		//get Expt date
		$newConsumption->experiment_id = $this->expt_id;
		$newConsumption->experiment_date = $this->expt_date;
		$newConsumption->notes = $this->notes_ifany;
		//dd($newConsumption);
		$newConsumption->save();
		//$this->alert('success', 'Consumption Information Updated'); 
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved consumption for pack mark code [ '.$this->sampCode.' ]');
		
		//now reduce the quantity in products table
		$cProd = Products::where('pack_mark_code', $this->sampCode)->first();
		$final = $cProd->quantity_left - $this->consumed;
		
		if( $final < $cProd->pack_size )
		{
			$cProd->status_open_unopened = 0;
		}
		
		$cProd->status_date = $this->expt_date;
		
		//ensure itis not negative, 
		//it must be unsigned
		if($final < 0 )
		{
			$final = 0;
		}
		
		$cProd->quantity_left = $final;
		//dd($newConsumption, $final, $cProd);
		$cProd->save();
    $msg = "Consumption Update Success";
		$this->dispatch('swal:confirm', ['title' => $msg]); 
        
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updated quantity consumed for pack mark code [ '.$this->sampCode.' ]');
		
		//now clear the form
		$this->resetConsumptionDetail();
	}
	
	public function resetConsumptionDetail()
	{		
		//$this->panel_title = "Select Action";
		$this->packMarkCode = null;
		$this->sampCode = null;
		$this->category_name = null;
		$this->vendor_name = null;
		$this->catalogNumber = null;
		$this->itemDesc = null;
		$this->open_status = null;
		$this->status_date = null;
		$this->unit_desc1 = null;
		$this->unit_desc2 = null;
		$this->quantity_left = null;
		$this->consumed = null;
		$this->expt_id = null;
		$this->expt_date = null;
		$this->notes_ifany = null;
		$this->showConsumptionUpdate = false;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Consumption form reset');
	}
}

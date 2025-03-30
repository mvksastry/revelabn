<?php

namespace App\Livewire\Elab\Inventory;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\ELab\Categories;

//use App\Models\Elab\Consumption;
use App\Models\ELab\Products;
use App\Models\ELab\Repository;
use App\Models\ELab\Supplier;
use App\Models\ELab\Units;

//Traits
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
use App\Traits\TElab\ResearchProjectQueries;
use Livewire\WithFileUploads;
use Validator;

//Validation of product form
use App\Livewire\Forms\Inventory\ProductForm;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class AddToInventory extends Component
{
	//form validation
	public ProductForm $form;

	//Trait classes
  use Base;
  use ResearchProjectQueries;

  //swal messages
	public $msgx;
	public $message;

  //models
	public $repositories;
	public $categories;
	public $units;
	public $suppliers;

	//common panel titles
	public $panel_title = "Select Action";

	//project info
	public $allActiveResProjects;

	//Fine chem form variables
	public $packMarkCode, $resproj_id, $category_id, $catalog_number, $item_desc;
	public $source_desc, $pack_size, $unit_desc, $number_packs;
	public $container_id, $rack_shelf, $box_sack, $location_code, $note_remark;
	public $batchCode, $dateMFD, $dateExpiry, $vialCost, $costCurrency;

	public $viewFineChemForm = true;

	public function render()
	{
		$this->packMarkCode = $this->generateCode(6);
		$this->categories = Categories::all();
		$this->repositories = Repository::all();
		$this->units = Units::all();
		$this->suppliers = Supplier::all();
		$this->allActiveResProjects = $this->allResProjects();
		$this->panel_title = "Add To Inventory";
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Displayed inventory form');
		return view('livewire.elab.inventory.add-to-inventory');
	}

	public function postProductInfo()
	{
		//dump all validations
		if($this->form->number_packs != null )
		{
			for($i = 0; $i < $this->form->number_packs; $i++)
			{	
				$this->validate();
				/*
				//implement validations here
				$validatedData = $this->validate(
				[
					'category_id'    => 'required|numeric',
					'resproj_id'     => 'required|numeric',
					'catalog_number' => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',
					'item_desc'      => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',

					'pack_size'      => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',
					'unit_desc'      => 'required|numeric',
					'number_packs'   => 'required|numeric',

					'dateMFD'        => 'nullable|date',
					'batchCode'      => 'nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/',

					'vialCost'       => 'required|regex:/^[0-9.]+$/',
					'costCurrency'   => 'required|alpha',

					'dateExpiry'     => 'nullable|date',

					'source_desc'    => 'required|numeric',
					'pack_size'      => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',

					'container_id'   => 'required|numeric',
					'rack_shelf'     => 'required|numeric',
					'box_sack'       => 'required|numeric',
					'location_code'  => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',

					'note_remark'    => 'nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/',
				],
				[
					'category_id.required'          => 'The :attribute required',
					'category_id.category_id'       => 'The :attribute must be numeric input only',

					'resproj_id.required'           => 'The :attribute required',
					'resproj_id.resproj_id'         => 'The :attribute must be numeric input only',

					'catalog_number.required'       => 'The :attribute required',
					'catalog_number.catalog_number' => 'The :attribute must be alpha, numeric input only',

					'item_desc.required'            => 'The :attribute required',
					'item_desc.item_desc'           => 'The :attribute must be alpha, numeric input only',

					'pack_size.required'            => 'The :attribute required',
					'pack_size.pack_size'           => 'The :attribute must be numeric input only',

					'unit_desc.required'            => 'The :attribute required',
					'unit_desc.unit_desc'           => 'The :attribute must be selected',

					'number_packs.required'         => 'The :attribute required',
					'number_packs.number_packs'     => 'The :attribute must be numeric input only',

					'dateMFD.dateMFD'               => 'The :attribute must be Date only',

					'batchCode.batchCode'           => 'The :attribute must be alpha, numeric input only',

					'vialCost.required'             => 'The :attribute required',
					'vialCost.vialCost'             => 'The :attribute must be numbers, decimal allowed',

					'costCurrency.required'         => 'The :attribute required',
					'costCurrency.costCurrency'     => 'The :attribute must be selected',

					'dateExpiry.dateExpiry'         => 'The :attribute must be Date',

					'source_desc.required'          => 'The :attribute required',
					'source_desc.source_desc'       => 'The :attribute must be selected',

					'container_id.required'         => 'The :attribute required',
					'container_id.container_id'     => 'The :attribute must be selected',

					'rack_shelf.required'           => 'The :attribute required',
					'rack_shelf.rack_shelf'         => 'The :attribute must be selected',

					'box_sack.required'             => 'The :attribute required',
					'box_sack.box_sack'             => 'The :attribute must be selected',

					'location_code.location_code'   => 'The :attribute must be alpha, numeric characters only',

					'note_remark.note_remark'       => 'The :attribute must be alpha, numeric characters only',
				],
				[
					'category_id'    => 'Category ID',
					'resproj_id'     => 'Research Project',
					'catalog_number' => 'Catalog Number',
					'item_desc'      => 'Item Description',

					'pack_size'      => 'Pack Size',
					'unit_desc'      => 'Units',
					'number_packs'   => 'Number of Packs',

					'dateMFD'        => 'Mfd Date',
					'batchCode'      => 'Batch Code',

					'vialCost'       => 'Cost',
					'costCurrency'   => 'Currency',

					'dateExpiry'     => 'Expiry Date',

					'source_desc'    => 'Supplier',
					'pack_size'      => 'Pack Size',

					'container_id'   => 'Container',
					'rack_shelf'     => 'Rack-Shelf',
					'box_sack'       => 'Box-Sack',
					'location_code'  => 'Location Details',

					'note_remark'    => 'Notes',
				]);
				*/

				$nprod = new Products();
				$nprod->pack_mark_code = $this->generateCode(6);
				$nprod->category_id = $this->form->category_id;
				$nprod->resproject_id = $this->form->resproj_id;
				$nprod->catalog_id = $this->form->catalog_number;
				$nprod->name = $this->form->item_desc;
				
				$nprod->pack_size = $this->form->pack_size;
				$nprod->unit_id = $this->form->unit_desc;
				$nprod->num_packs = $this->form->number_packs;
				
				$nprod->mfd_date = $this->form->dateMFD;
				$nprod->batch_code = $this->form->batchCode;
				
				$nprod->vial_cost = $this->form->vialCost;
				$nprod->item_currency = $this->form->costCurrency;
				
				$nprod->expiry_date = $this->form->dateExpiry;
				
				$nprod->supplier_id = $this->form->source_desc;
				$nprod->status_open_unopened = 1; // 1 is unopened, 0 is opened
				$nprod->status_date = date('Y-m-d');
				$nprod->quantity_left = $this->form->pack_size;
				$nprod->full_empty = 1;  // 1 is full , 0 is empty
				
				$nprod->storage_container_id = $this->form->container_id;
				$nprod->shelf_rack_id = $this->form->rack_shelf;
				$nprod->box_id = $this->form->box_sack;
				$nprod->box_position_id = $this->form->location_code;
	
				if($this->form->box_sack == null || $this->form->location_code == null)
				{
					$nprod->open_storage = 1;  // 1 is kept in open
				}else {
					$nprod->open_storage = 0;  // 0 is in a box or some enclosed
				}
				
				$nprod->enteredby_id = Auth::id();
				$nprod->date_entered = date('Y-m-d');
				$nprod->notes = $this->form->note_remark;
				//dd($this->form->number_packs, $nprod);
				$nprod->save();
				Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved inventory info [ '.$this->generateCode(6).' ]');
				$msg = "Product Entry Success";
				$this->dispatch('swal:confirm', ['title' => $msg]);
				$this->resetInventoryForm();
				$this->viewFineChemForm = false;
			}
		}
		else {
			$msg = "Number of Packs Empty";
			$this->dispatch('swal:warning', ['title' => $msg]);
		}
		//$this->alert('success', 'Inventory Updated'); 
		
		$this->viewFineChemForm = false;
	}

  private function resetInventoryForm()
	{
		//$this->panel_title = "Select Action";
		$this->form->category_id = null;
		$this->form->resproj_id = null;
		$this->form->catalog_number = null;
		$this->form->item_desc = null;
		$this->form->pack_size = null;
		$this->form->unit_desc = null;
		$this->form->number_packs = null;
		$this->form->dateMFD = null;
		$this->form->batchCode = null;
		$this->form->vialCost = null;
		$this->form->costCurrency = null;
		$this->form->dateExpiry = null;		
		$this->form->source_desc = null;
		$this->form->container_id = null;
		$this->form->rack_shelf = null;
		$this->form->box_sack = null;
		$this->form->location_code = null;
		$this->form->note_remark = null;
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset inventory form');
	}
}

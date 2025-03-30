<?php

namespace App\Livewire\Elab\Inventory;

//Core common to all - Don't tamper
use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//framework
use File;
use Validator;
use Log;
use Carbon\Carbon;
use Illuminate\Log\Logger;

//Research Projects

//models
use App\Models\ELab\Categories;
use App\Models\Elab\Consumption;
use App\Models\ELab\Products;
use App\Models\ELab\Repository;
use App\Models\ELab\Supplier;
use App\Models\ELab\Units;
use App\Models\User;

//Traits
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
use Livewire\WithFileUploads;
use App\Traits\TElab\ResearchProjectQueries;

//

class ManageInventory extends Component
{
  use Base;
	use FileUploadHandler;
	use WithFileUploads;
	use ResearchProjectQueries;
	//
  //  use LivewireAlert;
	//
	//swal messages
	public $message;

	//models
	public $repositories;
	public $categories;
	public $units;
	public $suppliers;
	
	//common panel titles
	public $panel_title = "Select Action";
	
	//project info
	public $allActiveResProjects, $resproj_id;
	
	//consumption form inputs
	public $prodResult, $expt_id, $expt_date, $consumed, $notes_ifany;
		
	//panels
	public $viewFineChemForm = false;
	public $viewConsumptionForm = false;
	public $viewNewCategoryForm = false;
	public $viewBulkUploadOptions = false;
	public $showInventoryPanel = false;
	
	//public $viewSearchForm = false;
	public $fullInventoryTable = true;
	public $showConsumptionUpdate = false;
	public $fullInventorySearchTable = false;
	
	//searchable
	public $value, $selectReply, $pack_mark_code;
	
	//listeners
	protected $listeners = [
		'itemSelected' => 'selectedItem',
		'refreshComponent' => '$refresh'
  ];
	
	//sweet alerts
	public $bulkUploadSuccess = false, $bulkUploadFail = false;

	public function render()
	{
		$logChannel = tenant('id');
		Log::channel($logChannel)->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed consumption form x');
		return view('livewire.elab.inventory.manage-inventory');
	}

  public function inventoryFormView()
	{

	}


	

	///////////////////////////////////////////////
	public function consumptionFormView()
	{
		//reset forms all
		$this->resetInventoryForm();
		$this->resetConsumptionDetail();
		
		//set title
		$this->panel_title = "Update Consumption";
		
		//close all other views
		$this->showInventoryPanel = true;
		$this->fullInventorySearchTable = true;
		$this->viewFineChemForm = false;
		$this->fullInventoryTable = false;
		$this->viewNewCategoryForm = false;
		$this->viewBulkUploadOptions = false;
		
		//open only relevant view
		if($this->sampCode = null || $this->sampCode = "")
		{
			$this->viewConsumptionForm = false;
			$this->showConsumptionUpdate = false;
		}
		
		Log::channel(tenant('id'))->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed consumption form');
	}
	///////////////////////////////////////////////

	///////////////////////////////////////////////

	/*
	public function updatedSampCode()
	{
		//dd($this->sampCode);
	}
	public function updatedCatalogNumber()
	{
		//dd($this->catalogNumber);
	}
	
	public function updatedItemDesc()
	{
		//dd($this->itemDesc);
	}
	*/

	


	///////////////////////////////////////////////
	/*
	public function searchFormView()
	{
		//dd("Reached search window");
		
	}
	
	public function showNewCategoryCreation()
	{
	    $this->showInventoryPanel = true;
		$this->fullInventoryTable = false;
		$this->fullInventorySearchTable = false;
		$this->viewBulkUploadOptions = false;
		
		//dd("reached");
		$this->viewNewCategoryForm = true;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed new category creation form');
	}
	*/

	

	
	/////////// -- Bulk Import section -- ///////////
	
	public function showBulkAdditionOption()
	{
	    
		//dd("reached");

		// panel opening-closing
		$this->showInventoryPanel = false;
		$this->viewFineChemForm = false;
		$this->viewConsumptionForm = false;
		$this->fullInventoryTable = false;
		$this->fullInventorySearchTable = false;
		$this->viewNewCategoryForm = false;
		$this->viewBulkUploadOptions = true;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed Bulk Addition form');
	}
	
	public function downloadBulkTemplate()
	{
		// get pis folder, modify the column
		$path = storage_path('templates/inventoryImport.xlsx');
		$headers = array(
				'Content-Type: application/xls',
		);
		return response()->download($path);
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] downloaded bulk inventory template');
	}
	
	public function processBulkInventoryUpload()
	{
		$this->bulkUploadSuccess = true;
		$this->alert('warning', 'Not Yet Implemented');
		//dd("processing reached: will be operational shortly");
	}

}

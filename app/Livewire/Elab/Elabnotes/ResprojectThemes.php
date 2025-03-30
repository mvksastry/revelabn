<?php

namespace App\Livewire\Elab\Elabnotes;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use File;
use Validator;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;
//------------------------------------------------------------//

//E-Lab record models
use App\Models\Elab\Consumption;
use App\Models\Elab\Categories;
use App\Models\Elab\Experiment;
use App\Models\Elab\Exptimage;
use App\Models\Elab\Exptfile;
use App\Models\Elab\Exptnote;
use App\Models\Elab\Exptsample;
use App\Models\Elab\Procedure;
use App\Models\Elab\Products;
use App\Models\Elab\Protocol;
use App\Models\Elab\Reagents;
use App\Models\Elab\Reagentusage;
use App\Models\Elab\Report;
use App\Models\Elab\Resassent;
use App\Models\Elab\Resproject;
use App\Models\Elab\Sampleusage;
use App\Models\Elab\Theme;
use App\Models\Elab\Units;
use App\Models\User;

//-- Traits used --//
use App\Traits\Base;
use App\Traits\TCommon\CameraOperations;
use App\Traits\TCommon\FileUploadHandler;
use App\Traits\TElab\ResearchProjectPermission;
use App\Traits\TElab\ResearchProjectQueries;
use App\Traits\TElab\SaasPlanQueries;
use App\Traits\TUpdates\TProductConsumptionUpdate;
use App\Traits\TUpdates\TReagentConsumptionUpdate;
use App\Traits\TUpdates\TSampleConsumptionUpdate;
use App\Traits\TLivewire\FineChemicalSelection;
use App\Traits\TLivewire\ExptSampleSelection;
use App\Traits\TLivewire\ReagentSelection;
use App\Traits\TLivewire\SaveResearchTheme;

class ResprojectThemes extends Component
{
	//Traits used in the component.
	use Base;
	use ResearchProjectPermission;
	use ResearchProjectQueries;
	use FileUploadHandler;
	use WithFileUploads;
	use SaasPlanQueries;
	use TProductConsumptionUpdate;
	use TSampleConsumptionUpdate;
	use TReagentConsumptionUpdate;
	use SaveResearchTheme;
	use FineChemicalSelection;
	use ExptSampleSelection;
	use ReagentSelection;
	use CameraOperations;
	/////////////////////////

	//research project variables
	//public $resproject;
	public $active_projects;
	public $resproject_id;
	//public $project_title;
	public $resproject_title;
	public $start_date;
	public $end_date;
	public $date_approved;

	//theme variables
	public $themes = [];
	public $theme_id;
	public $theme_title;
	public $theme_desc;

	//Swal Alert message
	//public $msgx;
	public $message = "";
	//Component Messages
	public $icMessage = null;
	
	//file uploads, //images of experiments
	public $exptFiles=[], $exptImage, $nbimages = 'None', $nbqs = 'null';
	
	//images of experiments
	public $images=[], $imageTag, $imgTag, $image, $imagenotes, $camera, $value=null;

	//experiment variables
	public $expt_id, $exptInfos, $expt_title, $expt_desc, $currentProtocols, $curExpts; 
	public $curProcs, $selProts, $selProcs;
	public $reagent_used, $reagent_desc, $resNotes, $pi_notes, $sample_code; 
	public $labook_ref, $ssdtref, $expt_user_notes;
	public $expDetailProtocols, $expDetailProcedures;

	//modal related variables
	//public $experiment_id = null;

	//listeners
	protected $listeners = [
		'itemSelected'       => 'selectedItem',
	//'exptsampleSelected' => 'selectedExptSample',
		'reagentSelected'    => 'selectedReagent',
		'refreshComponent'   => '$refresh',
		'processImage'       => 'processImage', 
		'snapShotSuccess'    => 'alertSuccess',
		'frontCamera'        => 'switchToFront',
		'backCamera'         => 'switchToBack'
	];
		
	//reagents, products used variables
	//part of experiment addition 

	//Experiment Theme dynamic inputs
	public $units;
	
	public $fineChems, $specialReagents, $specialSamples;
  
	public $product_id, $pack_mark_code, $contact_id, $prod_name;
	public $updateMode = false;
	public $inputs = [], $pmcProd = [], $nameProd = [];
	
	public $quantityProd = [], $usageProd = [];
	public $quantitySamp = [],  $usageSamp = [];
	public $quantityReag = [],  $usageReag = [];
	
	public $erProdQty = "";
		
	//indexes
	public $i = 0, $j = 0, $k = 0;
	public $reagUsed = null, $fineChem = [], $expSamp = [], $userReag = [];
	
	//samples
	public $sampCode, $catalogNumber, $itemDesc, $unit_desc1, $unit_desc2 = [], $unit_desc3 = [];
	public $inpExptsamps = [];
	
	//reagentSelected
	public $inpReagents = [];
		
	//input fields
	public $searchResultBox1 = false;
	public $searchResultBox2 = false;
	public $searchResultBox3 = false;
	/////////////////////////////

	//panels
	public $themeEntryField = false;
	public $viewNewTheme    = false;
	public $viewThemeList   = false;
	public $viewNewExptForm = false;
	public $viewExptList    = false;
	public $exptDetails     = false;
	public $cameraOptions   = false;
	
	//search panels
	public $viewProductList = false;
	public $viewSampleList  = false;
	public $viewBuffersList = false;
	
	//gelimage
	public $gelimage;

	//modals
	public $file_name;
	public $file_path;

	public function render()
	{
		$this->active_projects = Resproject::where('status', 'active')->get();
		return view('livewire.elab.elabnotes.themes.resproject-themes');
	}

	//....... All modal pop-up here .......//
	//public function showCameraOptions($experiment_id)
	//{
	//	$this->cameraOptions = true;
	//	$message = "Camera Opened";
	//	$this->dispatch("swal.confirm", ["title" => $message]);
	//}

	//....... Camera selection .......//
	public function switchToFront()
	{
		//dd("front selected");
		$this->camera = "front";
		$this->dispatch('cam-sel', ['cameraMsg' => $this->camera]);
	}

	public function switchToBack()
	{
		//dd("back selected");
		$this->camera = "back";
		$this->dispatch('cam-sel', ['cameraMsg' => $this->camera]);
	}	
	//....... End of Camera selection .......//

	public function showPagePictureModal($experiment_id)
	{
		//dd($experiment_id);
		$this->dispatch("openModal", 'modals.modal-pagegel',
					["experiment_id" => $experiment_id]);
	}
	
	public function showImageModal($path)
	{
		//dd($path);
		$vars = explode("/", $path);
	  $this->file_name = $vars[3];
		$this->file_path = "app/public/".$path;
		$this->file_path = $path;
		$this->dispatch("openModal", 'modals.exptimage-display-modal',
					["file_name" => $this->file_name, "path"=> $this->file_path ,"expt_id" => $vars[2]]);
	}
  //....... End of modal pop-up here .......//
    
  //....... sweet Alerts .......//
	public function alertSuccess($message)
	{
		$this->dispatch('swal.confirm', 
				 ['type' => 'success',  'message' => $message]);
	}
    
	public function alertError($message)
	{
		$this->dispatch('swal.confirm', 
				 ['type' => 'error',  'message' => $message]);
	}

	public function alertInfo($message)
	{
		$this->dispatch('swal.confirm', 
				 ['type' => 'info',  'message' => $message]);
	}
	//....... end of sweet Alerts .......//

	// All the code has been shifted to traits in TCommon\CameraOperations
	//....... Camera selection .......//
	//....... End of Camera selection .......//
	//....... Camera Image Processing .......//
	//....... End of Camera Image Processing .......//

	//-----// Fine chem //-----//
	// All the code has been shifted to traits in TUpdates dir
	//-----// end of fine chem //-----//

	//-----// Experiment Samples //-----//
	// All the code has been shifted to traits in TUpdates dir
	//-----// end of samples //-----//

	//-----// Reagents //-----//
	// All the code has been shifted to traits in TUpdates dir
	//-----// end of reagents //-----//
	//-----------------------------------------//

	//-- Product, Reagent, Sample selections --//
	public function viewInventoryCatalog()
	{
		//dd("reached");
		//remove, included for testing the modals.
		/*
		$this->experiment_id = 5; //for testing only not needed
		$this->dispatch("openModal", 'modals.modal-image',
					["experiment_id" => $this->experiment_id]);
		*/

		$this->fineChems = Products::all();
		$this->viewProductList = true;
		$this->viewSampleList = false;
		$this->viewBuffersList = false;
		$msg = "Proudct Data Loaded";
		$this->dispatch('swal:confirm', ['title' => $msg]);
	}

	//-----// Samples List Catalog //-----//
	public function viewSampleCatalog()
	{ 
		$this->specialSamples = Exptsample::all();
		$this->viewProductList = false;
		$this->viewSampleList = true;
		$this->viewBuffersList = false;
		$msg = "Sample Data Loaded";
		$this->dispatch('swal:confirm', ['title' => $msg]);
	}
	
	//-----// Reagent Catalog //-----//
	public function viewReagentCatalog()
	{ 
		$this->specialReagents = Reagents::all();
		$this->viewProductList = false;
		$this->viewSampleList = false;
		$this->viewBuffersList = true;
		$msg = "Reagent Data Loaded";
		$this->dispatch('swal:confirm', ['title' => $msg]);
	}

	//------ Themes and new New Themes ----------//
  public function viewAllThemes($resproject_id)
	{
		$this->resproject_id = $resproject_id;
		$this->themeEntryField = true;
		$this->themes = [];

		if($this->checkResProjectAllowed($resproject_id))
		{
			$this->hyderateProjectInfos($resproject_id);
			if( Auth::user()->hasAnyRole(['pisg']) )
			{
				$this->themes = Theme::where('resproject_id', $resproject_id)
										//->where('allowed_id', '=', Auth::user()->id)
										->get();
				if(count($this->themes) > 0){
					$this->message="Themes loaded successfully";
					$this->dispatch('swal:confirm', ['title' => $this->message]);
				}
				else {
					$this->message="Themes Not Found";
					$this->dispatch('swal:warning', ['title' => $this->message]);
				}
			}
		    
			if( Auth::user()->hasAnyRole(['researcher']) )
			{
				$this->themes = Theme::where('resproject_id', $resproject_id)
										->where('allowed_id', '=', Auth::user()->id)
										->get();
			}
			// log the activity								
			Log::channel('activity')->info("Tenant ID [ ".tenant('id')." ] For User [ ".Auth::user()->name.' ] Displayed current themes');
			
			$this->viewExptList = false;
			$this->viewNewExptForm = false;
			$this->exptDetails = false;
			$this->viewThemeList = true;
		}
		else {
			// log the activity
			Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] does not have permission to view themes');
			$this->icMessage = "No Permission to view";
		}
	}

  public function hyderateProjectInfos($resproject_id)
	{
		$result = $this->resProjectById($resproject_id);
		$this->resproject_title = $result->title;
		$this->start_date = $result->start_date;
		$this->end_date = $result->end_date;
		$this->date_approved = $result->date_approved;
	}
	
  public function hydrateThemeInfos($theme_id)
	{
		$result = Theme::where('theme_id', $theme_id)->first();
		$this->theme_id = $result->theme_id;
		$this->theme_title = $result->theme_description;
	}

	public function saveNewTheme()
	{
		$validatedData = $this->validate([
		  'theme_desc' => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:255',
		]);
		if( Auth::user()->hasAnyRole(['pisg','researcher']) )
		{
			if($this->checkResProjectAllowed($this->resproject_id))
			{
				$result = $this->researchThemeCreation();
				if($result)
				{
					$this->message = "Theme Creation Successful";
					$this->dispatch('swal:confirm', ['title' => $this->message]);
				}
				else {
					$this->message = "Theme Creation Failed, Contact Admin";
					$this->dispatch('swal:warning', ['title' => $this->message]);
				}
				//log activity
				Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] saved new theme [ '.$this->theme_desc.' ]');
				$this->viewThemeList = false;
				$this->theme_desc = null;
			}
		}
		else {
				$this->error_number = 10002;
				$this->error_message = "No Permission To Execute this operation";
				return view('saaserrors.error');
		}
	}
	//----------- End of Theme related code -----------//

	//----------- Experimental Section ----------------//
  public function addNewExperiment($theme_id)
	{
		if( Auth::user()->hasAnyRole(['pisg','researcher']) )
		{
			if($this->checkResProjectAllowed($this->resproject_id))
			{
				if($this->getTenantExptCountByPlan())
        {
					//dd($theme_id);
					$this->viewThemeList = true;
					$this->themeEntryField = false;
					$this->viewNewExptForm = true;
					$this->viewExptList = false;
					$this->exptDetails = false;

					//hydrate selected theme information
					$this->hydrateThemeInfos($theme_id);

					$this->currentProtocols = Protocol::all();
					$this->curProcs = Procedure::all();
					$this->viewNewExptForm = true;
					$this->icMessage = 'New Experiment Form Loaded';
					$this->dispatch('swal:confirm', ['title' => $this->icMessage]);
					Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] new expt form displayed');
				}
				else {
					$this->icMessage="Exceeded Experiment Count";
					$this->dispatch('swal:warning', ['title' => $this->icMessage]);
				}
			}
			else {
				$this->icMessage="Project Permissions Not Present";
				$this->dispatch('swal:warning', ['title' => $this->icMessage]);
			}
		}
		else {
			$this->icMessage="No Permission To Add Experiment";
			$this->dispatch('swal:warning', ['title' => $this->icMessage]);
		}
	}

  //this $id represents theme_id
	public function saveNewExperiment($id)
	{	
		if( Auth::user()->hasAnyRole(['pisg', 'researcher']) )
		{
			if($this->checkResProjectAllowed($this->resproject_id))
			{	
				//now based on number of product reagents selected validate them
				$minProd = count($this->inputs);
				
				if($minProd > 0 )
				{
					$validatedData = $this->validate(
					[
						'quantityProd'   => 'required|array|min:'.$minProd, //never written like this till now!
						'quantityProd.*' => 'numeric',
	
						'usageProd'    => 'required|array|min:'.$minProd, //never written like this till now!
						'usageProd.*'  => 'string'
					],
					[ 
						'quantityProd.required'        => 'Error: The :attribute cannot be empty.',
						'quantityProd.*.quantityProd.*' => 'Error: The :attribute must be number.',
						
						'usageProd.required'        => 'Error: The :attribute cannot be empty.',
						'usageProd.*.usageProd.*' => 'Error: The :attribute must be number.'
					],
					[ 
						'quantityProd'        => 'Quantity',
						'usageProd'        => 'Usage'
					]);
				}
				
				//now based on number of product reagents selected validate them
				$minSamp = count($this->inpExptsamps);
				
				if($minSamp > 0)
				{
					$validatedData = $this->validate(
					[
						'quantitySamp'   => 'required|array|min:'.$minSamp, //never written like this till now!
						'quantitySamp.*' => 'numeric',
							
						'usageSamp'    => 'required|array|min:'.$minSamp, //never written like this till now!
						'usageSamp.*'  => 'string',
							
						'unit_desc2'   => 'required|array|min:'.$minSamp,
						'unit_desc2.*' => 'min:1|max:9'
					],
					[ 
						'quantitySamp.required'        => 'Error: The :attribute cannot be empty.',
						'quantitySamp.*.quantitySamp.*' => 'Error: The :attribute must be number.',
						
						'usageSamp.required'        => 'Error: The :attribute cannot be empty.',
						'usageSamp.*.usageSamp.*' => 'Error: The :attribute must be number.',
						
						'unit_desc2'   => 'Error: The :attribute must be selected',
						'unit_desc2.*' => 'Error: The :attribute must be selected.'
					],
					[ 
						'quantitySamp'        => 'Quantity',
						'usageSamp'        => 'Usage',
						'unit_desc2'  => 'Usage Units'
					]);
				}
				
				//now based on number of product reagents selected validate them
				$minReag = count($this->inpReagents);
				
				if($minReag > 0 )
				{
					$validatedData = $this->validate(
					[
						'quantityReag'   => 'required|array|min:'.$minReag, //never written like this till now!
						'quantityReag.*' => 'numeric',
						
						'usageReag'    => 'required|array|min:'.$minReag, //never written like this till now!
						'usageReag.*'  => 'string',
						
						'unit_desc3'   => 'required|array|min:'.$minReag,
						'unit_desc3.*' => 'min:1|max:9'
					],
					[ 
						'quantityReag.required'         => 'Error: The :attribute cannot be empty.',
						'quantityReag.*.quantityReag.*' => 'Error: The :attribute must be number.',
	
						'usageReag.required'      => 'Error: The :attribute cannot be empty.',
						'usageReag.*.usageReag.*' => 'Error: The :attribute must be number.',
						
						'unit_desc3'   => 'Error: The :attribute must be selected',
						'unit_desc3.*' => 'Error: The :attribute must be selected.'
					],
					[ 
						'quantityReag' => 'Quantity',
						'usageReag'    => 'Usage',
						'unit_desc3'  => 'Usage Units'
					]);
				}
				
				//  dd($this->quantityProd, $this->usageProd);
				//	$this->quantitySamp, $this->usageSamp, $this->unit_desc2, 
				//	$this->quantityReag, $this->usageReag, $this->unit_desc3 );	
				
				$validatedData     = $this->validate(
				[
					'expt_desc'    => 'required|string|regex:/^[A-Za-z0-9-_,. ]+$/',
					'selProcs'     => 'required|min:1|max:200',
					'selProts'     => 'required|min:1|max:200',
					'sample_code'  => 'required|string|regex:/^[A-Za-z0-9-_ ]+$/',				
					'reagent_used' => 'required|string|regex:/^[A-Za-z0-9-_,. ]+$/',
					'reagent_desc' => 'required|string|regex:/^[A-Za-z0-9-_,. ]+$/',
					'resNotes'     => 'required|string|regex:/^[A-Za-z0-9-_,. ]+$/',
					'pi_notes'     => 'nullable|string|regex:/^[A-Za-z0-9-_,. ]+$/',
					'labook_ref'   => 'nullable|string|regex:/^[A-Za-z0-9-_., ]+$/',
					'ssdtref'      => 'nullable|string|regex:/^[A-Za-z0-9-_., ]+$/'
				],
				[
					'expt_desc.required'        => 'Error: The :attribute cannot be empty.',
					'expt_desc.expt_desc'       => 'Error: The :attribute must be letters, dash and underscore only.',
					'selProcs.required'         => 'Error: The :attribute must be selected.',
					'selProcs.selProcs'         => 'Error: The :attribute must be letters, dash and number only.',
					'selProts.required'         => 'Error: The :attribute must be selected.',
					'selProts.selProts'         => 'Error: The :attribute must be letters, dash and number only.',
					'sample_code.required'      => 'Error: The :attribute cannot be empty.',
					'sample_code.sample_code'   => 'Error: The :attribute must be letters, dash and underscore only.',
					'reagent_used.required'     => 'Error: The :attribute cannot be empty.',
					'reagent_used.reagent_used' => 'Error: The :attribute must be letters, dash and underscore only.',
					'reagent_desc.required'     => 'Error: The :attribute cannot be empty.',
					'reagent_desc.reagent_desc' => 'Error: The :attribute must be Letters and Dash only.',
					'resNotes.required'         => 'Error: The :attribute cannot be empty.',
					'resNotes.resNotes'         => 'Error: The :attribute must be Letters and Dash only.',
					'pi_notes.required'         => 'Error: The :attribute cannot be empty.',
					'pi_notes.pi_notes'         => 'Error: The :attribute must be Letters and Dash only.',
					'labook_ref.required'       => 'Error: The :attribute cannot be empty.',
					'labook_ref.labook_ref'     => 'Error: The :attribute must be Date.',
					'ssdtref.required'          => 'Error: The :attribute cannot be empty.',
					'ssdtref.ssdtref'           => 'Error: The :attribute must be Date.',			
				],
				[ 
				  'expt_desc'    => 'Experiment Description',
					'selProcs'     => 'Procedures',
					'selProts'     => 'Protocols',
					'sample_code'  => 'Sample Codes',
					'reagent_used' => 'Reagents Used',					
					'reagent_desc' => 'Reagent Description',
					'resNotes'     => 'Researcher Notes',
					'pi_notes'     => 'PI Notes',
					'labook_ref'   => 'Manual Labook Ref',
					'ssdtref'      => 'Sample Storage / Date Ref'
				]);
				
				if(count($this->inputs) > 0)
				{
					$i=0;
					foreach($this->inputs as $row)
					{	
						$this->inputs[$i]['quantity'] = $this->quantityProd[$i];
						//$this->inputs[$i]['prod_units'] = $this->unit_desc1[$i];
						$this->inputs[$i]['usage'] = $this->usageProd[$i];
						$i = $i + 1;
					}
				}

				if(count($this->inpExptsamps) > 0)
				{
					$j=0;
					foreach($this->inpExptsamps as $row)
					{
						$this->inpExptsamps[$j]['quantity'] = $this->quantitySamp[$j];
						$this->inpExptsamps[$j]['samp_units'] = $this->unit_desc2[$j];
						$this->inpExptsamps[$j]['usage'] = $this->usageSamp[$j];
						$j = $j + 1;
					}
				}
				
				if(count($this->inpReagents) > 0)
				{				
					$k=0;
					foreach($this->inpReagents as $row)
					{
						$this->inpReagents[$k]['quantity'] = $this->quantityReag[$k];
						$this->inpReagents[$k]['reag_units'] = $this->unit_desc3[$k];
						$this->inpReagents[$k]['usage'] = $this->usageReag[$k];
						$k = $k + 1;
					}
				}
				// this is for storing all used chemicals, samples and reagentSelected
				// as json array
				
				$ingradients = [];
				$ingradients['fineChem'] = $this->inputs;
				$ingradients['expSamp'] = $this->inpExptsamps;
				$ingradients['expReag'] = $this->inpReagents;
				$ingradients['reagUsed'] = $this->reagent_used;
				//dd($ingradients);
				//make Experiment object for storage
				$newExpt = new Experiment();

				$newExpt->theme_id = $id;
				$newExpt->allowed_id = Auth::user()->id;
				$newExpt->experiment_description = $this->expt_desc;
				$newExpt->procedure_id = $this->selProcs;
				$newExpt->protocol_id = $this->selProts;
				$newExpt->supplement_expt_id = null;
				$newExpt->supplement_expt_description = null;
				$newExpt->experiment_date = date('Y-m-d');
				$newExpt->reagent_description = $this->reagent_desc;
				$newExpt->reagent_used = $ingradients;
				$newExpt->bulk_storage_date_ref = $this->sample_code;
				$newExpt->user_notes = $this->resNotes;
				$newExpt->pi_notes = $this->pi_notes;
				$newExpt->manual_labnotebook_ref = $this->labook_ref;
				$newExpt->bulk_storage_date_ref = $this->labook_ref;
				$newExpt->entry_date = date('Y-m-d');
				//dd($newExpt);
				$newExpt->save();
				
				$this->dispatch('swal.confirm', ['title'=>'New Experiment Saved']);
				
				$exptId = $newExpt->experiment_id; // real line live...
				//$exptId = 1;  // only for testing...
				//log activity
				Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] saved new expt [ '.$exptId.' ]');
				
				//Handle consumption
				//dd($exptId);
				//now using the inputs array process the usage information
				//especially the quantity left in products table and consumptions tables
				
				// first products table
				foreach($this->inputs as $row)
				{
					// All the code has been shifted to traits in TUpdates dir
					$this->updateConsumptionOfProduct($row, $exptId, $newExpt->entry_date);
				}
				
				// Second experiment samples table, Enter sample usage
				foreach($this->inpExptsamps as $row)
				{
					// All the code has been shifted to traits in TUpdates dir
					$this->updateSampleConsumption($row, $exptId, $newExpt->entry_date);
				}
				
				// Third reagents table, Enter reagent usage
				foreach($this->inpReagents as $row)
				{
					// All the code has been shifted to traits in TUpdates dir
					$this->updateReagentConsumption($row, $exptId, $newExpt->entry_date);
				}				

				$this->dispatch('swal.confirm', ['title'=>'All Updates Completed']);
				$this->resetNewExptForm();
				$this->searchResultBox1 = false;
				$this->searchResultBox2 = false;
				$this->searchResultBox3 = false;
				$this->viewNewExptForm = false;
				
				$this->viewNewTheme = false;
				$this->themeInfoUpdate = true;                        
			}
			else {
			    $this->dispatch('swal.warning', 'Project Permission Error');
			}
		}
		else {
			 $this->alert('swal.warning', 'Role & Permission Error');
		}
	}
	
	////// Download functions 
	public function exptFileDownload($path)
	{
		dd($path);
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] requested image file [ '.$path.' ]');
        
		return response()->download(storage_path("app/public/".$path));
	}
    
	public function exptInfoImgDownload($file)
	{
		//for testing, in reality, pass on the user's folder name fromm DB.
		$piFolder = Auth::user()->folder;

		//$destPath = "institutions"."/".$piFolder."/";
    $destPath = "public/expts/gels/".$this->expt_id."/";
        
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] requested image  file [ '.$destPath.' ]');
        
		return response()->download(storage_path("app/".$destPath.$file));
	}
	
	public function appendUserNotes($expt_id)
	{
		$eun = $this->expt_user_notes;

		if($eun != null) 
		{
			if(count($this->exptFiles) > 0)
			{
				$allowedfileExtension = ['jpeg', 'jpg', 'tiff', 'png', 'pdf', 'doc', 'docx','xls', 'xlsx', 'txt'];
				//for testing, in reality, pass on the user's folder name fromm DB.

				foreach ($this->exptFiles as $key => $value) 
				{
					$filename = $value->getClientOriginalName();
					$oExt = $value->getClientOriginalExtension();
					
					$check=in_array($oExt, $allowedfileExtension);

					if($check )
					{
						$destFolder = "";
						$fileName = "";
						$destFolder = $this->getExtensionLinedFolder($oExt);
						
						$code8 = $this->generateCode(8);
						$fileName = $code8."_"."Expt".$expt_id.".".$oExt;
						$fxt[$key] = $value->storeAs($destFolder, $fileName);
						
						//now insert data into db
						$newimageFile = new Exptimage();
						$newimageFile->experiment_id = $expt_id;
						$newimageFile->user_id = Auth::user()->id;
						$newimageFile->user_name = Auth::user()->name;
						$newimageFile->entry_date = date('Y-m-d');
						$newimageFile->image_file = $fileName;
						$newimageFile->video_file = $fileName;
						$newimageFile->notes = "none";
						$newimageFile->path = $destFolder;
						//dd($newimageFile);
						$newimageFile->save();

						$newExptFile = new Exptfile();
						$newExptFile->experiment_id = $expt_id;
						$newExptFile->user_id = Auth::user()->id;
						$newExptFile->user_name = Auth::user()->name;
						$newExptFile->entry_date = date('Y-m-d');
						$newExptFile->file_type = $oExt;
						$newExptFile->file_name =$fileName;
						$newExptFile->description = "";
						$newExptFile->legend = "";
						$newExptFile->notes = "none";
						$newExptFile->path = $destFolder;
						//dd($newimageFile);
						$newExptFile->save();
						
						Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] saved Image file for experiment id [ '.$expt_id.' ]');
					}
					else {
						$this->icMessage = "File types must be jpeg, jpg, tiff, png and pdf";
						$this->dispatch('swal.confirm',['title'=>$this->icMessage]);
					}
				}
			}
			
			$newNotes = new Exptnote();
			$newNotes->user_id = Auth::user()->id;
			$newNotes->user_name = Auth::user()->name;
			$newNotes->experiment_id = $expt_id;
			$newNotes->exptnotes = $eun;
			$newNotes->pi_notes = null;
			$newNotes->save();
			$this->icMessage = "Success: Notes and Images updated";
			$this->dispatch('swal.confirm', ['title' => $this->icMessage]);
			//log activity
			Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] Experiment notes, images updated for experiment id [ '.$expt_id.' ]');
			//destroy input
			$newNotes = null;
			$eun = null;
			$this->expt_user_notes = null;
			//dd($result, $expt_id, $appNotes, $result);
		}
		else {
			$this->icMessage = "Error: Must Enter User notes and submit again";
			$this->dispatch('swal.confirm',['title'=>$this->icMessage]);
		}
	}

	public function getExtensionLinedFolder($extension)
	{
		$images = ['jpg', 'jpeg', 'tiff', 'png'];
		$documents = ['pdf', 'doc', 'docx','xls', 'xlsx', 'txt'];
		$videos = ['avi', 'wmv', 'mp4'];

		$piFolder = Auth::user()->folder;
				
		$base_root = "app/public/";
    $base = "public/expts/";
		

		if(in_array($extension, $images))
		{
			$sub_base = "images/";
		}
		if(in_array($extension, $documents))
		{
			$sub_base = "documents/";
		}
		if(in_array($extension, $videos))
		{
			$sub_base = "videos/";
		}
		$destPath = $base.$sub_base.$this->expt_id."/";
		return $destPath;
	}

	public function showExptInfo($expt_id)
	{
		$this->viewThemeList = true;
		$this->themeEntryField = false;
		$this->viewNewExptForm = false;
		$this->icMessage = null;

		if( Auth::user()->hasAnyRole(['pisg','researcher']) )
		{
			$this->exptInfos = Experiment::with('exptnotes')
													->with('user')
													//->with('protocols')
													//->with('procedures')
													->with('exptfiles')
													->where('experiment_id', $expt_id)
													->first();
			
			$this->expDetailProtocols	= Protocol::whereIn('protocol_id', $this->exptInfos->protocol_id)->get();
			$this->expDetailProcedures	= Procedure::whereIn('procedure_id', $this->exptInfos->procedure_id)->get();

			$usedReags = $this->exptInfos->reagent_used;
			
			//log activity
			Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] Displayed Info for Experiment ['.$expt_id.']');
			
			if(array_key_exists('reagUsed', $usedReags))
			{
				$this->reagUsed = $usedReags['reagUsed'];
			}
			
			if(array_key_exists('fineChem', $usedReags))
			{
				$this->fineChem = $usedReags['fineChem'];
			}
			
			if(array_key_exists('expSamp', $usedReags))
			{
				$this->expSamp = $usedReags['expSamp'];
			}
			
			if(array_key_exists('expReag', $usedReags))
			{
				$this->userReag = $usedReags['expReag'];
			}
			
			//dd($jUr);
			$this->expt_id     = $this->exptInfos->experiment_id;
			$this->expt_title  = $this->exptInfos->experiment_description;
			$this->exptDetails = true;
			
			//log activity
			Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] Displayed Info for Experiment [ '.$expt_id.' ]');
		}
	}
	
	public function viewExperimentList($theme_id)
	{
		if( Auth::user()->hasAnyRole(['pisg','researcher']) )
		{
			$this->viewThemeList = true;
			$this->themeEntryField = false;
			$this->viewExptList = false;
			$this->exptDetails = false;
			$this->viewNewExptForm = false;

		  Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] displayed Experiment list');
			$this->hydrateThemeInfos($theme_id);
			$this->curExpts = Experiment::where('theme_id', $theme_id)->get();
			$this->viewExptList = true;
		}
		else {
			$this->icMessage="No Permission To View Experiments";
			$this->dispatch('swal:warning', ['title' => $this->icMessage]);
		}
	}	
		
	/**
		* Write code on Method
		*
		* @return response()
		*/
		private function resetInputFields()
		{
			$this->pack_mark_code = '';
			$this->product_id = '';
			$this->prod_name = '';
		}
	
		public function resetNewExptForm()
		{
			$this->expt_desc = null;   
			$this->selProcs = null;  
			$this->selProts = null;  
			$this->sample_code = null;  	
			$this->reagent_used = null;  
			$this->reagent_desc = null;  
			$this->resNotes = null;  
			$this->pi_notes = null;  
			$this->labook_ref = null;  
			$this->ssdtref = null;
			$this->inputs = [];
			$this->inpExptsamps = [];
			$this->inpReagents = [];
			$this->quantityProd = [];
			$this->usageProd = [];
			$this->quantitySamp = [];
			$this->usageSamp = [];
			$this->quantityReag = [];
			$this->usageReag = [];
			$this->unit_desc2 = [];
			$this->unit_desc3 = [];
			
			Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] new experiment form reset');
		}
		
		/////////////////////////////
		public function newGelData()
		{
			$this->alert('info', 'New Electrophoresis Gel Widget opening soon');    
		}
		
		public function newChromatographyInfo()
		{
			$this->alert('info', 'New Chromatography widget opening soon');
		}
		
		public function newMiscData()
		{
			$this->alert('info', 'New Miscellineous Data Opening soon');
		}

		//----------- End of Experiment related code -----------//
}

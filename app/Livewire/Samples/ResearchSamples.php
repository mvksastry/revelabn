<?php

namespace App\Livewire\Samples;

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

//use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Elab\Theme;
use App\Models\Elab\Experiment;
//use App\Models\Elab\Erecord;
use App\Models\Elab\Exptimage;
use App\Models\Elab\Exptnote;
use App\Models\Elab\Exptsample;
use App\Models\Elab\Repository;

use App\Traits\Base;

use App\Traits\TCommon\FileUploadHandler;
use Livewire\WithFileUploads;
use Validator;

use Livewire\WithPagination;

use App\Imports\ExptsamplesImport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ResearchSamples extends Component
{
	use Base;
	use FileUploadHandler;
	use WithFileUploads;
	use WithPagination;
	//
	//use LivewireAlert;
	//
  public $message;
	
	//landing page variables
	public $repos, $repository_id;
	
	//repository container 
	public $repositInfo, $repositSelected;
	
	//sample entry form variables
	public $sampCode, $sample_desc, $sample_type, $sample_species, $user_code, $bulk_code, $series_code;
	public $sample_remark, $sample_tags, $source_desc, $source_ref, $compart_id, $holder_sack, $box_sack;
	
	//sample list variables
	public $sampleList;
	public $curSampleList = false;
	public $sampCount;
	
	//sample search variables
	//public $sampCodeSearch, $mixedCodeSearch, $sampDescSearch;
	//public $containerIdSearch, $sampSourceSearch, $sampRemarkSearch;
	public $searchParam1, $searchParam2, $searchParam3, $searchParam4, $searchParam5, $searchParam6;
	
	public $searchSampleCode, $searchMixedCode, $searchSampDesc;
	public $searchSampleType, $searchSampSource, $searchSampRemark;
	public $code1, $code2, $code3, $code4, $code5, $code6;
	
	//sample search window
	public $searchResult = false;
	public $sampleDetails = false;
	public $fullSampleDetail;
	
	//panel variables
	public $viewContainerInf = false;
	public $viewSingleSampleForm = false;
	public $viewBulkUploadForm = false;
	public $viewSamples = false;
	
	//upload panel variables
	public $sampleExcel=[];
	
	public $error_sample_desc;

	public function render()
	{
		$repos = Repository::all();
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Research Sample Home page displayed');
		
		return view('livewire.samples.research-samples')->with(['reposActive'=>$repos]);
	}
    
	public function fetchContainerInfo($repository_id)
	{
			$this->repository_id = $repository_id;
			$this->repositSelected = Repository::where('repository_id', $repository_id)->get();
			
			$this->viewBulkUploadForm = false;
			$this->viewSingleSampleForm = false;
			$this->viewSamples = false;
			$this->viewContainerInf = true;
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Container Info page displayed');
			//dd($repository_id);
	}
    
	public function viewSampleListByContainerId($repository_id)
	{
			//$this->sampleList = Exptsample::where('repository_id', $repository_id)->paginate(1);
			$this->sampleList = Exptsample::where('repository_id', $repository_id)
																			->where('posted_by', Auth::user()->id)
																			->get();

			$this->fullSampleDetail = null;
			$curSampleList = true;
			
			if(count($this->sampleList) > 0 )
			{
					//$this->sampCount = count($this->sampleList);
					$this->curSampleList = true;
			}
			else {
					$this->curSampleList = [];
			}
			
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Sample List/Info page displayed');
			
			$this->viewBulkUploadForm = false;
			$this->viewSingleSampleForm = false;
			$this->sampleDetails = false;
			$this->viewContainerInf = true;
			$this->viewSamples = true;
	}
    
	public function viewSampleDetils($exptsample_id)
	{
		$this->fullSampleDetail = Exptsample::where('exptsample_id', $exptsample_id)->get();
		//dd($this->fullSampleDetail);
		
		$this->sampleDetails = true;
			
		foreach($this->fullSampleDetail as $row)
		{
				$this->sampCode = $row->sample_code;
				$this->sample_desc = $row->description;
				$this->sample_type = $row->type;
				$this->sample_species = $row->species;
				$this->user_code = $row->user_code;
				$this->bulk_code = $row->bulk_code;
				$this->series_code = $row->series_code;
				$this->source_desc = $row->source;
				$this->source_ref = $row->source_ref;
				$this->posted_by = $row->posted_by;
				$this->posted_name = $row->posted_name;
				$this->posted_date = $row->posted_date;
				$this->sample_remark = $row->sample_remark;
				$this->sample_tags = $row->tags;
				$this->repository_id = $row->repository_id;
				$this->compart_id = $row->compartment_id;
				$this->holder_sack = $row->holder_id;
				$this->box_sack = $row->box_id;
		}
			
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Sample Details page displayed');
	}
    
	//single sample addition
	public function singleSampleForm($repository_id)
	{
			$this->repository_id = $repository_id;
			$this->repositSelected = Repository::where('repository_id', $repository_id)->get();
			$this->sampCode = $this->generateCode(6);
			
			//dd($this->sampCode);
			//dd($this->repositSelected);
			//$this->repositInfo = Exptsamples::where('repository_id', $repository_id)->get();
			
			$this->viewBulkUploadForm = false;
			$this->viewSamples = false;
			$this->viewContainerInf = true;
			$this->viewSingleSampleForm = true;
			//dd($repository_id);
			
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Sample Sample addition Form displayed');
	}
    
	public function processSingleSampleDetails($repository_id)
	{
		//dd($repository_id);
		//make new object
		$expSamps = new Exptsample();
		
		$this->validate(['sampCode' => 'required']);
		$expSamps->sample_code = $this->sampCode;
		
		$this->validate(['sample_species' => 'required']);
		$expSamps->species = $this->sample_species;

		$this->validate(['sample_type' => 'required']);
		$expSamps->type = $this->sample_type;
		
		$this->validate(['sample_desc' => 'required']);
		$expSamps->description = $this->sample_desc;
		
		$expSamps->user_code = $this->user_code;
		$expSamps->bulk_code = $this->bulk_code;
		$expSamps->series_code = $this->series_code;
		
		$this->validate(['source_desc' => 'required']);
		$expSamps->source = $this->source_desc;
		
		$this->validate(['source_ref' => 'required']);
		$expSamps->source_ref = $this->source_ref;
		
		$expSamps->posted_by = Auth::user()->id;
		$expSamps->posted_name = Auth::user()->name;
		$expSamps->posted_date = date('Y-m-d');
		
		$this->validate(['sample_remark' => 'required']);
		$expSamps->sample_remark = $this->sample_remark;
		
		$expSamps->tags = $this->sample_tags;
		
		$this->validate(['repository_id' => 'required']);
		$expSamps->repository_id = $this->repository_id;
		
		$this->validate(['compart_id' => 'required']);
		$expSamps->compartment_id = $this->compart_id;
		
		$this->validate(['holder_sack' => 'required']);
		$expSamps->holder_id = $this->holder_sack;
		
		$this->validate(['box_sack' => 'required']);
		$expSamps->box_id = $this->box_sack;
		
		$expSamps->save();
		$this->alert('success', 'New Sample Added');
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] New Sample [ '.$this->sampCode.' ] saved');
		
		$this->viewSingleSampleForm = false;
		//dd($expSamps);
	}
    
	//bulk sample addition
	
	public function downloadTemplate()
	{
			$this->alert('success', 'Template Download in Progress');
	}
    
	public function bulkUploadForm($repository_id)
	{
		$this->repositSelected = Repository::where('repository_id', $repository_id)->get();
		$this->sampCode = $this->generateCode(6);
		//dd($repository_id);
		
		$this->viewSingleSampleForm = false;
		$this->viewSamples = false;
		$this->viewContainerInf = true;
		$this->viewBulkUploadForm = true;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Bulk upload Form for Sample Displayed');
	}
    
    public function processBulkUpload(Request $request)
    {
			//dd($repository_id);
			// we dont need the container id as it is going to be
			//entered through the sheet, just left the info for future use, if any.
			
			//now we need to invoke the excel object and retrieve the data.
			if(count($this->sampleExcel) > 0)
			{
				$allowedExtension = ['xls', 'xlsx'];
				//for testing, in reality, pass on the user's folder name fromm DB.
				$piFolder = Auth::user()->folder;
				$destPath = "public/institutions"."/".$piFolder."/";
				foreach ($this->sampleExcel as $key => $value) 
				{
					$filename = $value->getClientOriginalName();
					$oExt = $value->getClientOriginalExtension();
					$check=in_array($oExt, $allowedExtension);
					
					if($check )
					{
						$fileName = "";
						$code8 = $this->generateCode(8);
						$fileName = $code8."_".Auth::user()->id.".".$oExt;
						$fxt[$key] = $value->storeAs($destPath, $fileName);
						//dd($destPath.$fileName);
						$data = Excel::import(new ExptsamplesImport, $destPath.$fileName);
						
						$this->sampleExcel = null;
						$this->alert('success', 'Sample Import Successful');
						$this->irqMessage = "Sample Import Successful";		
					}
					else {
						$this->irqMessage = "File types must be jpeg, jpg, tiff and pdf";
						dd($this->irqMessage);
					}                
				}
			}
			$this->alert('warning', 'Excel Sheet Error or Check Excel sheet ');
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Bulk Upload Not Completed');
			//return back()->with('success', 'User Imported Successfully.');
    }
    
		
	//select samples for experiments
	//search samples
	/**
	 * Write code on Method
	 *
	 * @return response()
	 */
     
	public function updatedSearchSampleCode($code1)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for Sample Code [ '.$code1.' ]');
			$this->sampCodeSearch($code1);
	}
    
	public function sampCodeSearch($code1)
	{
			
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for Sample Code [ '.$code1.' ]');
			$this->searchParam1 = $code1;
	}
    
	// mixed code search
	public function updatedSearchMixedCode($code2)
	{
			$this->mixedCodeSearch($code2);
	}
    
	public function mixedCodeSearch($code2)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for mixed Sample Code [ '.$code2.' ]');
			$this->searchParam2 = $code2;
	}
    
    
	// sample description search
	public function updatedSearchSampDesc($code3)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for desc  Sample Code [ '.$code3.' ]');
			$this->sampDescSearch($code3);
	}

	public function sampDescSearch($code3)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for desc  Sample Code [ '.$code3.' ]');
			$this->searchParam3 = $code3;
	}

	// sample type search
	public function updatedSearchSampleType($code4)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for type  Sample Code [ '.$code4.' ]');
			$this->sampleTypeSearch($code4);
	}
    
	public function sampleTypeSearch($code4)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for type  Sample Code [ '.$code4.' ]');
			$this->searchParam4 = $code4;
	}
    
	// sample source search
	public function updatedSearchSampSource($code5)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for source  Sample Code [ '.$code5.' ]');
			$this->sampSourceSearch($code5);
	}
    
	public function sampSourceSearch($code5)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for source  Sample Code [ '.$code5.' ]');
			$this->searchParam5 = $code5;
	}
    
	// sample remark search
	public function updatedSearchSampRemark($code6)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for remarks  Sample Code [ '.$code6.' ]');
			$this->sampRemarkSearch($code6);
	}
	public function sampRemarkSearch($code6)
	{
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Searched for remarks  Sample Code [ '.$code6.' ]');
			$this->searchParam6 = $code6;
	}
}
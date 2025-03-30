<?php

namespace App\Livewire\Samples;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

use App\Imports\ExptsamplesImport;
use Maatwebsite\Excel\Facades\Excel;

//models
use App\Models\Elab\Exptsample;

//Traits
use App\Traits\Base;

class BulkImportSamples extends Component
{
  use WithFileUploads;
  use WithPagination;
  use Base;

  public $uncuratedSamples;
  public $irqMessage;

  //sample entry form variables
	public $sampx=[], $sampy=[], $sampId, $action = [];
  
  #[Validate('mimes:xls, xlsx,|max:1024')] // 1MB Max
  public $excel_sample_file;

  //
  public $showFileUploadPanel = true;
  public $showUploadResultPanel = false;
  
  public $selectedFileName = null;

  public $samplesUploadedForReview = [];

  public function render()
  {
      return view('livewire.samples.bulk-import-samples');
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
		$this->viewSingleSampleForm = false;
		$this->viewSamples = false;
		$this->viewContainerInf = true;
		$this->viewBulkUploadForm = true;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Bulk upload Form for Sample Displayed');
	}
    
  public function executeSampleBulkUpload()
  {
    // we dont need the container id as it is going to be
    //entered through the sheet, just left the info for future use, if any.

    //now we need to invoke the excel object and retrieve the data.
    if(count($this->excel_sample_file) > 0)
    {
      
      $allowedExtension = ['xls', 'xlsx'];
      //for testing, in reality, pass on the user's folder name fromm DB.
      //$piFolder = Auth::user()->folder;
      $destPath = "public/imports/";
      foreach ($this->excel_sample_file as $key => $value) 
      {
        $filename = $value->getClientOriginalName();
        $this->selectedFileName = $filename;
        $oExt = $value->getClientOriginalExtension();
        $check=in_array($oExt, $allowedExtension);
            
        if($check)
        {
          $fileName = "";
          $code8 = $this->generateCode(8);
          $fileName = $code8."_".Auth::user()->id.".".$oExt;
          $fxt[$key] = $value->storeAs($destPath, $fileName);
          
          $data = Excel::import(new ExptsamplesImport, $destPath.$fileName);
          
          $this->excel_sample_file = null;
          $msg = "Sample Import Successful";
		      $this->dispatch('swal:confirm', ['title' => $msg]);
          
          $this->irqMessage = "Sample Import Successful";		
          Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Bulk Upload Completed');
          $this->showFileUploadPanel = false;
        }
        else {
          $msg = "File types must be .xls or .xlsx";
		      $this->dispatch('swal:confirm', ['title' => $msg]);          
        }                
      }
    }
    else {
      $msg = "File types must be .xls or .xlsx";
      $this->dispatch('swal:warning', ['title' => $msg]);   
      Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Bulk Upload Not Completed');
      //return back()->with('success', 'User Imported Successfully.');
    }
    
  }

  public function curateSamples()
  {
    $this->uncuratedSamples = Exptsample::where('isCurated', 'no')->get();
    //dd($this->uncuratedSamples);
    $msg = "Uncurated Sample Found";
		$this->dispatch('swal:confirm', ['title' => $msg]); 
    $this->setCurationData();
    $this->showFileUploadPanel = false;
    $this->showUploadResultPanel = true;

    $this->dispatch('dataTableInit'); 
    //dd($uncuratedSamples);
  }

  public function setCurationData()
  {
    foreach($this->uncuratedSamples as $value)
    {
      $this->sampx[$value->exptsample_id]['exptsample_id'] = $value->exptsample_id;
      $this->sampx[$value->exptsample_id]['sample_code'] = $value->sample_code;
      $this->sampx[$value->exptsample_id]['description'] = $value->description;
      $this->sampx[$value->exptsample_id]['type'] = $value->type;
      $this->sampx[$value->exptsample_id]['species'] = $value->species;
      $this->sampx[$value->exptsample_id]['user_code'] = $value->user_code;
      $this->sampx[$value->exptsample_id]['bulk_code'] = $value->bulk_code;
      $this->sampx[$value->exptsample_id]['series_code'] = $value->series_code;
      $this->sampx[$value->exptsample_id]['source'] = $value->source;
      $this->sampx[$value->exptsample_id]['source_ref'] = $value->source_ref;
      $this->sampx[$value->exptsample_id]['posted_by'] = $value->posted_by;
      $this->sampx[$value->exptsample_id]['posted_name'] = $value->posted_name;
      $this->sampx[$value->exptsample_id]['posted_date'] = $value->posted_date;
      $this->sampx[$value->exptsample_id]['sample_remark'] = $value->sample_remark;
      $this->sampx[$value->exptsample_id]['tags'] = $value->tags;
      $this->sampx[$value->exptsample_id]['repository_id'] = $value->repository_id;
      $this->sampx[$value->exptsample_id]['compartment_id'] = $value->compartment_id;
      $this->sampx[$value->exptsample_id]['holder_id'] = $value->holder_id;
      $this->sampx[$value->exptsample_id]['box_id'] = $value->box_id;
      $this->sampx[$value->exptsample_id]['isCurated'] = $value->isCurated;
    }
  }

  public function executeSampleCuration()
  {
    //dd("reached", $this->sampx);
    foreach($this->sampx as $key => $value) {
      Exptsample::where('exptsample_id', $key)->update($value);
    }
    $this->uncuratedSamples = [];
    $this->sampx = [];
    $this->curateSamples();
    $this->showUploadResultPanel = false;
  }
    
}

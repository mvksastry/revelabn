<?php

namespace App\Livewire\Elab\Elabnotes;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Elab\Procedure;


use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
use Validator;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ResearchProcedures extends Component
{
  use Base;
  use WithFileUploads;
  use FileUploadHandler;
  //
	//use LivewireAlert;
	//
  
	public $msgx;
	public $message;

	public $procTitle, $procDesc, $procVersionId, $procApprovedBy, $procApprovedDate;
	public $procApprovedRef, $procAuthority, $procValidTill;
	
	//file variable
  #[Validate('max:2048')] // 1MB Max
	public $resProcs = [];

  public $fileName = null;
	
	//messages
	public $lwMessage;

  //panels
  public $viewNewSOPForm = false;
	
  public function render()
  {
    if(Auth::user()->hasAnyRole('pisg'))
    {
      $procedures = Procedure::where('pi_id', Auth::id())->get();
      // log the activity
      Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed research procedure home page');  
      return view('livewire.elab.elabnotes.procedures.research-procedures')->with(['procedures'=>$procedures]);
      $this->message = "SO Procedures loaded";
		  $this->dispatch('swal:confirm', ['title' => $this->message]);
    }
    else {
      $this->message = "No permission to view";
		  $this->dispatch('swal:warning', ['title' => $message]);
    }
  }

  public function showProcedureEntryForm()
  {
    //dd("reached");
    $this->viewNewSOPForm = true;
    $this->message = "SO Procedures Form loaded";
		$this->dispatch('swal:confirm', ['title' => $this->message]);
  }

	public function addNew()
  {
   
    $validatedData = $this->validate(
    [
      'procTitle'        => 'required|string|regex:/^[A-Za-z0-9:-_., ]+$/',
      'procDesc'         => 'required|string|regex:/^[A-Za-z0-9:-_., ]+$/',
      'procVersionId'    => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'procApprovedBy'   => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'procApprovedDate' => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'procApprovedRef'  => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'procAuthority'    => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'procValidTill'    => 'required|date',
      'resProcs.*'         => 'required|mimes:doc,docx,pdf|max:2048'
    ],
    [
      'procTitle.required'               => 'Error: The :attribute cannot be empty.',
      'procTitle.procTitle'              => 'Error: The :attribute must be letters, dash and underscore only.',
      'procDesc.required'                => 'Error: The :attribute cannot be empty.',
      'procDesc.procDesc'                => 'Error: The :attribute must be letters, dash and underscore only.',
      'procVersionId.required'           => 'Error: The :attribute cannot be empty.',
      'procVersionId.procVersionId'      => 'Error: The :attribute must be letters, dash and underscore only.',
      'procApprovedBy.required'          => 'Error: The :attribute cannot be empty.',
      'procApprovedBy.procApprovedBy'    => 'Error: The :attribute must be Letters and Dash only.',
      'procApprovedDate.required'        => 'Error: The :attribute cannot be empty.',
      'procApprovedDate.procApprovedDate'=> 'Error: The :attribute must be Letters and Dash only.',
      'procApprovedRef.required'         => 'Error: The :attribute cannot be empty.',
      'procApprovedRef.procApprovedRef'  => 'Error: The :attribute must be Letters and Dash only.',
      'procAuthority.required'           => 'Error: The :attribute cannot be empty.',
      'procAuthority.procAuthority'      => 'Error: The :attribute must be Letters and Dash only.',
      'procValidTill.required'           => 'Error: The :attribute cannot be empty.',
      'procValidTill.procValidTill'      => 'Error: The :attribute must be Date.',
      'resProcs.required'                => 'Error: The :attribute file is required',
      'resProcs.mimes'                   => 'Error: The :attribute must be doc, docx or pdf only',
      'resProcs.max'                     => 'Error: The :attribute must not larger than 2 MB'

    ],
    [ 
      'procTitle'        => 'Title',
      'procDesc'         => 'Description',
      'procVersionId'    => 'Version Id',
      'procApprovedBy'   => 'Approved By',
      'procApprovedDate' => 'Approval Date',
      'procApprovedRef'  => 'Approval Reference',
      'procAuthority'    => 'Authority',
      'procValidTill'    => 'Validity Date',
      'resProcs'         => 'SOProcedure'
    ]);
    
		if(count($this->resProcs) > 0)
		{
				foreach($this->resProcs as $key => $value)
        {
          $result = $this->soProcedureFileUpload($value);
        }
				
        $procs = new Procedure();
        $procs->department_id = 0;
        $procs->title = $this->procTitle;
        $procs->description = $this->procDesc;
        $procs->version_id = $this->procVersionId;
        $procs->filename = $result['fileName'];
        $procs->file_path = $result['file_path'];
        $procs->approved_by = $this->procApprovedBy;
        $procs->approved_date = $this->procApprovedDate;
        $procs->approved_reference = $this->procApprovedRef;
        $procs->approved_authority = $this->procAuthority;
        $procs->validity_date =  $this->procValidTill;
        $procs->pi_id =  Auth::id();
        $procs->status = 'Active';

        $procs->save();
        //$this->alert('success', 'New Research Protocol Added');
        // log the activity
        
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved research procedure ['.$this->procTitle.']');  

        $this->lwMessage = "New Protocol Added";
        $this->resetProcedureForm();
        $this->resPocs = null;
        $this->viewNewSOPForm = false;
			
		}
		else {
		  //$this->alert('warning', 'File Not Selected');
		}
  }
    
  public function resetProcedureForm()
  {
    //  $this->dept = null;
    //  $this->actvits = null;
    $this->procTitle = null;
    $this->procDesc = null;
    $this->procVersionId = null;
    $this->procApprovedBy = null;
    $this->procApprovedDate = null;
    $this->procApprovedRef = null;
    $this->procAuthority = null;
    $this->procValidTill = null;
    // log the activity
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] research procedure form reset');  
  }
    
  public function downloadSOProcfile($filename)
  {
    //for testing, in reality, pass on the user's folder name fromm DB.
    $destPath = "app/public/soprocs/";
    return response()->download(storage_path($destPath.$filename));
  }
}

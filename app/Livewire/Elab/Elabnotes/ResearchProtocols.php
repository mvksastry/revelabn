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

use App\Models\Elab\Protocol;

use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;

use Validator;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ResearchProtocols extends Component
{
  use Base;
  use WithFileUploads;
  use FileUploadHandler;
  //
	//use LivewireAlert;
	//
	public $msgx;
	public $message;
  
	public $title, $description, $versionId, $approvedBy, $approvedDate;
	public $approvedRef, $authority, $validTill, $lwMessage;
		
	//file variable

	public $resSOPs=[];
  public $filename = null;

  //panels
  public $viewNewSOPForm = false;
	
 	public function render()
	{
		if(Auth::user()->hasAnyRole('pisg','researcher'))
		{
			$protocols = Protocol::where('pi_id', Auth::id())->get();
      // log the activity
      Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed research protocol home page');  
			return view('livewire.elab.elabnotes.protocols.research-protocols')->with(['protocols'=>$protocols]);
    }
    else {

    }
	}

  public function showProtocolEntryForm()
  {
    //dd("reached");
    $this->viewNewSOPForm = true;
    $this->message = "SO Protocol Form loaded";
		$this->dispatch('swal:confirm', ['title' => $this->message]);
  }

	public function addNew()
	{
    $validatedData = $this->validate(
    [
      'title'        => 'required|string|regex:/^[A-Za-z0-9:-_. ]+$/',
      'description'  => 'required|string|regex:/^[A-Za-z0-9:-_. ]+$/',
      'versionId'    => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'approvedBy'   => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'approvedDate' => 'required|date',
      'approvedRef'  => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'authority'    => 'required|string|regex:/^[A-Za-z0-9-_. ]+$/',
      'validTill'    => 'required|date',
      'resSOPs.*'      => 'required|mimes:doc,docx,pdf|max:2048'
    ],
    [
      'title.required'           => 'Error: The :attribute cannot be empty.',
      'title.title'              => 'Error: The :attribute must be letters, dash and underscore only.',
      'description.required'     => 'Error: The :attribute cannot be empty.',
      'description.description'  => 'Error: The :attribute must be letters, dash and underscore only.',
      'versionId.required'       => 'Error: The :attribute cannot be empty.',
      'versionId.versionId'      => 'Error: The :attribute must be letters, dash and underscore only.',
      'approvedBy.required'      => 'Error: The :attribute cannot be empty.',
      'approvedBy.approvedBy'    => 'Error: The :attribute must be Letters and Dash only.',
      'approvedDate.required'    => 'Error: The :attribute cannot be empty.',
      'approvedDate.approvedDate'=> 'Error: The :attribute must be Letters and Dash only.',
      'approvedRef.required'     => 'Error: The :attribute cannot be empty.',
      'approvedRef.approvedRef'  => 'Error: The :attribute must be Letters and Dash only.',
      'authority.required'       => 'Error: The :attribute cannot be empty.',
      'authority.authority'      => 'Error: The :attribute must be Letters and Dash only.',
      'validTill.required'       => 'Error: The :attribute cannot be empty.',
      'validTill.validTill'      => 'Error: The :attribute must be Date.',
      'resSOPs.required'        => 'Error: The :attribute file is required',
      'resSOPs.mimes'           => 'Error: The :attribute must be doc, docx or pdf only',
      'resSOPs.max'             => 'Error: The :attribute must not larger than 2 MB'
    ],
    [ 
      'title'        => 'Title',
      'description'  => 'Description',
      'versionId'    => 'Version Id',
      'approvedBy'   => 'Approved By',
      'approvedDate' => 'Approval Date',
      'approvedRef'  => 'Approval Reference',
      'authority'    => 'Authority',
      'validTill'    => 'Validity Date',
      'resSOPs'      => 'SOProtocols'
    ]);

    foreach($this->resSOPs as $key => $value)
    {
      $result = $this->soProtocolFileUpload($value);
    }
    //upload the file and get the filename and path
    //$result = $this->soProtocolFileUpload($this->resSOPs);

    // not put to db all the info
    $proto = new Protocol();
    $proto->title = $this->title;
    $proto->description = $this-> description;
    $proto->version_id = $this->versionId;
    $proto->filename = $result['fileName'];
    $proto->file_path = $result['file_path'];
    $proto->approved_by = $this->approvedBy;
    $proto->approved_date = $this->approvedDate;
    $proto->approved_reference = $this->approvedRef;
    $proto->approved_authority = $this->authority;
    $proto->validity_date =  $this->validTill;
    $proto->pi_id =  Auth::id();
    $proto->status = 'active';
    $proto->save();
    
    // log the activity
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved research protocol ['.$this->title.']');  
    
    $this->lwMessage = "New Protocol Added";
    $this->resetProtocolForm();
    $proto = null;
	}
	
	public function resetProtocolForm()
	{
		$this->title = null;
		$this->description = null;
		$this->versionId = null;
		$this->approvedBy = null;
		$this->approvedDate = null;
		$this->approvedRef = null;
		$this->authority = null;
		$this->validTill = null;
		$this->lwMessage = "";
    $this->resSOPs = null;
    // log the activity
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] research protocol form reset');  

	}
	
	public function downloadSOPfile($filename)
  {
    //for testing, in reality, pass on the user's folder name fromm DB.
    $destPath = "app/public/sops/";
    //return response()->download(storage_path($destPath.$filename));
  }
}
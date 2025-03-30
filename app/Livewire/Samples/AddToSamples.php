<?php

namespace App\Livewire\Samples;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

// Models
use App\Models\Elab\Exptsample;
use App\Models\Elab\Repository;

// Traits
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;

// Framework helpers
use Log;
use Validator;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

//Validation of product form
use App\Livewire\Forms\Samples\SampleForm;

class AddToSamples extends Component
{
    //form validation
	public SampleForm $form;

    use Base;
	use FileUploadHandler;
	use WithFileUploads;
	use WithPagination;

	//Swal 
    public $message;

    //sample entry form variables
	public $sampCode, $sample_desc, $sample_type, $sample_species, $user_code, $bulk_code, $series_code;
	public $sample_remark, $sample_tags, $source_desc, $source_ref, $compart_id, $holder_sack, $box_sack;

    public function render()
    {
        return view('livewire.samples.add-to-samples');
    }

    public function processSingleSampleDetails()
	{
        $this->validate();

		$expSamps = new Exptsample();
		$expSamps->sample_code = $this->form->sampCode;
		$expSamps->species = $this->form->sample_species;
		$expSamps->type = $this->form->sample_type;
		$expSamps->description = $this->form->sample_desc;
		$expSamps->user_code = $this->form->user_code;
		$expSamps->bulk_code = $this->form->bulk_code;
		$expSamps->series_code = $this->form->series_code;
		$expSamps->source = $this->form->source_desc;
		$expSamps->source_ref = $this->form->source_ref;
		$expSamps->posted_by = Auth::user()->id;
		$expSamps->posted_name = Auth::user()->name;
		$expSamps->posted_date = date('Y-m-d');
		$expSamps->sample_remark = $this->form->sample_remark;
		$expSamps->tags = $this->form->sample_tags;
		$expSamps->repository_id = $this->form->repository_id;
		$expSamps->compartment_id = $this->form->compart_id;
		$expSamps->holder_id = $this->form->holder_sack;
		$expSamps->box_id = $this->form->box_sack;
		$expSamps->isCurated = 'yes';
		//dd($expSamps);
		$expSamps->save();
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] New Sample [ '.$this->sampCode.' ] saved');
		//$this->viewSingleSampleForm = false;
		//dd($expSamps);
	}
}

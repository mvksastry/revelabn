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

use App\Models\Elab\Repository;
use App\Models\Elab\Exptsample;

use App\Traits\Base;

//Validation of product form
use App\Livewire\Forms\Samples\RepositoryForm;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class AddRepository extends Component
{
  //form validation
	public RepositoryForm $form;

  use Base;
  // swal message
  public $message;

  public $repositories = [];
  public $contentsRepository = [];

  //form variables
  public $reposit_type, $reposit_desc, $reposit_capacity;
  public $building, $floor, $room;
  public $in_charge, $keys_with;

  //repository contents
  public $reposit_name;

  //panels
  public $showRepositForm = false;
  public $repositContents = false;

  public function render()
  {
    $this->repositories = Repository::where('status','active')->get();
    //dd($repositories);
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Repository Home page displayed');
    return view('livewire.samples.add-repository');
  }

  public function showNewRepositForm()
  {
    $this->showRepositForm = true;
    $this->repositContents = false;
  }

  public function processAddNewRepository()
  {
    $this->message = null;
    $this->validate();

    $nreposit = new Repository();

    $nreposit->repository_type = $this->form->reposit_type;
    $nreposit->posted_by = Auth::user()->name;
    $nreposit->description = $this->form->reposit_desc;
    $nreposit->capacity = $this->form->reposit_capacity;
    $nreposit->building = $this->form->building;
    $nreposit->floor = $this->form->floor;
    $nreposit->room = $this->form->room;
    $nreposit->incharge = $this->form->in_charge;
    $nreposit->keys_with = $this->form->keys_with;
    $nreposit->notes = $this->form->notes;
    $nreposit->status = 'active';
    //dd($nreposit);
    $nreposit->save();

    //
    Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved inventory info [ '.$this->form->reposit_desc.' ]');
    $this->message = "New Repository Entry Success";
    $this->dispatch('swal:confirm', ['title' => $this->message]);
    $this->resetRepositoryForm();
    $this->showRepositForm = false;
  }

  public function resetRepositoryForm()
  {
    $this->form->reposit_type = null;
    
    $this->form->reposit_desc = null;
    $this->form->reposit_capacity = null;
    $this->form->building = null;
    $this->form->floor = null;
    $this->form->room = null;
    $this->form->in_charge = null;
    $this->form->keys_with = null;
    $this->form->notes = null;
  }


  public function contentsRepositoryById($repository_id)
  {
    $this->contentsRepository = Exptsample::where('repository_id', $repository_id)->get();
    $this->reposit_name = Repository::pluck('description');
    //dd($this->reposit_name[0]);
    $this->showRepositForm = false;
    $this->repositContents = true;
  }
}

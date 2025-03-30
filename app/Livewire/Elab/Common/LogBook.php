<?php

namespace App\Livewire\Elab\Common;

use Livewire\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Common\Infrastructure;
use App\Models\Elab\Logentries;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class LogBook extends Component
{
   	//variables
	public $activeInfras=[], $logEntries=[];
	public $infraName;
	public $newLogEntry=[];
	public $selectedInfraId;
	//
	
	protected $rules = [
		'newLogEntry.start_hour'   => 'required|numeric|min:0|max:23',
		'newLogEntry.start_min'    => 'required|numeric|min:0|max:59',
		'newLogEntry.end_hour'     => 'required|numeric|min:0|max:23',
		'newLogEntry.end_min'      => 'required|numeric|min:0|max:59',
		'newLogEntry.accessories'  => 'required|string|regex:/^[A-Za-z0-9:-_. ]+$/',
		'newLogEntry.remarks'      => 'required|string|regex:/^[A-Za-z0-9:-_. ]+$/',
    ];
	 
	 protected $messages = [
        'newLogEntry.start_hour.required' => 'The Start Hour required.',
        'newLogEntry.start_hour.newLogEntry.start_hour' => 'The Start Hour formatis not valid.',
        
        'newLogEntry.start_min.required' => 'The Start Minutes required.',
        'newLogEntry.start_min.newLogEntry.start_min' => 'The Start Min format is not valid.',
        
        'newLogEntry.end_hour.required' => 'The End Hour required.',
        'newLogEntry.end_hour.newLogEntry.end_hour' => 'The End Hour formatis not valid.',
        
        'newLogEntry.end_min.required' => 'The End Minutes required.',
        'newLogEntry.end_min.newLogEntry.end_min' => 'The End Min format is not valid.',
        
        'newLogEntry.accessories.required' => 'The Accessories required.',
        'newLogEntry.accessories.newLogEntry.accessories' => 'The Accessories format is not valid.',
        
        'newLogEntry.remarks.required' => 'The Remarks required.',
        'newLogEntry.remarks.newLogEntry.remarks' => 'The Remarks format is not valid.',
		  
    ]; 
 
    protected $validationAttributes = [
        'newLogEntry.start_hour' => 'The Start Hour',
        'newLogEntry.start_min' => 'The Start Min',
        'newLogEntry.end_hour' => 'The End Hour',
        'newLogEntry.end_hour' => 'The End Min',
        'newLogEntry.accessories' => 'The Accessories',
        'newLogEntry.remarks' => 'The Remarks'
		  
    ];
	 
	
	//panels
	public $isLogEntryPanelOpen = false;
	
	public function render()
	{
		$this->activeInfras = Infrastructure::all();
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Log Book page displayed');
		
		return view('livewire.elab.common.log-book');
	}
	
	
	public function createLogEntry($selectedInfraId)
	{
		//dd("reached");
		$this->selectedInfraId = $selectedInfraId;
		$this->infraName = Infrastructure::where('infra_id', $selectedInfraId)->pluck('name');

		$this->logEntries = Logentries::with('infra')
												->with('user')
												->where('infra_id', $selectedInfraId)
												->get();
		//dd($this->logEntries);
		$this->isLogEntryPanelOpen = true;
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Infr id selected [ '.$selectedInfraId.' ]');
		
	}
	
	public function saveNewLogEntry()
	{
		$this->validate();
		//dd($this->selectedInfraId);
		$this->newLogEntry['infra_id'] = $this->selectedInfraId;
		$this->newLogEntry['user_id'] = Auth::user()->id;
		$this->newLogEntry['status'] = "ok";
		Logentries::create($this->newLogEntry);
		$this->isLogEntryPanelOpen = false;
		unset($this->newLogEntry);
		//dd($this->newLogEntry);
		$this->dispatch('swal.confirm', 'Logbook Enrtry Successfull');
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] new logbook entry for Infra id [ '.$this->selectedInfraId.' ] saved');
	}
}

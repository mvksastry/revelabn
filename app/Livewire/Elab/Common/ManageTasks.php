<?php

namespace App\Livewire\Elab\Common;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Common\Task;

use App\Traits\Base;

use Validator;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class ManageTasks extends Component
{
  use Base;
	//
	public $taskText, $category, $lwMessage;

	public function render()
	{
		if( Auth::user()->hasAnyRole('pisg','pient','investigator','researcher','facility_help','veterinarian') )
		{
			$personalTasks = Task::with('user')->where('self_id', Auth::id())
											->where('status', 'Active')->where('category', 'personal')
								 			->get();
			$groupTasks = Task::with('user')->where('category', 'group')->where('status', 'Active')
								 		->get();

      Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Displayed Group Task from to user');
            
			//implement here cost, issues and consumption details one by one
			return view('livewire.elab.common.manage-tasks')
					  ->with(['personalTasks'=>$personalTasks, 'groupTasks'=> $groupTasks]);
		}
		else {
		 $this->dispatch('swal.warning', 'No Permission to view');   
		 return view('livewire.permError');
		}
	}

  public function markAsDone($id)
  {
		$task = Task::where('task_id', $id)
									->where('self_id', Auth::id())
									->first();
		$task->status = 'Done';
		$task->save();
		$this->dispatch('swal.confirm', 'Status updated'); 
		$this->lwMessage = "Status updated";
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] task status marked as done for id [ '.$id.' ]');
  }

  public function saveTask()
  {
		$newTask = new Task();

		$newTask->self_id = Auth::id();
		$newTask->category = $this->category;
		$newTask->text = $this->taskText;
		$newTask->date = date('Y-m-d');
		$newTask->status = 'Active';
		$newTask->save();
		$this->dispatch('swal.confirm', 'Task Saved'); 
		$this->resetTaskForm();
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved task by [ '.Auth::id().' ]');

  }

	public function resetTaskForm()
	{
		$this->category = "";
		$this->taskText = "";
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset form for group task');
	}

}

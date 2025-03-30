<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Elab\Exptfile;
use Illuminate\Log\Logger;
use Log;

class ExptimageDisplayModal extends ModalComponent
{
    public $name = "CLEAR-Meissa";
	
	public $experiment_id;
    public $file_name;
    public $file_info;
    public $file_path;
    public $path;
    public $imagenotes;
    public $imageTag;
    public $title = "Image";

    public function render()
    {
        
        return view('livewire.modals.exptimage-display-modal');
    }

    public function mount($file_name, $path, $expt_id)
    {
        $this->file_name = $file_name;
        $this->file_path = $path;
        $this->experiment_id = $expt_id;
        //dd($this->file_name);
    }

    public function close()
    {
      $this->closeModal();
    }

    	////// Download functions 
	public function exptImageFileDownload($path)
	{
		//dd($path);
        //log activity
        Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] requested image file [ '.$path.' ]');
        
		return response()->download(storage_path("app/public/".$path));
	}

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

}

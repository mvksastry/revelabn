<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ModalImage extends ModalComponent
{
    public $name = "CLEAR-Meissa";
	
	public $experiment_id;
    public $filename, $image_file;
    public $imagenotes;
    public $imageTag;
    public $title = "Image";

    //protected $listeners = ['openModal' => 'openImageModal'];

    public function openImageModal($experiment_id)
    {
        $this->experiment_id = $experiment_id;
        //dd($this->experiment_id);
    }

    public function render()
    {
       // dd($this->experiment_id);
        return view('livewire.modals.modal-image');
    }

    public function mount($experiment_id)
    {
        //$this->gelimage = $gelimage;
        $this->experiment_id = $experiment_id;
        //dd($this->experiment_id);
    }

    public function exptInfoImgDownload($file)
	{
		//for testing, in reality, pass on the user's folder name fromm DB.
		$piFolder = Auth::user()->folder;

		//$destPath = "institutions"."/".$piFolder."/";
        $destPath = "public/expts/gels/".$this->expt_id."/";
        
		return response()->download(storage_path("app/".$destPath.$file));
	}

    public function close()
    {
      $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }
}

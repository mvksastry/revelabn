<?php

namespace App\Livewire\Elab\Inventory;

use Livewire\Component;

class ReviewReplinishment extends Component
{

    //swal messages
	public $message;
    
    public function render()
    {
        return view('livewire.elab.inventory.review-replinishment');
    }
}

<?php

namespace App\Livewire\Documents;

use Livewire\Component;

class ManageLabfiles extends Component
{
    public $message=null;
    
    public function render()
    {
        return view('livewire.documents.manage-labfiles');
    }
}

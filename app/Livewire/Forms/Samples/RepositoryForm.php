<?php

namespace App\Livewire\Forms\Samples;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RepositoryForm extends Form
{
    //
    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $reposit_type;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $reposit_desc;

    #[Validate('required|numeric')]
    public $reposit_capacity;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $building;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $floor;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $room;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $in_charge;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $keys_with;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $notes;
}

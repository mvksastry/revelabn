<?php

namespace App\Livewire\Forms\Reagents;

use Livewire\Attributes\Validate;
use Livewire\Form;

class NewReagentForm extends Form
{
    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $reagent_name;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $reagent_nickname;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $reagent_desc;

    #[Validate('required|numeric')]
    public $reagentClassCode;

    #[Validate('required|numeric')]
    public $quantity_made;
    
    #[Validate('required|numeric')]
    public $units_id;
    
    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $units_desc;
    
    #[Validate('required|date')]
    public $expirty_date;

    #[Validate('required|numeric')]
    public $container_id;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $rack_shelf;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $box_sack;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $location_code;

    #[Validate('required|numeric')]
    public $openrestriced;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $note_remark;

}

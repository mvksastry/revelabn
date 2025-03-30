<?php

namespace App\Livewire\Forms\Samples;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SampleForm extends Form
{
    //
    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $sampCode;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $sample_species;

    #[Validate('required|numeric')]
    public $sample_type;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $sample_desc;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $user_code;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $bulk_code;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $series_code;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $source_desc;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $source_ref;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $sample_remark;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $sample_tags;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $repository_id;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $compart_id;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $holder_sack;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $box_sack;

}

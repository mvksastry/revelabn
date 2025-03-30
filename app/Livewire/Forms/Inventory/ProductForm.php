<?php

namespace App\Livewire\Forms\Inventory;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    //
    #[Validate('required|numeric')]
    public $resproj_id;

    #[Validate('required|numeric')]
    public $category_id;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $catalog_number;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $item_desc;

    #[Validate('required|numeric')]
    public $source_desc;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $pack_size;

    #[Validate('required|numeric')]
    public $unit_desc;

    #[Validate('required|numeric')]
    public $number_packs;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $batchCode;

    #[Validate('nullable|date')]
    public $dateMFD;

    #[Validate('nullable|date')]
    public $dateExpiry;

    #[Validate('required|string|regex:/^[0-9. ]+$/')]
    public $vialCost;

    #[Validate('nullable|alpha')]
    public $costCurrency;
    
    #[Validate('required|numeric')]
    public $container_id;

    #[Validate('required|numeric')]
    public $rack_shelf;

    #[Validate('required|numeric')]
    public $box_sack;

    #[Validate('required|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $location_code;

    #[Validate('nullable|string|regex:/^[A-Za-z0-9-,_. ]+$/')]
    public $note_remark;
}

<?php

namespace App\Livewire\Elab\Inventory;

use Livewire\Component;


class BulkImportInventory extends Component
{
    //swal messages
	public $message;

    //Bulk chem form variables
    public $sampCode, $catalogNumber, $itemDesc, $consumRemark;
    public $category_name, $unit_id, $vendor_name, $units_desc;
    public $open_status, $status_date, $quantity_left, $full_empty;


    public function render()
    {
        return view('livewire.elab.inventory.bulk-import-inventory');
    }
}

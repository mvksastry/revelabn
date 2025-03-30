<?php

namespace App\Livewire\Elab\Inventory;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\ELab\Consumption;
use App\Models\ELab\Products;
use App\Models\ELab\Resproject;
use App\Models\User;

// Log trails recorder
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

//Traits
use App\Traits\Base;

class ReviewConsumption extends Component
{
    use Base;

    //swal messages
	public $message;

    public $consumption_details;

    //search criteria variables
    public $user_id, $resproject_id, $catalog_number, $date_from, $date_to;

    //render variables
    public $users, $resprojects;

    public function render()
    {
        $this->users = User::where('id','<>', 1)->get();
        $this->resprojects = Resproject::where('status', 'active')->get();
        $this->date_to = date('Y-m-d');
        $this->date_from = date('Y-m-d', strtotime('-30 days'));

        $msg = "Search Criteria Displayed";
        $this->dispatch('swal:confirm', ['title' => $msg]);

        return view('livewire.elab.inventory.review-consumption');
    }

    public function searchQuery($params)
    {
        $this->consumption_details = Consumption::with('categories')
                                                    ->with('units')
                                                    ->with('vendor')
                                                    ->with('user')
                                                    ->with('product')
                                                    ->with('prodProj')
                                                    ->get();
    }
}

<?php

namespace App\Livewire\Reagents;

use Livewire\Component;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//models
use App\Models\Elab\Reagent;

//Traits
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
//

//helpers
use Log;
use Validator;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageReagents extends Component
{
    public function render()
    {
        return view('livewire.reagents.manage-reagents');
    }
}

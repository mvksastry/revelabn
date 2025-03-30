<?php

namespace App\Livewire\Elab\Inventory;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

//framework
use Validator;
use Log;
use Carbon\Carbon;
use Illuminate\Log\Logger;

//models
use App\Models\ELab\Categories;

class AddInventoryCategory extends Component
{
  //swal messages
	public $message;
  //models
  public $categories;
  //new category
  public $newCategory, $newCatDesc;

  public function render()
  {
    $this->categories = Categories::all();
    return view('livewire.elab.inventory.add-inventory-category');
  }

  public function postNewCategoryInfo()
	{
		$validatedData = $this->validate(
		[
		  'newCategory' => 'required|alpha_num',
		  'newCatDesc'	 => 'required|string|regex:/^[A-Za-z0-9-,_. ]+$/',
		],
		[
			'newCategory.required'	=> 'The :attribute required',
			'newCategory.newCategory'	=> 'The :attribute must alpha numeric characters only',
			
			'newCatDesc.required'	=> 'The :attribute required',
			'newCatDesc.newCatDesc'	=> 'The :attribute must alpha numeric characters only',
		],
		[
		  'newCategory' => 'New Category',
		  'newCatDesc'  => 'New Category Description'
		]);
		
		$newCat = new Categories();
		$newCat->name = $this->newCategory;
		$newCat->description = $this->newCatDesc;
		//dd($newCat);
		$newCat->save();
		//$this->alert('success', 'New Category Created');
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved new inventory category');
		
		$newCat = null;
		$this->categories = Categories::all();
		$this->resetNewCategoryForm();
	}

  public function resetNewCategoryForm()
	{
		$this->newCategory = null;
		$this->newCatDesc = null;
		
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] reset Inventory New category info form');
	}
}

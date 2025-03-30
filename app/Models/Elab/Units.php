<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Units extends Model
{
    use HasFactory;
	use HasRoles;
    	
	protected $table = 'units';

	protected $primaryKey = 'unit_id';
	
		protected $fillable = [
		'symbol',
		'symbol_add', 
		'description',
	];
}

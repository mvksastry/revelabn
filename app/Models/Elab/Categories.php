<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Categories extends Model
{
  use HasFactory;
	use HasRoles;

	protected $table = 'categories';

	protected $primaryKey = 'category_id';

	protected $fillable = [
		'name',
		'description',
	];

}

<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Theme extends Model
{
    //
    use HasFactory;
	use HasRoles;

    protected $primaryKey = 'theme_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'resproject_id',
		'allowed_id',
		'theme_description',
        'theme_start_date',
        'entry_date',
        'created_at',
        'updated_at'			
    ];

}

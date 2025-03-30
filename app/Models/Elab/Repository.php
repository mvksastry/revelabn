<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Repository extends Model
{
    use HasFactory;
	use HasRoles;

    protected $table ="repositories";
    
	protected $primaryKey = 'repository_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'repository_type',
			'posted_by'.
			'description',
			'capacity',
			'building',
			'floor',
			'room',
			'incharge',
			'keys_with',
			'notes',
			'status',
			'created_at',
			'updated_at'			
    ];
}

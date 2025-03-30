<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Exptnote extends Model
{
    use HasFactory;
    use HasRoles;
    
	protected $primaryKey = 'exptnote_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'user_name',
        'experiment_id',
        'expnotes',
        'pi_notes',
        'created_at',
        'updated_at'			
    ];
}

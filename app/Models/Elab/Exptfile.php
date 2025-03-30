<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Exptfile extends Model
{
    //
    use HasFactory;
    use HasRoles;
    protected $primaryKey = 'exptfile_id';
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'experiment_id',
        'user_id',
        'user_name',
        'entry_date',
        'file_type',
        'file_name',
        'description',
        'legend',
        'notes',
        'path',
    ];
}

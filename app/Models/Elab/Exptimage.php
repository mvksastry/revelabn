<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Exptimage extends Model
{
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
        'image_file',
        'video_file',
        'notes',
        'created_at',
        'updated_at'			
    ];
}

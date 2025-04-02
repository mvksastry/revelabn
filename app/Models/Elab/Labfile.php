<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Labfile extends Model
{
    //
    use HasFactory;
    use HasRoles;
    protected $primaryKey = 'labfile_id';

    protected $fillable = [
        'uuid',
        'category',
        'sub_category',
        'resproject_id',
        'iaecproject_id',
        'experiment_id',
        'notebook_id',
        'file_type',
        'file_name',
        'user_id',
        'user_name',
        'date_submitted',
        'file_path',
    ];
}

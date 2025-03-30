<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;

class Maintenance extends Model
{
    use HasFactory;
    use HasRoles;
    
    protected $table = 'maintenance';

    protected $primaryKey = 'maintenance_id';

    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'supervisor_id',
        'infra_id',
        'type',
        'done_date',
        'description',
        'filename',
        'file_path',
    ];

    public function infra()
    {
        return $this->hasOne(Infrastructure::class, 'infra_id', 'infra_id');
    }

    public function incharge()
    {
        return $this->hasOne(User::class, 'id', 'supervisor');
    }
}

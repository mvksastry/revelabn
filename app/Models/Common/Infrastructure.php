<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;

class Infrastructure extends Model
{
    use HasFactory;
    use HasRoles;
    
    protected $table = 'infrastructure';

    protected $primaryKey = 'infra_id';

    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'name',
        'nickName',
        'description',
        'date_acquired',
        'make',
        'model',
        'vendor_address',
        'vendor_phone',
        'vendor_email',
        'building',
        'floor',
        'room',
        'amc',
        'amc_start',
        'amd_end',
        'supervisor'
    ];

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'infra_id', 'infra_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'supervisor');
    }
}

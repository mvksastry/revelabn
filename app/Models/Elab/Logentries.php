<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Common\Infrastructure;
use App\Models\User;

class Logentries extends Model
{
    use HasFactory;
    use HasRoles;

    protected $table = 'logentries';
	 
	protected $primaryKey = 'logentry_id';
	 
  /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
		'infra_id',
		'start_hour',
		'start_min',  
		'end_hour',   
		'end_min',    
		'accessories',
		'user_id', 
		'status',  
		'remarks'
		];

    public function infra()
    {
      return $this->hasOne(Infrastructure::class, 'infra_id', 'infra_id');
    }
	 
	 public function user()
    {
      return $this->hasOne(User::class, 'id', 'user_id');
    }
}

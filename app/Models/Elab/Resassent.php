<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Resassent extends Model
{
    //
    use HasFactory;
    use HasRoles;

	protected $primaryKey = 'resassent_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'resproject_id',
		'allowed_id',
		'start_date',
		'end_date',
		'notebook',
		'status',
    ];
	 
	public function allowed()
    {
      return $this->hasOne(User::class, 'id', 'allowed_id');
    }

	public function resproject()
    {
      return $this->hasOne(Resproject::class, 'resproject_id', 'resproject_id');
    }
	
	public function resprojs()
   {
      return $this->hasMany(Resproject::class, 'resproject_id', 'resproject_id');
   }
}
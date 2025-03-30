<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Reagents extends Model
{
    use HasFactory;
	use HasRoles;
	
	protected $table = 'reagents';
	
	protected $primaryKey = 'reagent_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
		'name',
		'description',
		'nick_name',
		'madeby_id',
		'date_made',
		'reagent_code',
		'ingradients',
		'quantity_made',
		'unit_id',
		'quantity_left',
		'expiry_date',
		'storage_container_id',
		'shelf_rack_id',
		'box_sack_id',
		'location_code',
		'open_restricted',
		'notes'
   ];
	
	public function units()
	{
		return $this->hasOne(Units::class, 'unit_id', 'unit_id');
	}
	
	public function experiments()
	{
		return $this->hasMany(Experiment::class, 'experiment_id', 'experiment_id');
	}
	 
	public function users()
	{
		return $this->hasOne(User::class, 'id', 'madeby_id');
	}
}

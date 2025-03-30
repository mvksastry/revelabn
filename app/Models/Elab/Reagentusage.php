<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Reagentusage extends Model
{
    use HasFactory;
	use HasRoles;

	protected $primaryKey = 'reagentusage_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [ 
		'reagent_code',
		'user_id',
		'date_used',
		'unit_id',
		'quantity_consumed',
		'experiment_id',
		'experiment_date',
		'notes',
    ];
	 
    // Customize log name
    protected static $logName = 'Sampleusage';
	 
    protected $searchable = [
		'reagent_code',
		'user_id',
		'date_used',
		'unit_id',
		'quantity_consumed',
		'experiment_id',
		'experiment_date',
		'notes',
    ];
	 
	public function reagent()
	{
		return $this->hasOne(Reagent::class, 'reagent_code', 'reagent_code');
	}
	
	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

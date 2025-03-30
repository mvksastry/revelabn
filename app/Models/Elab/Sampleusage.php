<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Sampleusage extends Model
{
	use HasFactory;
	use HasRoles;

	protected $primaryKey = 'exptsample_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
		'sample_code',
		'user_id',
		'date_used',
		'unit_id',
		'quantity_consumed',
		'experiment_id',
		'experiment_date',
		'notesupdated_at',
    ];
	 
    // Customize log name
    protected static $logName = 'Sampleusage';
	 
    protected $searchable = [
		'sample_code',
		'user_id',
		'date_used',
		'unit_id',
		'quantity_consumed',
		'experiment_id',
		'experiment_date',
		'notesupdated_at',
    ];
	 
	public function exptsample()
	{
		return $this->hasOne(Exptsample::class, 'sample_code', 'sample_code');
	}
	
	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

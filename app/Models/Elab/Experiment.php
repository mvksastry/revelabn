<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;

class Experiment extends Model
{
    use HasFactory;
	use HasRoles;
    
	protected $primaryKey = 'experiment_id';

	protected $casts = [
        'protocol_id' => 'array',
        'procedure_id' => 'array',
        'reagent_used' => 'array',
    ];
   
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'theme_id',
		'allowed_id',
		'experiment_description',
        'protocol_id',
        'procedure_id',
        'supplement_expt_id',
        'supplement_expt_description',
        'experiment_date',
        'reagent_description',
        'reagent_used',
        'image_ids',
        'video_ids',
        'user_notes',
        'pi_notes',
        'manual_labnotebook_ref',
        'bulk_storage_date_ref',
        'entry_date',
        'created_at',
        'updated_at'			
    ];
    
    public function user()
	{
		return $this->hasOne(User::class, 'id', 'allowed_id');
	}
	
	public function protocols()
	{
		return $this->hasMany(Protocol::class, 'protocol_id', 'protocol_id');
	}
	 
	public function procedures()
	{
		return $this->hasMany(Procedure::class, 'procedure_id', 'procedure_id');
	}
	
    public function exptfiles()
    {
        return $this->hasMany(Exptfile::class, 'experiment_id', 'experiment_id');
    }
    
    public function exptnotes()
    {
        return $this->hasMany(Exptnote::class, 'experiment_id', 'experiment_id');
    }
}

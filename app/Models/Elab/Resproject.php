<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Resproject extends Model
{
    //
    use HasFactory;
    use HasRoles;

    protected $primaryKey = 'resproject_id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pi_id',
        'title',
        'start_date',
        'end_date',
        'date_approved',
        'approval_ref',
        'budget_total',
        'budget_equipment',
        'budget_consumable',
        'budget_contigency',
        'comments',
        'research_project_file',
        'sanction_letter_file',
        'project_file_path',
        'sanction_file_path',
        'status'				
    ];

    public function assentsres()
    {
      return $this->hasMany(Resassent::class, 'resproject_id', 'resproject_id');
    }	 
	
	  public function user()
    {
      return $this->hasOne(User::class, 'id', 'pi_id');
    }
	
	  public function perms()
    {
      return $this->hasMany(Resassent::class, 'resproject_id', 'resproject_id');
    }

}

<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Report extends Model
{
    use HasFactory;
    use HasRoles;
    
    protected $primaryKey = 'report_id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'report_uuid',
        'resproject_id',
        'iaecproject_id',
        'report_title',
        'report_type',
        'date_from',
        'date_to',
        'filename',
        'file_path',
        'submitted_by',
        'submitted_date'
    ];
				
	public function user()
	{
      return $this->hasOne(User::class, 'id', 'submitted_by');
	}
	
	public function resproj()
	{
      return $this->hasOne(Resproject::class, 'resproject_id', 'resproject_id');
	}
	
	public function iaecproj()
	{
      return $this->hasOne(Iaecproject::class, 'iaecproject_id', 'iaecproject_id');
	}
}

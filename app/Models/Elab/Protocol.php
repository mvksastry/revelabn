<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Protocol extends Model
{
    use HasFactory;
	use HasRoles;
    
	protected $primaryKey = 'protocol_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'department_id',
			'title',
			'description',
			'version_id',
			'filename',
			'file_path',
			'approved_by',
			'approved_date',
			'approved_reference',
			'approved_authority',
			'validity_date',
			'pi_id',
			'status',
    ];
		
	public function user()
    {
      return $this->hasOne(User::class, 'id', 'pi_id');
    }
}

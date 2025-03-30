<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;

class Task extends Model
{
    use HasFactory;
	use HasRoles;
    protected $primaryKey = 'task_id';
		
    		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'self_id',
		'category',
		'text',
		'date',
		'status',				
    ];
		
	public function user()
    {
        return $this->hasOne(User::class, 'id', 'self_id');
    }

}

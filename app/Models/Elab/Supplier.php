<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Supplier extends Model
{
   //
   use HasFactory;
	use HasRoles;
	
	protected $primaryKey = 'supplier_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
		protected $fillable = [
			'note',
			'notes'				
		];
		
	public function products()
   {
      return $this->belongsTo(Product::class, 'supplier_id', 'supplier_id');
   }
}

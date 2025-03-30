<?php

namespace App\Models\Elab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Exptsample extends Model
{
    use HasFactory;
	use HasRoles;	
	//use Search;
	
	protected $primaryKey = 'exptsample_id';
		
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exptsample_id',
        'sample_code',
        'description',
        'type', 
        'species',
        'user_code',
        'bulk_code',
        'series_code',
        'source',
        'source_ref',
        'posted_by',
        'posted_name',
        'posted_date',
        'sample_remark',
        'tags',
        'repository_id',
        'compartment_id',
        'holder_id',
        'box_id',
        'isCurated',
    ];
    
    
    protected $searchable = [
        'sample_code',
        'description',
        'type', 
        'species',
        'bulk_code',
        'series_code',
        'source',
        'source_ref',
        'posted_by',
        'posted_name',
        'posted_date',
        'sample_remark',
        'tags',
        'repository_id',
        'compartment_id',
        'holder_id',
        'box_id',
    ];

}

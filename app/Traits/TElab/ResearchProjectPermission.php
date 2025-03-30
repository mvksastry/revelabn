<?php

namespace App\Traits\TElab;

use Illuminate\Http\Request;

use App\Models\Elab\Resassent;

trait ResearchProjectPermission
{
	public function assignResProjectPermission($perms)
	{
		foreach($perms as $key => $val)
		{
			if($perms[$key]['projperm'])
			{
				$resPerm = new Resassent();
				$resPerm->resproject_id = $key;
				$resPerm->allowed_id = $perms[$key]['user_id'];
				$resPerm->start_date = $perms[$key]['start_date'];
				$resPerm->end_date = $perms[$key]['end_date'];
				$resPerm->notebook = $key."notebook";
				$resPerm->status = 1;
				
				$resPerm->save();
			}
		}
		return true;
	}
}
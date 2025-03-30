<?php

namespace App\Traits\TElab;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;

use App\Models\Elab\Resassent;
use App\Models\Elab\Resproject;
use App\Models\Elab\Experiment;
use App\Models\User;

//use File;
use App\Traits\Base;
use File;

trait SaasPlanQueries
{
	use Base;

  public function subscriptionStatus()
  {
    return Auth::user()->has_subscription;
  }

  public function userCount()
  {
    return count(User::all()) - 1;
  }

  public function saasPlanApplicable()
	{
    $subscStatus = $this->subscriptionStatus();

    if($subscStatus > 0)
    {
      $planArray = config('elab.max_plan');
    }
    else {
      $planArray = config('elab.free_plan');
    }
		return $planArray;
	}

  public function getTenantResprojectCountByPlan()
  {
    $planArray = $this->saasPlanApplicable();

    $planProjectCount = $planArray['projects'];

    if(count(Resproject::all()) >= $planProjectCount)
    {
      return false;
    }
    else {
      return true;
    }
  }

  public function getTenantExptCountByPlan()
  {
    $planArray = $this->saasPlanApplicable();

    $planExptCount = $planArray['experiments'];

    if(count(Experiment::all()) >= $planExptCount)
    {
      return false;
    }
    else {
      return true;
    }
  }

/**
  * Write code on Method
  *
  * @return response()
  */
  public function getTenantFolderSizeByPlan()
  {
      $path = storage_path();
      $fileSize = 0;
      foreach( File::allFiles($path) as $file){ 
          $fileSize += $file->getSize();
      }
      return number_format($fileSize / 1048576,2);
  }

  public function getTenantUserCountByPlan()
  {
    $planArray = $this->saasPlanApplicable();
    $planUserCount = $planArray['users'];
    if($this->userCount() >= $planUserCount)
    {
      return false;
    }
    else {
      return true;
    }
  }

}
<?php

namespace App\Traits\TUpdates;

//use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Elab\Exptsample;
use App\Models\Elab\Sampleusage;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait TSampleConsumptionUpdate
{
  public function updateSampleConsumption($row, $exptId, $entry_date)
  {
    $eSamp = Exptsample::where('sample_code', $row['sample_code'])->first();
					
    $newSampUsage = new Sampleusage();
    $newSampUsage->sample_code = $row['sample_code']; 
    $newSampUsage->user_id = Auth::user()->id; 
    $newSampUsage->date_used = date('Y-m-d'); 
    $newSampUsage->unit_id = $row['samp_units']; 
    $newSampUsage->quantity_consumed = $row['quantity']; 
    $newSampUsage->experiment_id = $exptId; 
    $newSampUsage->experiment_date = $entry_date; 
    $newSampUsage->notes = "used for experiment id: ".$exptId." ; "; 
    //dd($newSampUsage);
    $newSampUsage->save();
    
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] updated sample usage for ['.$row['sample_code'].']');
    return true;
  }

}
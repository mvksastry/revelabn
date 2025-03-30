<?php

namespace App\Traits\TUpdates;

//use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Elab\Reagents;
use App\Models\Elab\Reagentusage;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait TReagentConsumptionUpdate
{
  public function updateReagentConsumption($row, $exptId, $entry_date)
  {
    $qtyLeft = $row['quantity_left'] - $row['quantity'];
					
    if($qtyLeft < 0)
    {
      $qtyLeft = 0;
    }
    
    $eReag = Reagents::where('reagent_code', $row['reagent_code'])->first();
    $eReag->quantity_left = $qtyLeft;
    $eReag->notes = $eReag->notes."###"." Quantity used ".$row['quantity']." on ".date('d-m-Y').";";
    $eReag->save();
    
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] updated reagent quantity for ['.$row['reagent_code'].']');
    
    $newReagUsage = new Reagentusage();
    $newReagUsage->reagent_code = $row['reagent_code']; 
    $newReagUsage->user_id = Auth::user()->id; 
    $newReagUsage->date_used = date('Y-m-d'); 
    $newReagUsage->unit_id = $row['reag_units']; 
    $newReagUsage->quantity_consumed = $row['quantity']; 
    
    $newReagUsage->experiment_id = $exptId; 
    $newReagUsage->experiment_date = $entry_date; 
    $newReagUsage->notes = "used for experiment id: ".$exptId." ; "; 
    //dd($newReagUsage);
    $newReagUsage->save();
    
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] updated reagent usage for ['.$row['reagent_code'].']');

    return true;
  }
}
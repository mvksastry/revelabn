<?php

namespace App\Traits\TUpdates;

//use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Elab\Products;
use App\Models\Elab\Consumption;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait TProductConsumptionUpdate
{
  public function updateConsumptionOfProduct($row, $exptId, $entry_date)
  {
    //now get the chemical detail from products table
    //reduce the quantity in products table
    $cProd = Products::where('pack_mark_code', $row['pmc'])->first();
    $cProd->quantity_left = $cProd->quantity_left - $row['quantity'];
    $cProd->status_date = date('Y-m-d');
    if( $cProd->quantity_left < $cProd->pack_size )
    {
      $cProd->status_open_unopened = 0;
    }
    //ensure it is not negative, it must be unsigned
    if($cProd->quantity_left < 0 )
    {
      $cProd->quantity_left = 0;
    }
    // save the object
    //dd($cProd);
    $cProd->save();
    //now post to consumption table, create object for storage
    $newConsumption = new Consumption();
    $newConsumption->pack_mark_code = $row['pmc'];
    $newConsumption->user_id = Auth::user()->id;
    $newConsumption->date_used = date('Y-m-d');
    $newConsumption->product_id = $cProd->product_id;
    //get unit_id
    $newConsumption->unit_id = $cProd->unit_id;
    $newConsumption->quantity_consumed = $row['quantity'];
    //get Expt date
    $newConsumption->experiment_id = $exptId;
    $newConsumption->experiment_date = $entry_date;
    $newConsumption->notes = "used for experiment id: ".$exptId." ; ";
    //dd($newConsumption);
    $newConsumption->save();
    //log activity
    Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] updated consumption for ['.$row['pmc'].']');
    //now return the function result.
    return true;
  }
}
<?php

namespace App\Traits\TLivewire;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Elab\Products;
use App\Models\Elab\Reagents;
use App\Models\Elab\Units;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait ReagentSelection
{
  public function selectedReagent($params)
	{
		$this->reagent_id = $params;
		//dd($this->reagent_id);
		$this->units = Units::all();
		
		$resy = Reagents::where('reagent_id', $this->reagent_id)->first();
								
		$this->inpReagents[$this->k]['reagent_id'] = $this->reagent_id;
		$this->inpReagents[$this->k]['desc_reagent'] = $resy->description;
		$this->inpReagents[$this->k]['quantity_left'] = $resy->quantity_left;
		$this->inpReagents[$this->k]['reagent_code'] = $resy->reagent_code;
		$this->inpReagents[$this->k]['unit_id'] = $resy->units->unit_id;
		$this->inpReagents[$this->k]['unit_desc1'] = $resy->units->symbol;
		$this->inpReagents[$this->k]['unit_desc2'] = $resy->units->symbol_add;
		$this->inpReagents[$this->k]['quantity'] = '';
		$this->inpReagents[$this->k]['usage'] = '';
		
		//open the result box
		$this->searchResultBox3 = true;

		//log activity
		Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] selected reagent id ['.$this->reagent_id.']');

		//keep ready for next item
		$this->k = $this->k + 1;
	}

	public function removeReagent($k)
	{
		unset($this->inpReagents[$k]);
	}
}
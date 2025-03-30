<?php

namespace App\Traits\TLivewire;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Elab\Products;
use App\Models\Elab\Exptsample;
use App\Models\Elab\Units;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait ExptSampleSelection
{
	public function selectedExptSample($exptsample_id)
	{
		//dd($exptsample_id);
		$this->units = Units::all();
		
		$this->exptsample_id = $exptsample_id;
		$resx = Exptsample::where('exptsample_id', $exptsample_id)
								//with('categories')
								//->with('units')
								//->with('vendor')
								->first();
		//dd($resx);
		$this->inpExptsamps[$this->j]['exptsample_id'] = $this->exptsample_id;
		$this->inpExptsamps[$this->j]['desc'] = $resx->description;
		$this->inpExptsamps[$this->j]['sample_code'] = $resx->sample_code;
		$this->inpExptsamps[$this->j]['quantity_left'] = $resx->quantity_left;
		//$this->inpExptsamps[$this->j]['unit_desc1'] = $res->units->symbol;
		//$this->inpExptsamps[$this->j]['unit_desc2'] = $res->units->symbol_add;
		$this->inpExptsamps[$this->j]['quantity'] = '';
		$this->inpExptsamps[$this->j]['usage'] = '';
		
		//open the result box
		$this->searchResultBox2 = true;
		
		//keep ready for next item
		$this->j = $this->j + 1;
		
		//log activity
		Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] selected experimental sample ['.$this->exptsample_id.']');
		
		//array_push($this->inputs ,$this->j);
		//dd($this->inputs);
		$this->dispatch('exptSampleTableInit');
	}

  public function removeExptsamps($j)
	{
		unset($this->inpExptsamps[$j]);
	}

}
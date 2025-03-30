<?php

namespace App\Traits\TLivewire;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Elab\Products;
use App\Models\Elab\Resassent;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait FineChemicalSelection
{
	public function selectedFineChem($pack_mark_code)
	{
		$this->sampCode = $pack_mark_code;
		$res = Products::with('categories')
								->with('units')
								->with('vendor')
								->where('pack_mark_code', $pack_mark_code)
								->first();
		$this->inputs[$this->i]['pmc'] = $this->sampCode;
		$this->inputs[$this->i]['name'] = $res->name;
		$this->inputs[$this->i]['quantity_left'] = $res->quantity_left;
		$this->inputs[$this->i]['cat_num'] = $res->catalog_id;
		$this->inputs[$this->i]['unit_desc1'] = $res->units->symbol;
		$this->inputs[$this->i]['unit_desc2'] = $res->units->symbol_add;
		$this->inputs[$this->i]['quantity'] = '';
		$this->inputs[$this->i]['usage'] = '';
		//open the result box
		$this->searchResultBox1 = true;
		//keep ready for next item
		$this->i = $this->i + 1;
		//log activity
		Log::channel('activity')->info("[ ".tenant('id')." ] [ ".Auth::user()->name.' ] selected experimental sample ['.$this->sampCode.']');
		//array_push($this->inputs ,$this->i);
		//dd($this->inputs);
		$this->dispatch('productdataTableInit');
	}

	public function removeFineChemFromList($i)
	{
		unset($this->inputs[$i]);
	}
}
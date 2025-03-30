<?php

namespace App\Traits\TLivewire;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
//use App\Models\Elab\Products;
//use App\Models\Elab\Reagent;
use App\Models\Elab\Theme;


use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

trait SaveResearchTheme
{
  public function researchThemeCreation()
  {
    $newTheme = new Theme();
    $newTheme->resproject_id = $this->resproject_id;
    $newTheme->allowed_id = Auth::user()->id;
    $newTheme->theme_description = $this->theme_desc;
    $newTheme->theme_start_date = date('Y-m-d');
    $newTheme->entry_date = date('Y-m-d');
    //now post to DB table
    $result = $newTheme->save();
    //dd($result);
    return $result;
  }
}
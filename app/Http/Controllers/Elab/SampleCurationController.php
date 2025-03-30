<?php

namespace App\Http\Controllers\Elab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

//models
use App\Models\Elab\Exptsample;

//Traits
use App\Traits\Base;

class SampleCurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $uncuratedSamples = Exptsample::where('isCurated', 'no')->get();
    
        $msg = "Uncurated Sample Found";
        //    $this->dispatch('swal:confirm', ['title' => $msg]); 
    
        //$this->showUploadResultPanel = true;
        //$this->dispatch('dataTableInit'); 
        return view('curations.sample-curation-home')->with('uncuratedSamples', $uncuratedSamples);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

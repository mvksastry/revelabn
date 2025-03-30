<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Common\Infrastructure;

use App\Http\Requests\InfrastructureFormRequest;

use App;
use File;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class InfrastructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infras = Infrastructure::all();
        //dd($infras);
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Infrastructure home page displayed');
        return view('infras.index')->with('infras', $infras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] New Infra form displayed');
        return view('infras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $infra = new Infrastructure();
        $infra->name = $input['name'];
        $infra->nickName = $input['nickname'];
        $infra->description = $input['desc'];
        $infra->date_acquired = $input['dateacqrd'];
        $infra->make = $input['make'];
        $infra->model = $input['model'];
        $infra->vendor_address = $input['vendor'];
        $infra->vendor_phone = $input['phone'];
        $infra->vendor_email = $input['email'];
        $infra->building = $input['building'];
        $infra->floor = $input['floor'];
        $infra->room = $input['room'];
        $infra->amc = $input['amc'];
        $infra->amc_start = date('Y-m-d', strtotime($input['amc_start']));
        $infra->amc_end = date('Y-m-d', strtotime($input['amc_end']));
        $infra->supervisor = $input['supervisor'];
        //dd($infra);

        $result = $infra->save();

        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved new Infra item ['.$infra->nickName.']');
        
        return redirect()->route('infrastructure.index')
            ->with('flash_message', 'Infrastructure entry successfully added.');
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
        $infra = Infrastructure::with('user')->where('infra_id', $id)->first();
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] editing Infra item ['.$id.']');
        return view('infras.edit')->with('infra', $infra);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $infra = Infrastructure::find($id);
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updating Infra item ['.$id.']');
        return redirect()->route('infrastructure.index')
            ->with('flash_message',
             'Infrastructure entry successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] attempting deleting Infra item ['.$id.'], not deleted');
    }
}

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

use App\Models\User;
use App\Models\Common\Infrastructure;
use App\Models\Common\Maintenance;

use App\Traits\TCommon\FileUploadHandler;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

class MaintenanceController extends Controller
{
    use FileUploadHandler;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeInfras = Infrastructure::with('user')->get();
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] maintenance home page displayed');
        return view('maintenance.index')->with('activeInfras', $activeInfras);
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
      
        $input = $request->all();
        $res1 = Infrastructure::where('name', $input['infname'])->first();
        $res2 = User::where('name', $input['supname'])->first();
        $infraName = $input['infname'];

        if( $request->hasFile('userfile') )
        {
            $request->validate([
                'userfile' => 'required|mimes:pdf,doc,docx|max:4096'
            ]);
            
            $result = $this->serviceReportFileUpload($request, $infraName, $res1->infra_id);
            // below only for testing, comment above
            //$filename = "ansdkjweuncjs";
        }

        if($result['upload_result']){
            $msr = new Maintenance();
            $msr->supervisor = $res2->id;
            $msr->infra_id = $res1->infra_id;
            $msr->type =$input['mrsType'];
            $msr->done_date = $input['doneDate'];
            $msr->description = $input['desc'];
            $msr->filename = $result['service_report_filename'];
            $msr->file_path = $result['service_report_path'];
            //dd($msr);
            $msr->save();
            Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved maintenance file for infra id ['.$msr->infra_id.']');
        }
      
        return redirect()->route('maintenance.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $infra = Infrastructure::with('user')->where('infra_id', $id)->first();
        $mrs = Maintenance::with('incharge')->where('infra_id', $id)->get();
        //dd($infra, $mrs);
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed maintenance info for infra id ['.$id.']');
        
        return view('maintenance.show')
                ->with('mrs', $mrs)
                ->with('infra', $infra);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] editing maintenance info for infra id ['.$id.']');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] updating maintenance info for infra id ['.$id.']');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //
         Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] attempting to delete infra id ['.$id.']. Not deleted');
    }
}

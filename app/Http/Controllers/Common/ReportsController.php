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

use App\Models\Elab\Resproject;
use App\Models\Elab\Iaecproject;
use App\Models\Elab\Report;

use File;
use App\Traits\Base;
use App\Traits\TCommon\FileUploadHandler;
use Validator;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

//Uuid import class
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    use Base;
	use HasRoles;
	use FileUploadHandler;
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if( Auth::user()->hasAnyRole('pisg') )
		{
			$actvProjs = Resproject::where('pi_id', Auth::id() )
									->whereIn('status', ['active'])->get();
            
            $all_reports = Report::with('resproj')->get();
			//dd($actvProjs);
			Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] Report home page displayed');
			return view('reports.index')
						->with(['actvProjs'=>$actvProjs, 'all_reports'=>$all_reports ]);
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] report create page displayed');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//
		$request->validate([
            'resproject_id'  => 'required|regex:/(^[0-9]+$)+/|max:200',
            'report_type'    => 'required|regex:/(^[A-Za-z-]+$)+/|max:20',
            'report_title'   => 'required|regex:/(^[A-Za-z-_, .]+$)+/|max:200',
			'date_from'      => 'required|date|date_format:Y-m-d',
			'date_to'        => 'required|date|date_format:Y-m-d|after:from_date',
		  //'submitted_date' => 'required|date|date_format:Y-m-d',
		    'spcomments'     => 'nullable|regex:/(^[A-Za-z0-9 -_.,]+$)+/',
            'reportfile'     => 'required|mimes:pdf|max:4096'
		]);
		$input = $request->only('resproject_id', 'report_type', 'report_title', 'date_from', 'date_to', 'submitted_date');

		$result = $this->resprojReportFileUpload($request, $input['resproject_id']);
		
        $input['report_uuid'] =  Str::uuid()->toString();
		$input['filename'] = $result['report_filename'];
        $input['file_path'] = $result['report_file_path'];
		$input['iaecproject_id'] = 0;
		$input['submitted_by'] = Auth::user()->id;
		$input['submitted_date'] = date('Y-m-d');
		$newRep = new Report();
		$newRep->fill($input);
        //dd($newRep);
		$newRep->save();
		Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] saved report file [ '.$result['report_filename'].' ]');
		return redirect()->route('reports.index');	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$projectById = Resproject::where('resproject_id', $id )
									->whereIn('status', ['active'])->first();
		//dd($projectById);	
		$reports = Report::with('resproj')->where('project_id', $id)->get();

        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] displayed reports for project id [ '.$id.' ]');
        
		//dd($reports);
		return view('reports.showReports')
						->with(['projectById' => $projectById, 'reports' => $reports ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] editing page displaed for report id ['.$id.']');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] page displayed for updating report id ['.$id.']');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Log::channel('activity')->info('[ '.tenant('id')." ] [ ".Auth::user()->name.' ] attempting deletion of id ['.$id.']. Not Deleted');
    }
}

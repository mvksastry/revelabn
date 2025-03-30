<?php

namespace App\Http\Controllers\Elab;

//-- This block is common to all Controllers and components --//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Route;
//------------------------------------------------------------//

use App\Models\User;
use App\Models\Elab\Resproject;

use App\Http\Requests\ResearchProjectRequest;

//use App\Traits\DeleteOldFile;
//use App\Traits\InputValidator;
//use App\Traits\TCommon\FileUploadHandler;
use App\Traits\TElab\ResearchProjectSubmission;
use App\Traits\TElab\SaasPlanQueries;

use File;
use Validator;

use Carbon\Carbon;
use Illuminate\Log\Logger;
use Log;

use App\Http\Middleware\EnsureUserIsSubscribed;

class ResearchProjectsController extends Controller
{
    //use FileUploadHandler;
    use ResearchProjectSubmission;
    use SaasPlanQueries;

    public function __construct()
    {
        //$this->middleware('subscribed');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( Auth::user()->hasAnyRole('pisg') )
		{
            $active_projects = Resproject::where('status', 'active')->get();
            return view('projects.investigator.research-projects-home')->with('active_projects', $active_projects);
        }
        else {
            return redirect()->route('home')->with('success', 'Project Created Successfully!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      if( Auth::user()->hasAnyRole('pisg') )
      {
        if($this->getTenantResprojectCountByPlan())
        {
            return view('projects.investigator.new-project-form'); 
        }
        else{
          return redirect()->route('error.error10001');
        }
      }
      else {
        return redirect()->route('error.error10000');
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResearchProjectRequest $request): RedirectResponse
    {
        if( Auth::user()->hasAnyRole('pisg') )
		{
    		$purpose = "new";
    		$id = "null";
    		$result = $this->postResprojectData($request, $purpose, $id);
    		
    		return redirect()->route('research-projects.index')->with('success', 'Project Created Successfully!');
		}
        else {
            return redirect()->route('home')->with('success', 'No Permission for Project Creation');
        }
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

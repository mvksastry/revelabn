<?php

namespace App\Traits\TElab;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//Uuid import class
use Illuminate\Support\Str;

use App\Models\Elab\Resproject;

use File;
use App\Traits\Base;
use App\Traits\TCommon\Notes;
use App\Traits\TCommon\FileUploadHandler;
use App\Traits\TElab\ResearchProjectPermission;

trait ResearchProjectSubmission
{
    use Base;
    use Notes;
    use FileUploadHandler;
    use ResearchProjectPermission;
    
    public function postResprojectData($request, $purpose, $id)
    {
        $today                = $this->today();
        $comments             = strip_tags($request['spcomments']);
        $approval_ref         = $request['approval_ref'];
        
        $title    		      = $request['title'];
        $StDate               = date('Y-m-d',strtotime($request['start_date']));
        $Endate               = date('Y-m-d',strtotime($request['end_date']));
        $apprvalDate          = date('Y-m-d',strtotime($request['approval_date']));
        
        $total_budget         = $request['total_budget'];
        $equip_budget		  = $request['equip_budget'];
        $consumable_budget    = $request['consumable_budget'];
        $contingency_budget   = $request['contingency_budget'];
        
        
        if($comments == NULL || $comments == "")
        {
            $comments = "No comments";
        }
        
        $notes = $this->addTimeStamp($comments);
        
        if($total_budget == NULL || $total_budget == "")
        {
            $total_budget = 0.00;
        }
        
        if($equip_budget == NULL || $equip_budget == "")
        {
            $equip_budget = 0.00;
        }
        
        if($consumable_budget == NULL || $consumable_budget == "")
        {
            $consumable_budget = 0.00;
        }
        
        if($contingency_budget == NULL || $contingency_budget == "")
        {
            $contingency_budget = 0.00;
        }
            // prepping complete
            if($purpose == 'new')
            {
                //make the array for database insert query
                $resProj                = new Resproject();
                $resProj->uuid          = Str::uuid()->toString();
                $resProj->pi_id         = Auth::user()->id;
                $resProj->title         = $title;
                $resProj->start_date    = $StDate;
                $resProj->end_date      = $Endate;
                $resProj->date_approved = $apprvalDate;
                
                $resProj->budget_total      = $total_budget;
                $resProj->budget_equipment  = $equip_budget;
                $resProj->budget_consumable = $consumable_budget;
                $resProj->budget_contigency = $contingency_budget;
                
                $resProj->approval_ref      = $approval_ref;
                $resProj->comments          = $notes;
                
                $resProj->research_project_file = null;
                $resProj->sanction_letter_file  = null;

                $resProj->project_file_path     = null;
                $resProj->sanction_file_path    = null;

                $resProj->status                = 'active';

                $resProj->save();
                //dd($tempProj);
                $resproject_id = $resProj->resproject_id;

                //now upload project files and approval letter files 
                // and update resproject file table with paths.
                if( $request->hasFile('resprojfile') )
                {
                    $res1 = $this->uploadProjectFile($request, $resproject_id);
                    if($res1['upload_status'])
                    {   
                        unset($res1['upload_status']);
                        $final_result = Resproject::where('resproject_id', $resproject_id)->update($res1);
                    }
                }

                if( $request->hasFile('appletterfile') )
                {
                    $res2 = $this->uploadApprovalLetterFile($request, $resproject_id);
                    if($res2['upload_status'])
                    {   
                        unset($res2['upload_status']);
                        $final_result = Resproject::where('resproject_id', $resproject_id)->update($res2);
                    }
                }

            }
            
            if($purpose == 'edit')
            {
                $resProj = Resproject::findOrFail($id);
                $resProj->title         = $title;
                $resProj->start_date    = $StDate;
                $resProj->end_date      = $Endate;
                $resProj->date_approved = $apprvalDate;
                
                $resProj->budget_total      = $total_budget;
                $resProj->budget_equipment  = $equip_budget;
                $resProj->budget_consumable = $consumable_budget;
                $resProj->budget_contigency = $contingency_budget;
                
                $resProj->approval_ref      = $approval_ref;
                $resProj->comments          = $notes;
                
                $resProj->research_project_file = $filename;
                $resProj->sanction_letter_file  = $filename;
                
                $resProj->status        = 'active';

                //dd($tempProj);
                // post to db through update method
                $resProj->update();
                
            }
            //before returning, create the notebook db for recording database
            // assin permissions.
            $perms[$resproject_id]['projperm'] = "true";
            $perms[$resproject_id]['user_id'] = Auth::user()->id;
            $perms[$resproject_id]['start_date'] = $StDate;
            $perms[$resproject_id]['end_date'] = $Endate;
            
            $result = $this->assignResProjectPermission($perms);

        return true;
    }

    public function uploadProjectFile($request, $project_id)
    {
        $result = $this->projFileUpload($request, $project_id);
        return $result;
    }

    public function uploadApprovalLetterFile($request, $project_id)
    {
        $result = $this->resprojAppLettFileUpload($request, $project_id);
        return $result; 
    }


}

<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Elab\Report;

class DownloadsController extends Controller
{
    //
    public function maintenanceFile($file_info)
    {
        //dd($file_info);
        //for testing, in reality, pass on the user's folder name fromm DB.
        $destPath = "app/public/infrastructure/reports/";
        return response()->download(storage_path($destPath.$file_info));
    }

    public function resProjectFile($report_uuid)
    {
        $result = Report::where('report_uuid', $report_uuid)->first();
        //dd($file_info);
        //for testing, in reality, pass on the user's folder name fromm DB.
        $destPath = "app/".$result->file_path;
        return response()->download(storage_path($destPath.$result->filename));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorsController extends Controller
{
    public function error10000()
    {
        $error_number = 10000;

        $error10000msg = "You have no permission to access this page";

        return view('saaserrors.error')->with(['error_number'=>$error_number, 'error_message'=> $error10000msg]);
    }

    public function error10001()
    {
        $error_number = 10001;

        $error10001msg = "You have exceeded the Projects allowed for your plan";

        return view('saaserrors.error')->with(['error_number'=>$error_number, 'error_message'=> $error10001msg]);
    }

    public function error10002()
    {
        $error_number = 10002;

        $error10002msg = "Serious Breach: Form Data Tampered";

        return view('saaserrors.error')->with(['error_number'=>$error_number, 'error_message'=> $error10002msg]);
    }

    public function error10010()
    {
        $error_number = 10010;

        $error10010msg = "You have exceeded the Users allowed for your plan";

        return view('saaserrors.error')->with(['error_number'=>$error_number, 'error_message'=> $error10010msg]);
    }
}

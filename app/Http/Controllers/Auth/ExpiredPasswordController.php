<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordExpiredRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ExpiredPasswordController extends Controller
{
    //
    public function expired() {
        return view('auth.passwords.expired');
    }

    public function postExpired(PasswordExpiredRequest $request) {

        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }

        $result = $request->user()->update([
            'password' => bcrypt($request->password),
            'last_pwchange' => date('Y-m-d'),
        ]);

        //$request->session()->flush();
        if($result){
            return redirect('/home')->with(['status' => 'Password changed successfully']);
        }
        else {
            return redirect()->back()->with(['status' => 'Password changed successfully']);
        }
    }
}

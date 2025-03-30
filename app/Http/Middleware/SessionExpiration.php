<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');
            $currentTime = time();
            $lastActivity = DB::table('sessions')
                ->select('last_activity')
                ->where('user_id', Auth::user()->id)
                ->first();
            $activityLast = $lastActivity->last_activity;
            $diff = $currentTime - $lastActivity->last_activity;
            $expirySetAt = config('session.lifetime') * 60;
            // Check if the session has expired
            if ( $diff > $expirySetAt) {
                //Auth::logout();
                //return redirect('/login')->with('message', 'Session expired. Please log in again.');
            }
            // Update last activity time
            session(['last_activity' => $currentTime]);
        }
        return $next($request);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function noSubscription()
    {
        //
        return view('subscription.no-subscription-notice');
    }
}

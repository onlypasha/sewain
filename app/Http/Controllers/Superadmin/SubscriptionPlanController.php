<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return view('superadmin.subscription-plan');
    }
}

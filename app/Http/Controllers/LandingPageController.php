<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;

class LandingPageController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('landing', compact('plans'));
    }
}

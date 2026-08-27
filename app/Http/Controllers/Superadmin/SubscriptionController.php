<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Laravel\Mcp\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest()->get();
        $plans = SubscriptionPlan::select('id', 'name')->get();
        $vendors = User::where('role', 'vendor')->select('id', 'name')->get();

        return view('superadmin.subscription', compact('subscriptions', 'plans', 'vendors'));
    }

    public function store(Request $request)
    {
        Subscription::create($request->all());
    }
}

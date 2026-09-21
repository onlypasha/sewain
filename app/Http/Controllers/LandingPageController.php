<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Items;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;

class LandingPageController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $features = Feature::all();

        $stats = [
            'vendors' => User::where('role', 'vendor')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_items' => Items::count(),
            'features' => $features
        ];

        return view('landing', compact('plans', 'stats'));
    }
}

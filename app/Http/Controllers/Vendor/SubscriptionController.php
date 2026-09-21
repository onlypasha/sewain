<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->vendorProfiles;
        $subscription = $profile ? Subscription::with(['subscriptionPlan', 'purchases.subscription.subscriptionPlan'])->where('vendor_profile_id', $profile->id)->latest()->first() : null;
        $plans = SubscriptionPlan::all();

        $purchases = $subscription ? $subscription->purchases()->latest()->get() : collect();

        $maxAsset = $subscription?->subscriptionPlan?->getMaxAssets() ?? 0;

        return view('vendor.subscription', compact('subscription', 'maxAsset', 'plans', 'purchases'));
    }
}

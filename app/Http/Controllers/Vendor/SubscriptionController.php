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

        $maxAsset = 0;
        if ($subscription && $subscription->subscriptionPlan && is_array($subscription->subscriptionPlan->features)) {
            foreach ($subscription->subscriptionPlan->features as $feature) {
                if (is_array($feature)) {
                    $name = $feature['name'] ?? '';
                    if (stripos($name, 'aset') !== false || stripos($name, 'asset') !== false) {
                        $maxAsset = $feature['value'] ?? 0;
                        break;
                    }
                } elseif (is_string($feature)) {
                    if (stripos($feature, 'aset') !== false || stripos($feature, 'asset') !== false) {
                        $maxAsset = $feature;
                        break;
                    }
                }
            }
        }

        return view('vendor.subscription', compact('subscription', 'maxAsset', 'plans', 'purchases'));
    }
}

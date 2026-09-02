<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->vendorProfiles;
        $subscription = $profile ? Subscription::where('vendor_profile_id', $profile->id)->latest()->first() : null;

        return view('vendor.subscription', compact('subscription'));
    }
}

<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPurchase;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->vendorProfiles;

        // Langganan berlaku sebagai acuan status; kalau belum ada, tampilkan
        // record terakhir supaya vendor tetap melihat riwayat pembayarannya.
        $subscription = $user->activeSubscription() ?? $profile?->latestSubscription();
        $plans = SubscriptionPlan::where('is_active', true)->get();

        $purchases = $profile
            ? SubscriptionPurchase::with('subscriptionPlan')
                ->whereIn('subscription_id', $profile->subscriptions()->pluck('id'))
                ->latest()
                ->get()
            : collect();

        $maxAsset = $subscription?->subscriptionPlan?->getMaxAssets() ?? 0;
        $usedAssets = $user->items()->where('status', '!=', 'archived')->count();

        return view('vendor.subscription', compact('subscription', 'maxAsset', 'plans', 'purchases', 'usedAssets'));
    }
}

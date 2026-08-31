<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\VendorProfiles;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest()->get();
        $plans = SubscriptionPlan::select('id', 'name')->get();
        $vendors = VendorProfiles::with('user:id,name')->get();

        return view('superadmin.subscription', compact('subscriptions', 'plans', 'vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_profile_id' => ['required', 'exists:vendor_profiles,id'],
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
            'status' => ['required', 'in:active,inactive,canceled'],
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['subscription_plan_id']);

        $startDate = now();
        $endDate = $plan->billing_cycle === 'yearly'
            ? $startDate->copy()->addYear()
            : $startDate->copy()->addMonth();

        Subscription::create([
            'vendor_profile_id' => $validated['vendor_profile_id'],
            'subscription_plan_id' => $plan->id,
            'status' => $validated['status'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()->route('superadmin.subscription')->with('success', 'Langganan Berhasil');
    }

    public function update(Request $request, int $id)
    {
        $subscription = Subscription::findOrFail($id);

        $validated = $request->validate([
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
            'status' => ['required', 'in:active,inactive,canceled'],
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['subscription_plan_id']);

        if ($subscription->subscription_plan_id != $plan->id) {
            $startDate = $subscription->start_date;
            $endDate = $plan->billing_cycle === 'yearly'
                ? Carbon::parse($startDate)->addYear()
                : Carbon::parse($startDate)->addMonth();

            $subscription->update([
                'subscription_plan_id' => $plan->id,
                'status' => $validated['status'],
                'end_date' => $endDate,
            ]);
        } else {
            $subscription->update([
                'status' => $validated['status'],
            ]);
        }

        return redirect()->route('superadmin.subscription')->with('success', 'Langganan berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        Subscription::findOrFail($id)->delete();

        return redirect()->route('superadmin.subscription')->with('success', 'Langganan berhasil dihapus');
    }
}

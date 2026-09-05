<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPurchase;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class PaymentsController extends Controller
{
    public function index()
    {
        $purchases = SubscriptionPurchase::with([
            'subscription.vendorProfile.user',
            'subscription.subscriptionPlan',
            'subscriptionPlan',
            'verifiedBy',
        ])->latest()->get();

        $pendingCount = SubscriptionPurchase::where('status', 'pending')->count();
        $approvedCount = SubscriptionPurchase::whereIn('status', ['verified', 'approved', 'success'])->count();
        $rejectedCount = SubscriptionPurchase::where('status', 'rejected')->count();
        $totalRevenue = SubscriptionPurchase::whereIn('status', ['verified', 'approved', 'success'])->sum('amount');

        return view('superadmin.payments', compact('purchases', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalRevenue'));
    }

    public function approve($id)
    {
        $purchase = SubscriptionPurchase::findOrFail($id);

        $purchase->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        $subscription = $purchase->subscription;
        if ($subscription) {
            $plan = $purchase->subscriptionPlan ?? $subscription->subscriptionPlan;
            $startDate = now();
            $endDate = ($plan && $plan->billing_cycle === 'yearly') ? now()->addYear() : now()->addMonth();

            $subscription->update([
                'subscription_plan_id' => $plan ? $plan->id : $subscription->subscription_plan_id,
                'status' => 'active',
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }

        Swal::success([
            'title' => 'Pembayaran Diverifikasi',
            'text' => 'Status pembayaran diubah menjadi Lunas dan paket langganan vendor telah berhasil diaktifkan.',
        ]);

        return redirect()->back();
    }

    public function reject($id)
    {
        $purchase = SubscriptionPurchase::findOrFail($id);

        $purchase->update([
            'status' => 'rejected',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        Swal::success([
            'title' => 'Pembayaran Ditolak',
            'text' => 'Status pembayaran diperbarui menjadi Ditolak.',
        ]);

        return redirect()->back();
    }
}

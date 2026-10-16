<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPurchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $result = DB::transaction(function () use ($id) {
            $purchase = SubscriptionPurchase::lockForUpdate()->findOrFail($id);

            // Hanya pembayaran yang masih menunggu yang boleh diproses, supaya
            // request berulang tidak menambah masa aktif berkali-kali.
            if ($purchase->status !== 'pending') {
                return false;
            }

            $purchase->update([
                'status' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $subscription = $purchase->subscription()->lockForUpdate()->first();

            if ($subscription) {
                $plan = $purchase->subscriptionPlan ?? $subscription->subscriptionPlan;

                // Perpanjangan dihitung dari tanggal berakhir yang masih
                // berlaku, sehingga sisa masa aktif tidak hilang.
                $base = $subscription->end_date && $subscription->end_date->gte(today())
                    ? $subscription->end_date->copy()
                    : today();

                $endDate = $plan?->billing_cycle === 'yearly'
                    ? $base->copy()->addYear()
                    : $base->copy()->addMonth();

                $subscription->update([
                    'subscription_plan_id' => $plan?->id ?? $subscription->subscription_plan_id,
                    'status' => 'active',
                    'start_date' => $subscription->start_date ?? today(),
                    'end_date' => $endDate,
                ]);
            }

            return true;
        });

        if (! $result) {
            Swal::error([
                'title' => 'Sudah Diproses',
                'text' => 'Pembayaran ini telah diverifikasi atau ditolak sebelumnya.',
            ]);

            return redirect()->back();
        }

        Swal::success([
            'title' => 'Pembayaran Diverifikasi',
            'text' => 'Status pembayaran diubah menjadi Lunas dan paket langganan vendor telah berhasil diaktifkan.',
        ]);

        return redirect()->back();
    }

    public function reject($id)
    {
        $result = DB::transaction(function () use ($id) {
            $purchase = SubscriptionPurchase::lockForUpdate()->findOrFail($id);

            if ($purchase->status !== 'pending') {
                return false;
            }

            $purchase->update([
                'status' => 'rejected',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            return true;
        });

        if (! $result) {
            Swal::error([
                'title' => 'Sudah Diproses',
                'text' => 'Pembayaran ini telah diverifikasi atau ditolak sebelumnya.',
            ]);

            return redirect()->back();
        }

        Swal::success([
            'title' => 'Pembayaran Ditolak',
            'text' => 'Status pembayaran diperbarui menjadi Ditolak.',
        ]);

        return redirect()->back();
    }
}

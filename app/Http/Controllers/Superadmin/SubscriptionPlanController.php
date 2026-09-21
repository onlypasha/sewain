<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();

        return view('superadmin.subscription-plan', compact('plans'));
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'max_assets' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['max_assets'] = (int) ($validated['max_assets'] ?? 0);

        SubscriptionPlan::create($validated);

        return redirect()->route('superadmin.subscription-plan')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:subscription_plans,slug,'.$id],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'max_assets' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['max_assets'] = (int) ($validated['max_assets'] ?? 0);

        SubscriptionPlan::find($id)->update($validated);

        return redirect()->route('superadmin.subscription-plan')->with('success', 'Paket berhasil diperbarui');
    }

    public function index_features(int $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        return view('superadmin.features', compact('plan'));
    }

    public function store_features(int $id)
    {
        $validated = request()->validate([
            'features' => ['nullable', 'array'],
            'features.*.text' => ['required', 'string', 'max:255'],
            'features.*.is_included' => ['required', 'boolean'],
        ]);

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update(['features' => $validated['features'] ?? []]);

        return redirect()->route('superadmin.subscription.features', $id)->with('success', 'Fitur berhasil disimpan.');
    }

    public function destroy(int $id)
    {
        SubscriptionPlan::find($id)->delete();

        return redirect()->route('superadmin.subscription-plan')->with('success', 'Paket berhasil di hapus');
    }
}

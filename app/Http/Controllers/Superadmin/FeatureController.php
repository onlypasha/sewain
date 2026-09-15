<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::with('subscriptionPlans')->get();
        $plans = SubscriptionPlan::all();

        return view('superadmin.features_management', compact('features', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', 'unique:features,key'],
            'description' => ['nullable', 'string'],
            'plans' => ['nullable', 'array'],
            'plans.*' => ['exists:subscription_plans,id'],
        ]);

        $feature = Feature::create([
            'name' => $validated['name'],
            'key' => $validated['key'],
            'description' => $validated['description'] ?? null,
        ]);

        if (isset($validated['plans'])) {
            $feature->subscriptionPlans()->sync($validated['plans']);
        }

        return redirect()->route('superadmin.features.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $feature = Feature::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', 'unique:features,key,'.$feature->id],
            'description' => ['nullable', 'string'],
            'plans' => ['nullable', 'array'],
            'plans.*' => ['exists:subscription_plans,id'],
        ]);

        $feature->update([
            'name' => $validated['name'],
            'key' => $validated['key'],
            'description' => $validated['description'] ?? null,
        ]);

        if (isset($validated['plans'])) {
            $feature->subscriptionPlans()->sync($validated['plans']);
        } else {
            $feature->subscriptionPlans()->sync([]);
        }

        return redirect()->route('superadmin.features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function toggleMaintenance(Request $request, int $id)
    {
        $feature = Feature::findOrFail($id);

        $validated = $request->validate([
            'is_maintenance' => ['required', 'boolean'],
            'maintenance_message' => ['nullable', 'string'],
        ]);

        $feature->update([
            'is_maintenance' => $validated['is_maintenance'],
            'maintenance_message' => $validated['is_maintenance'] ? $validated['maintenance_message'] : null,
        ]);

        $status = $validated['is_maintenance'] ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('superadmin.features.index')->with('success', "Mode maintenance untuk fitur {$feature->name} berhasil {$status}.");
    }

    public function destroy(int $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->delete();

        return redirect()->route('superadmin.features.index')->with('success', 'Fitur berhasil dihapus.');
    }
}

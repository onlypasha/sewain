<?php

use App\Models\Feature;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('halaman superadmin merender tanpa error', function () {
    $admin = User::factory()->create(['role' => 'superadmin']);

    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-smoke']);
    VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner', 'status' => 'active',
    ]);
    SubscriptionPlan::create([
        'name' => 'Paket', 'slug' => 'paket', 'price' => 100000,
        'billing_cycle' => 'monthly', 'is_active' => true,
    ]);

    $this->actingAs($admin);

    foreach ([
        'superadmin.dashboard',
        'superadmin-vendor-management.index',
        'superadmin.payments',
        'superadmin.subscription',
        'superadmin.subscription-plan',
        'superadmin.features.index',
    ] as $routeName) {
        $this->get(route($routeName))->assertOk();
    }
});

test('halaman vendor merender tanpa error', function () {
    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-smoke-vendor']);
    $profile = VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner', 'status' => 'active',
    ]);

    $plan = SubscriptionPlan::create([
        'name' => 'Paket Smoke', 'slug' => 'paket-smoke', 'price' => 100000,
        'billing_cycle' => 'monthly', 'max_assets' => 25, 'is_active' => true,
    ]);

    foreach (['asset_management', 'category_management', 'booking_system'] as $key) {
        $feature = Feature::firstOrCreate(['key' => $key], ['name' => $key]);
        $plan->featuresList()->syncWithoutDetaching([$feature->id]);
    }

    Subscription::create([
        'vendor_profile_id' => $profile->id,
        'subscription_plan_id' => $plan->id,
        'status' => 'active',
        'start_date' => now()->subDay(),
        'end_date' => now()->addMonth(),
    ]);

    $this->actingAs($vendor);

    foreach ([
        'vendor.dashboard',
        'vendor.items',
        'vendor.category',
        'vendor.bookings',
        'vendor.calendar',
        'vendor.settings',
        'vendor.subscription',
        'vendor.dangerzone',
    ] as $routeName) {
        $this->get(route($routeName))->assertOk();
    }
});

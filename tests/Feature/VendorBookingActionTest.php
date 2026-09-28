<?php

use App\Models\Booking;
use App\Models\Feature;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Setup vendor + langganan aktif + fitur booking_system.
 */
function makeActiveVendor(string $slug, string $ownerName): array
{
    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => $slug]);
    $profile = VendorProfiles::create([
        'user_id' => $vendor->id,
        'owner_name' => $ownerName,
        'status' => 'active',
    ]);

    $feature = Feature::firstOrCreate(
        ['key' => 'booking_system'],
        ['name' => 'Booking System', 'description' => 'Sistem booking']
    );

    $plan = SubscriptionPlan::create([
        'name' => 'Pro '.$slug,
        'slug' => 'pro-'.$slug,
        'price' => 100000,
        'billing_cycle' => 'monthly',
        'is_active' => true,
    ]);
    $plan->featuresList()->sync([$feature->id]);

    Subscription::create([
        'vendor_profile_id' => $profile->id,
        'subscription_plan_id' => $plan->id,
        'status' => 'active',
        'start_date' => now()->subDay(),
        'end_date' => now()->addMonth(),
    ]);

    return [$vendor, $profile];
}

beforeEach(function () {
    [$this->vendor] = makeActiveVendor('toko-a', 'Owner');
    [$this->otherVendor] = makeActiveVendor('toko-b', 'Other');
    $this->customer = User::factory()->create(['role' => 'customer']);

    $category = ItemsCategory::create(['vendor_id' => $this->vendor->id, 'name' => 'Cam']);
    $this->item = Items::create([
        'vendor_id' => $this->vendor->id, 'items_category_id' => $category->id,
        'name' => 'Item A', 'description' => 'd', 'price_per_day' => 100000, 'status' => 'available',
    ]);

    $this->booking = Booking::create([
        'vendor_id' => $this->vendor->id,
        'item_id' => $this->item->id,
        'customer_id' => $this->customer->id,
        'booking_code' => 'SWN-TEST-001',
        'customer_name' => $this->customer->name,
        'customer_phone' => '08123',
        'customer_email' => $this->customer->email,
        'rental_start' => '2026-11-01',
        'rental_end' => '2026-11-05',
        'total_price' => 500000,
        'status' => 'pending',
    ]);
});

test('vendor bisa konfirmasi booking pending', function () {
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('confirmed');
});

test('vendor bisa tolak booking pending', function () {
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/reject")->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('cancelled');
});

test('vendor lain tidak bisa konfirmasi booking orang', function () {
    $this->actingAs($this->otherVendor);
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertStatus(403);
    expect($this->booking->fresh()->status)->toBe('pending');
});

test('customer tidak bisa konfirmasi booking', function () {
    $this->actingAs($this->customer);
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertStatus(403);
});

test('guest tidak bisa konfirmasi booking', function () {
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertRedirect(route('login'));
});

test('tidak bisa konfirmasi booking yang sudah cancelled', function () {
    $this->booking->update(['status' => 'cancelled']);
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertSessionHasErrors();
    expect($this->booking->fresh()->status)->toBe('cancelled');
});

test('tidak bisa konfirmasi booking yang sudah confirmed', function () {
    $this->booking->update(['status' => 'confirmed']);
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/confirm")->assertSessionHasErrors();
    expect($this->booking->fresh()->status)->toBe('confirmed');
});

test('vendor bisa tandai booking active jadi completed', function () {
    $this->booking->update(['status' => 'active']);
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/complete")->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('completed');
});

test('tidak bisa complete booking yang masih pending', function () {
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/complete")->assertSessionHasErrors();
    expect($this->booking->fresh()->status)->toBe('pending');
});

test('vendor bisa cancel booking confirmed', function () {
    $this->booking->update(['status' => 'confirmed']);
    $this->actingAs($this->vendor);
    $this->post("/vendor/bookings/{$this->booking->id}/cancel")->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('cancelled');
});

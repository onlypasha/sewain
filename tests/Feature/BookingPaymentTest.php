<?php

use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\Feature;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function makeVendorWithSub(string $slug, string $ownerName): User
{
    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => $slug]);
    $profile = VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => $ownerName, 'status' => 'active',
    ]);
    $feature = Feature::firstOrCreate(['key' => 'booking_system'], ['name' => 'Booking System']);
    $plan = SubscriptionPlan::create([
        'name' => 'Pro '.$slug, 'slug' => 'pro-'.$slug,
        'price' => 100000, 'billing_cycle' => 'monthly', 'is_active' => true,
    ]);
    $plan->featuresList()->sync([$feature->id]);
    Subscription::create([
        'vendor_profile_id' => $profile->id, 'subscription_plan_id' => $plan->id,
        'status' => 'active', 'start_date' => now()->subDay(), 'end_date' => now()->addMonth(),
    ]);

    return $vendor;
}

beforeEach(function () {
    Storage::fake('proofs');
    $this->vendor = makeVendorWithSub('toko-a', 'Owner');
    $this->otherVendor = makeVendorWithSub('toko-b', 'Other');
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->otherCustomer = User::factory()->create(['role' => 'customer']);

    $category = ItemsCategory::create(['vendor_id' => $this->vendor->id, 'name' => 'Cam']);
    $item = Items::create([
        'vendor_id' => $this->vendor->id, 'items_category_id' => $category->id,
        'name' => 'Item A', 'description' => 'd', 'price_per_day' => 100000, 'status' => 'available',
    ]);

    $this->booking = Booking::create([
        'vendor_id' => $this->vendor->id, 'item_id' => $item->id,
        'customer_id' => $this->customer->id, 'booking_code' => 'SWN-TEST-001',
        'customer_name' => $this->customer->name, 'customer_phone' => '08123',
        'rental_start' => '2026-11-01', 'rental_end' => '2026-11-05',
        'total_price' => 500000, 'status' => 'confirmed',
    ]);
});

// RED: belum ada endpoint upload/verify

test('customer bisa upload bukti bayar untuk booking confirmed', function () {
    $this->actingAs($this->customer);
    $file = UploadedFile::fake()->image('bukti.jpg');

    $response = $this->post("/booking-saya/{$this->booking->id}/payment", [
        'payment_proof' => $file,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('booking_payments', [
        'booking_id' => $this->booking->id,
        'status' => 'pending',
    ]);
    expect(BookingPayment::where('booking_id', $this->booking->id)->first()->payment_proof_path)->not->toBeNull();
});

test('customer lain tidak bisa upload bukti untuk booking orang', function () {
    $this->actingAs($this->otherCustomer);
    $file = UploadedFile::fake()->image('bukti.jpg');

    $response = $this->post("/booking-saya/{$this->booking->id}/payment", [
        'payment_proof' => $file,
    ]);

    $response->assertStatus(403);
});

test('validasi: file harus image', function () {
    $this->actingAs($this->customer);
    $file = UploadedFile::fake()->create('doc.pdf', 100);

    $response = $this->post("/booking-saya/{$this->booking->id}/payment", [
        'payment_proof' => $file,
    ]);

    $response->assertSessionHasErrors('payment_proof');
});

test('vendor bisa verifikasi bukti bayar → booking jadi active', function () {
    BookingPayment::create([
        'booking_id' => $this->booking->id, 'amount' => 500000,
        'payment_proof_path' => 'proofs/x.jpg', 'status' => 'pending', 'submitted_at' => now(),
    ]);

    $this->actingAs($this->vendor);
    $response = $this->post("/vendor/bookings/{$this->booking->id}/verify-payment");

    $response->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('active');
    expect(BookingPayment::where('booking_id', $this->booking->id)->first()->status)->toBe('verified');
});

test('vendor bisa tolak bukti bayar', function () {
    BookingPayment::create([
        'booking_id' => $this->booking->id, 'amount' => 500000,
        'payment_proof_path' => 'proofs/x.jpg', 'status' => 'pending', 'submitted_at' => now(),
    ]);

    $this->actingAs($this->vendor);
    $response = $this->post("/vendor/bookings/{$this->booking->id}/reject-payment");

    $response->assertRedirect();
    expect($this->booking->fresh()->status)->toBe('confirmed'); // tetap confirmed
    expect(BookingPayment::where('booking_id', $this->booking->id)->first()->status)->toBe('rejected');
});

test('vendor lain tidak bisa verifikasi bukti', function () {
    BookingPayment::create([
        'booking_id' => $this->booking->id, 'amount' => 500000,
        'payment_proof_path' => 'proofs/x.jpg', 'status' => 'pending', 'submitted_at' => now(),
    ]);

    $this->actingAs($this->otherVendor);
    $this->post("/vendor/bookings/{$this->booking->id}/verify-payment")->assertStatus(403);
});

test('customer & vendor bisa lihat bukti bayar', function () {
    Storage::disk('proofs')->put('proofs/test.jpg', 'fake-image');
    BookingPayment::create([
        'booking_id' => $this->booking->id, 'amount' => 500000,
        'payment_proof_path' => 'proofs/test.jpg', 'status' => 'pending', 'submitted_at' => now(),
    ]);

    $this->actingAs($this->customer);
    $this->get("/booking-saya/{$this->booking->id}/payment-proof")->assertStatus(200);

    $this->actingAs($this->vendor);
    $this->get("/vendor/bookings/{$this->booking->id}/payment-proof")->assertStatus(200);
});

test('orang lain tidak bisa lihat bukti bayar', function () {
    Storage::disk('proofs')->put('proofs/test.jpg', 'fake-image');
    BookingPayment::create([
        'booking_id' => $this->booking->id, 'amount' => 500000,
        'payment_proof_path' => 'proofs/test.jpg', 'status' => 'pending', 'submitted_at' => now(),
    ]);

    $this->actingAs($this->otherCustomer);
    $this->get("/booking-saya/{$this->booking->id}/payment-proof")->assertStatus(403);
});

<?php

use App\Models\Booking;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->vendor = User::factory()->create([
        'role' => 'vendor',
        'password' => 'vendorpass',
    ]);

    $profile = new VendorProfiles([
        'owner_name' => 'Owner',
        'address' => 'Jl Test',
    ]);
    $profile->user_id = $this->vendor->id;
    $profile->status = 'active';
    $profile->save();

    $this->customer = User::factory()->create([
        'role' => 'customer',
        'password' => 'customerpass',
    ]);

    $category = ItemsCategory::create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Kamera',
    ]);

    $this->item = Items::create([
        'vendor_id' => $this->vendor->id,
        'items_category_id' => $category->id,
        'name' => 'Canon EOS',
        'description' => 'Kamera bagus',
        'price_per_day' => 100000,
        'status' => 'available',
    ]);
});

test('booking dapat menyimpan customer_id', function () {
    $booking = Booking::create([
        'vendor_id' => $this->vendor->id,
        'item_id' => $this->item->id,
        'customer_id' => $this->customer->id,
        'booking_code' => 'SWN-TEST-0001',
        'customer_name' => $this->customer->name,
        'customer_phone' => '08123456789',
        'customer_email' => $this->customer->email,
        'rental_start' => '2026-10-01',
        'rental_end' => '2026-10-05',
        'total_price' => 500000,
        'status' => 'pending',
    ]);

    expect($booking->customer_id)->toBe($this->customer->id);
    expect($booking->fresh()->customer_id)->toBe($this->customer->id);
});

test('booking punya relasi customer', function () {
    $booking = Booking::create([
        'vendor_id' => $this->vendor->id,
        'item_id' => $this->item->id,
        'customer_id' => $this->customer->id,
        'booking_code' => 'SWN-TEST-0002',
        'customer_name' => $this->customer->name,
        'rental_start' => '2026-10-01',
        'rental_end' => '2026-10-05',
        'total_price' => 500000,
        'status' => 'pending',
    ]);

    expect($booking->customer)->toBeInstanceOf(User::class);
    expect($booking->customer->id)->toBe($this->customer->id);
});

test('user punya relasi bookings sebagai customer', function () {
    Booking::create([
        'vendor_id' => $this->vendor->id,
        'item_id' => $this->item->id,
        'customer_id' => $this->customer->id,
        'booking_code' => 'SWN-TEST-0003',
        'customer_name' => $this->customer->name,
        'rental_start' => '2026-10-01',
        'rental_end' => '2026-10-05',
        'total_price' => 500000,
        'status' => 'pending',
    ]);

    expect($this->customer->customerBookings)->toHaveCount(1);
});

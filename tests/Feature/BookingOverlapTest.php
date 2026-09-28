<?php

use App\Models\Booking;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\User;
use App\Models\VendorProfiles;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->vendor = User::factory()->create(['role' => 'vendor']);
    $profile = new VendorProfiles(['owner_name' => 'Owner', 'address' => 'Jl Test']);
    $profile->user_id = $this->vendor->id;
    $profile->status = 'active';
    $profile->save();

    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->otherCustomer = User::factory()->create(['role' => 'customer']);

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

    $this->service = app(BookingService::class);
});

function bookingPayload($item, $customer, $start, $end, $code)
{
    return [
        'item_id' => $item->id,
        'customer_id' => $customer->id,
        'customer_name' => $customer->name,
        'customer_phone' => '08123456789',
        'customer_email' => $customer->email,
        'rental_start' => $start,
        'rental_end' => $end,
        'booking_code' => $code,
    ];
}

test('booking pertama berhasil dibuat', function () {
    $booking = $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0001')
    );

    expect($booking->exists)->toBeTrue();
    expect($booking->status)->toBe('pending');
    expect($booking->vendor_id)->toBe($this->vendor->id);
});

test('harga dihitung otomatis dari price_per_day x jumlah hari', function () {
    $booking = $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0002')
    );

    expect((float) $booking->total_price)->toBe(500000.0);
});

test('booking dengan tanggal bentrok ditolak', function () {
    $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0003')
    );

    expect(fn () => $this->service->create(
        bookingPayload($this->item, $this->otherCustomer, '2026-10-03', '2026-10-07', 'SWN-A-0004')
    ))->toThrow(ValidationException::class);

    expect(Booking::count())->toBe(1);
});

test('booking dengan tanggal bersentuhan di ujung ditolak', function () {
    $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0005')
    );

    expect(fn () => $this->service->create(
        bookingPayload($this->item, $this->otherCustomer, '2026-10-05', '2026-10-08', 'SWN-A-0006')
    ))->toThrow(ValidationException::class);
});

test('booking non-overlap diterima', function () {
    $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0007')
    );

    $second = $this->service->create(
        bookingPayload($this->item, $this->otherCustomer, '2026-10-06', '2026-10-10', 'SWN-A-0008')
    );

    expect($second->exists)->toBeTrue();
    expect(Booking::count())->toBe(2);
});

test('booking yang dibatalkan tidak menghalangi tanggal yang sama', function () {
    $first = $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0009')
    );
    $first->update(['status' => 'cancelled']);

    $second = $this->service->create(
        bookingPayload($this->item, $this->otherCustomer, '2026-10-01', '2026-10-05', 'SWN-A-0010')
    );

    expect($second->exists)->toBeTrue();
});

test('item berbeda dengan tanggal sama tetap bisa dibooking', function () {
    $category = ItemsCategory::first();
    $item2 = Items::create([
        'vendor_id' => $this->vendor->id,
        'items_category_id' => $category->id,
        'name' => 'Nikon D5600',
        'description' => 'Kamera lain',
        'price_per_day' => 80000,
        'status' => 'available',
    ]);

    $this->service->create(
        bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'SWN-A-0011')
    );
    $second = $this->service->create(
        bookingPayload($item2, $this->otherCustomer, '2026-10-01', '2026-10-05', 'SWN-A-0012')
    );

    expect($second->exists)->toBeTrue();
});

test('booking_code digenerate otomatis kalau kosong', function () {
    $payload = bookingPayload($this->item, $this->customer, '2026-10-01', '2026-10-05', 'X');
    unset($payload['booking_code']);

    $booking = $this->service->create($payload);

    expect($booking->booking_code)->toStartWith('SWN-');
});

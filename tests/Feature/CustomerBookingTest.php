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
        'slug' => 'lensamania',
        'password' => 'vendorpass',
    ]);
    VendorProfiles::create([
        'user_id' => $this->vendor->id,
        'owner_name' => 'Budi',
        'address' => 'Jakarta',
        'status' => 'active',
    ]);

    $this->customer = User::factory()->create([
        'role' => 'customer',
        'password' => 'customerpass',
    ]);

    $this->otherCustomer = User::factory()->create([
        'role' => 'customer',
        'password' => 'customerpass',
    ]);

    $this->category = ItemsCategory::create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Kamera',
    ]);

    $this->item = Items::create([
        'vendor_id' => $this->vendor->id,
        'items_category_id' => $this->category->id,
        'name' => 'Sony A7 IV',
        'description' => 'Full-frame 33MP 4K60p',
        'price_per_day' => 350000,
        'status' => 'available',
    ]);
});

// RED: semua test harus gagal dulu karena form/endpoint belum ada

test('customer login bisa akses halaman booking item', function () {
    $this->actingAs($this->customer);
    $response = $this->get("/items/{$this->item->id}");

    $response->assertStatus(200);
    // tombol "Pesan Sekarang" aktif (bukan disabled)
    $response->assertSee('Pesan Sekarang');
    $response->assertDontSee('disabled');
});

test('guest tidak bisa booking - redirect login', function () {
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertRedirect(route('login'));
});

test('vendor tidak bisa booking barang sendiri', function () {
    $this->actingAs($this->vendor);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertStatus(403);
});

test('booking dengan tanggal valid berhasil', function () {
    $this->actingAs($this->customer);

    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('bookings', [
        'item_id' => $this->item->id,
        'customer_id' => $this->customer->id,
        'status' => 'pending',
    ]);
});

test('booking tanggal overlapping ditolak', function () {
    $this->actingAs($this->customer);
    $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $this->actingAs($this->otherCustomer);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDays(3)->toDateString(),
        'rental_end' => now()->addDays(7)->toDateString(),
    ]);

    $response->assertSessionHasErrors('rental_start');
    expect(Booking::count())->toBe(1);
});

test('booking tanggal non-overlap diterima', function () {
    $this->actingAs($this->customer);
    $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $this->actingAs($this->otherCustomer);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDays(6)->toDateString(),
        'rental_end' => now()->addDays(10)->toDateString(),
    ]);

    $response->assertRedirect();
    expect(Booking::count())->toBe(2);
});

test('validasi: rental_start wajib & sebelum rental_end', function () {
    $this->actingAs($this->customer);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDays(10)->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);
    $response->assertSessionHasErrors();
});

test('validasi: tidak bisa booking tanggal lampau', function () {
    $this->actingAs($this->customer);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => '2020-01-01',
        'rental_end' => '2020-01-05',
    ]);
    $response->assertSessionHasErrors('rental_start');
});

test('booking item unavailable ditolak', function () {
    $unavailable = Items::create([
        'vendor_id' => $this->vendor->id,
        'items_category_id' => $this->category->id,
        'name' => 'Canon R5',
        'description' => '45MP 8K',
        'price_per_day' => 500000,
        'status' => 'rented',
    ]);

    $this->actingAs($this->customer);
    $response = $this->post("/items/{$unavailable->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertSessionHasErrors();
    expect(Booking::where('item_id', $unavailable->id)->count())->toBe(0);
});

test('setelah booking redirect ke daftar booking customer', function () {
    $this->actingAs($this->customer);
    $response = $this->post("/items/{$this->item->id}/booking", [
        'rental_start' => now()->addDay()->toDateString(),
        'rental_end' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertRedirect(route('customer.bookings'));
});

<?php

use App\Models\Booking;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-a']);
    VendorProfiles::create(['user_id' => $this->vendor->id, 'owner_name' => 'Owner', 'status' => 'active']);
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->otherCustomer = User::factory()->create(['role' => 'customer']);
    $this->superadmin = User::factory()->create(['role' => 'superadmin']);

    $category = ItemsCategory::create(['vendor_id' => $this->vendor->id, 'name' => 'Cam']);
    $this->item = Items::create([
        'vendor_id' => $this->vendor->id, 'items_category_id' => $category->id,
        'name' => 'Item A', 'description' => 'd', 'price_per_day' => 100000, 'status' => 'available',
    ]);
});

test('customer bisa akses /booking-saya', function () {
    $this->actingAs($this->customer);
    $this->get('/booking-saya')->assertStatus(200);
});

test('vendor tidak bisa akses /booking-saya (403)', function () {
    $this->actingAs($this->vendor);
    $this->get('/booking-saya')->assertStatus(403);
});

test('superadmin tidak bisa akses /booking-saya (403)', function () {
    $this->actingAs($this->superadmin);
    $this->get('/booking-saya')->assertStatus(403);
});

test('guest redirect login', function () {
    $this->get('/booking-saya')->assertRedirect(route('login'));
});

test('customer hanya lihat booking milik sendiri', function () {
    // customer A bikin booking
    $this->actingAs($this->customer);
    $this->post("/items/{$this->item->id}/booking", ['rental_start' => '2026-10-01', 'rental_end' => '2026-10-05']);

    // customer B coba akses booking customer A
    $this->actingAs($this->otherCustomer);
    $response = $this->get('/booking-saya');
    $response->assertStatus(200);
    // booking customer A tidak muncul di list customer B
    $response->assertDontSee('Item A');
});

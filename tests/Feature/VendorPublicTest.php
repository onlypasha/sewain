<?php

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
        'name' => 'Lensa Mania',
        'password' => 'vendorpass',
    ]);
    VendorProfiles::create([
        'user_id' => $this->vendor->id,
        'owner_name' => 'Budi Santoso',
        'address' => 'Jl. Sudirman No. 1, Jakarta',
        'status' => 'active',
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

    $this->itemUnavailable = Items::create([
        'vendor_id' => $this->vendor->id,
        'items_category_id' => $this->category->id,
        'name' => 'Canon R5',
        'description' => '45MP 8K',
        'price_per_day' => 500000,
        'status' => 'rented',
    ]);
});

test('halaman vendor publik menampilkan nama toko & info', function () {
    $response = $this->get("/toko/{$this->vendor->slug}");

    $response->assertStatus(200);
    $response->assertSee('Lensa Mania');
    $response->assertSee('Budi Santoso');
    $response->assertSee('Jl. Sudirman');
});

test('halaman vendor publik menampilkan daftar item available', function () {
    $response = $this->get("/toko/{$this->vendor->slug}");

    $response->assertStatus(200);
    $response->assertSee('Sony A7 IV');
    $response->assertSee('350.000');
    // item unavailable tidak muncul
    $response->assertDontSee('Canon R5');
});

test('vendor dengan slug tidak ditemukan 404', function () {
    $response = $this->get('/toko/tidak-ada');

    $response->assertStatus(404);
});

test('vendor inactive/status tidak aktif 404', function () {
    $this->vendor->vendorProfiles()->update(['status' => 'inactive']);

    $response = $this->get("/toko/{$this->vendor->slug}");

    $response->assertStatus(404);
});

test('detail item menampilkan info lengkap', function () {
    $response = $this->get("/items/{$this->item->id}");

    $response->assertStatus(200);
    $response->assertSee('Sony A7 IV');
    $response->assertSee('Full-frame 33MP 4K60p');
    $response->assertSee('350.000');
    $response->assertSee('Lensa Mania'); // nama toko
});

test('detail item unavailable tetap bisa dibuka tapi status terlihat', function () {
    $response = $this->get("/items/{$this->itemUnavailable->id}");

    $response->assertStatus(200);
    $response->assertSee('Canon R5');
    $response->assertSee('Disewa'); // atau status badge
});

test('item tidak ditemukan 404', function () {
    $response = $this->get('/items/999999');

    $response->assertStatus(404);
});
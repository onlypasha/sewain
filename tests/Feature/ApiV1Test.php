<?php

use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

function apiVendorItem(): array {
    $vendor = User::create([
        'name' => 'Vendor API', 'email' => 'vapi@x.com', 'password' => Hash::make('Rahasia#123'),
        'role' => 'vendor', 'slug' => 'vendor-api', 'phone' => '0811',
    ]);
    VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner API',
        'status' => 'active', 'address' => 'Jl. API No 1',
    ]);
    $cat = ItemsCategory::create(['vendor_id' => $vendor->id, 'name' => 'Kamera']);
    $item = Items::create([
        'vendor_id' => $vendor->id, 'items_category_id' => $cat->id,
        'name' => 'Canon EOS', 'description' => 'Kamera bagus',
        'price_per_day' => 150000, 'status' => 'available',
    ]);
    return [$vendor, $item, $cat];
}

function apiCustomer(string $n = 'Customer API', string $e = 'capi@x.com'): User {
    return User::create([
        'name' => $n, 'email' => $e,
        'password' => Hash::make('Rahasia#123'), 'role' => 'customer',
        'slug' => \Illuminate\Support\Str::slug($n) . '-' . uniqid(), 'phone' => '0822',
    ]);
}

// ==================== AUTH ====================

it('register customer baru mengembalikan token', function () {
    $res = $this->postJson('/api/v1/auth/register', [
        'name' => 'Budi', 'email' => 'budi@x.com',
        'password' => 'Rahasia#123', 'password_confirmation' => 'Rahasia#123',
        'phone' => '08123',
    ]);
    $res->assertStatus(201)->assertJsonStructure(['token', 'user' => ['id', 'name', 'email', 'role']]);
    expect($res->json('user.role'))->toBe('customer');
});

it('register menolak email duplikat', function () {
    apiCustomer();
    $this->postJson('/api/v1/auth/register', [
        'name' => 'X', 'email' => 'capi@x.com',
        'password' => 'Rahasia#123', 'password_confirmation' => 'Rahasia#123',
    ])->assertStatus(422)->assertJsonValidationErrors('email');
});

it('login benar mengembalikan token', function () {
    apiCustomer();
    $res = $this->postJson('/api/v1/auth/login', [
        'email' => 'capi@x.com', 'password' => 'Rahasia#123',
    ]);
    $res->assertStatus(200)->assertJsonStructure(['token', 'user']);
});

it('login password salah 422', function () {
    apiCustomer();
    $this->postJson('/api/v1/auth/login', [
        'email' => 'capi@x.com', 'password' => 'salahbanget',
    ])->assertStatus(422)->assertJsonValidationErrors('email');
});

it('me butuh token', function () {
    $this->getJson('/api/v1/auth/me')->assertStatus(401);
});

it('me dengan token mengembalikan profil', function () {
    $user = apiCustomer();
    $this->withToken($user->createToken('test')->plainTextToken)
        ->getJson('/api/v1/auth/me')
        ->assertStatus(200)
        ->assertJsonPath('data.email', 'capi@x.com');
});

it('logout mencabut token', function () {
    $user = apiCustomer();
    $token = $user->createToken('test')->plainTextToken;
    $this->withToken($token)->postJson('/api/v1/auth/logout')->assertStatus(200);
    expect($user->tokens()->count())->toBe(0);
});

// ==================== KATALOG (PUBLIK) ====================

it('daftar vendor publik tanpa login', function () {
    apiVendorItem();
    $this->getJson('/api/v1/vendors')
        ->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'slug']]]);
});

it('detail vendor by slug', function () {
    apiVendorItem();
    $this->getJson('/api/v1/vendors/vendor-api')
        ->assertStatus(200)
        ->assertJsonPath('data.slug', 'vendor-api');
});

it('vendor tidak ada 404', function () {
    $this->getJson('/api/v1/vendors/ngawur')->assertStatus(404);
});

it('daftar item publik', function () {
    apiVendorItem();
    $this->getJson('/api/v1/items')
        ->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'name', 'price_per_day']]]);
});

it('detail item publik', function () {
    [, $item] = apiVendorItem();
    $this->getJson("/api/v1/items/{$item->id}")
        ->assertStatus(200)
        ->assertJsonPath('data.name', 'Canon EOS');
});

it('daftar kategori publik', function () {
    apiVendorItem();
    $this->getJson('/api/v1/categories')
        ->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'name']]]);
});

// ==================== BOOKING ====================

it('buat booking via API butuh login', function () {
    [, $item] = apiVendorItem();
    $this->postJson("/api/v1/items/{$item->id}/booking", [
        'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
    ])->assertStatus(401);
});

it('buat booking via API berhasil', function () {
    [, $item] = apiVendorItem();
    $user = apiCustomer();
    $res = $this->actingAs($user, 'sanctum')
        ->postJson("/api/v1/items/{$item->id}/booking", [
            'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        ]);
    $res->assertStatus(201)->assertJsonStructure(['data' => ['id', 'booking_code', 'status']]);
    expect($res->json('data.status'))->toBe('pending');
    $this->assertDatabaseHas('bookings', ['item_id' => $item->id, 'customer_id' => $user->id]);
});

it('daftar booking customer', function () {
    apiVendorItem();
    $user = apiCustomer();
    $this->actingAs($user, 'sanctum')
        ->getJson('/api/v1/bookings')->assertStatus(200)->assertJsonStructure(['data']);
});

it('customer lain tidak bisa lihat booking orang (IDOR)', function () {
    [, $item] = apiVendorItem();
    $a = apiCustomer('Customer A', 'a-idor@x.com');
    $b = apiCustomer('Customer B', 'b-idor@x.com');

    // A bikin booking
    $booking = $this->actingAs($a, 'sanctum')
        ->postJson("/api/v1/items/{$item->id}/booking", [
            'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        ])->json('data');

    expect($booking)->not->toBeNull();

    // B coba lihat -> harus 403
    $this->actingAs($b, 'sanctum')
        ->getJson("/api/v1/bookings/{$booking['id']}")
        ->assertStatus(403);
});

it('customer lain tidak bisa upload bukti bayar booking orang (IDOR)', function () {
    [, $item] = apiVendorItem();
    $a = apiCustomer('Customer A', 'a-pay@x.com');
    $b = apiCustomer('Customer B', 'b-pay@x.com');

    $booking = $this->actingAs($a, 'sanctum')
        ->postJson("/api/v1/items/{$item->id}/booking", [
            'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        ])->json('data');

    $this->actingAs($b, 'sanctum')
        ->postJson("/api/v1/bookings/{$booking['id']}/payment", [])
        ->assertStatus(403);
});

it('vendor tidak bisa booking barang sendiri via API', function () {
    [$vendor, $item] = apiVendorItem();
    $this->actingAs($vendor, 'sanctum')
        ->postJson("/api/v1/items/{$item->id}/booking", [
            'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        ])->assertStatus(403);
});

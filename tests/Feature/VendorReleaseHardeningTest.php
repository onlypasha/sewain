<?php

use App\Models\Booking;
use App\Models\Feature;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPurchase;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

/**
 * Vendor dengan langganan aktif dan fitur tertentu.
 *
 * @param  array<int, string>  $featureKeys
 * @return array{0: User, 1: VendorProfiles, 2: Subscription, 3: SubscriptionPlan}
 */
function hardeningVendor(string $slug, array $featureKeys = [], ?string $endDate = null, int $maxAssets = 50): array
{
    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => $slug]);
    $profile = VendorProfiles::create([
        'user_id' => $vendor->id,
        'owner_name' => 'Owner '.$slug,
        'status' => 'active',
    ]);

    $plan = SubscriptionPlan::create([
        'name' => 'Paket '.$slug,
        'slug' => 'paket-'.$slug,
        'price' => 100000,
        'billing_cycle' => 'monthly',
        'max_assets' => $maxAssets,
        'is_active' => true,
    ]);

    foreach ($featureKeys as $key) {
        $feature = Feature::firstOrCreate(['key' => $key], ['name' => $key]);
        $plan->featuresList()->syncWithoutDetaching([$feature->id]);
    }

    $subscription = Subscription::create([
        'vendor_profile_id' => $profile->id,
        'subscription_plan_id' => $plan->id,
        'status' => 'active',
        'start_date' => now()->subMonth(),
        'end_date' => $endDate ?? now()->addMonth()->toDateString(),
    ]);

    return [$vendor, $profile, $subscription, $plan];
}

// ---------------------------------------------------------------------------
// Kontrol akses vendor
// ---------------------------------------------------------------------------

test('vendor yang dinonaktifkan kehilangan akses walaupun sesinya masih hidup', function () {
    [$vendor, $profile] = hardeningVendor('toko-nonaktif');

    $this->actingAs($vendor);
    $this->get(route('vendor.dashboard'))->assertOk();

    $profile->update(['status' => 'inactive']);

    // Setiap request produksi memuat ulang user dari sesi, jadi relasi profil
    // yang sudah ter-cache di memori juga harus disegarkan.
    $this->actingAs($vendor->fresh());

    $this->get(route('vendor.dashboard'))->assertRedirect(route('login'));
    $this->assertGuest();
});

test('vendor nonaktif ditolak saat login walau wajib ganti password', function () {
    $vendor = User::factory()->create([
        'role' => 'vendor',
        'password' => 'vendorpass',
        'must_change_password' => true,
    ]);
    VendorProfiles::create([
        'user_id' => $vendor->id,
        'owner_name' => 'Owner',
        'status' => 'inactive',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => $vendor->email,
        'password' => 'vendorpass',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('role yang belum dirilis tidak diberi sesi login', function () {
    $customer = User::factory()->create(['role' => 'customer', 'password' => 'customerpass']);

    $response = $this->post(route('login.store'), [
        'email' => $customer->email,
        'password' => 'customerpass',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

// ---------------------------------------------------------------------------
// Pembuatan akun vendor
// ---------------------------------------------------------------------------

test('vendor baru memakai password acak per akun, bukan password bersama', function () {
    $admin = User::factory()->create(['role' => 'superadmin']);
    $this->actingAs($admin);

    $this->post(route('superadmin-vendor-management.create'), [
        'name' => 'Toko Satu', 'email' => 'toko-satu@example.com', 'slug' => 'toko-satu', 'phone' => '0812345',
    ])->assertSessionHas('vendor_credentials');

    $first = session('vendor_credentials');

    $this->post(route('superadmin-vendor-management.create'), [
        'name' => 'Toko Dua', 'email' => 'toko-dua@example.com', 'slug' => 'toko-dua', 'phone' => '0812346',
    ])->assertSessionHas('vendor_credentials');

    $second = session('vendor_credentials');

    expect($first['password'])->not->toBe($second['password'])
        ->and($first['password'])->not->toBe('p@ssword')
        ->and(strlen($first['password']))->toBe(config('sewain.vendor.initial_password_length'));

    $vendor = User::where('email', 'toko-satu@example.com')->firstOrFail();

    expect(Hash::check($first['password'], $vendor->password))->toBeTrue()
        ->and($vendor->must_change_password)->toBeTrue()
        ->and($vendor->vendorProfiles)->not->toBeNull()
        ->and($vendor->vendorProfiles->status)->toBe('inactive');
});

test('vendor dengan riwayat transaksi diarsipkan, bukan dihapus', function () {
    [$vendor, $profile] = hardeningVendor('toko-riwayat');
    $category = ItemsCategory::create(['vendor_id' => $vendor->id, 'name' => 'Cam']);
    $item = Items::create([
        'vendor_id' => $vendor->id, 'items_category_id' => $category->id,
        'name' => 'Item', 'price_per_day' => 100000, 'status' => 'available',
    ]);
    Booking::create([
        'vendor_id' => $vendor->id, 'item_id' => $item->id,
        'booking_code' => 'SWN-HARD-001', 'customer_name' => 'Penyewa',
        'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        'total_price' => 300000, 'status' => 'pending',
    ]);

    $admin = User::factory()->create(['role' => 'superadmin']);
    $this->actingAs($admin);

    $this->delete(route('superadmin-vendor-management.destroy', $vendor->id))->assertRedirect();

    expect(User::find($vendor->id))->not->toBeNull()
        ->and($profile->fresh()->status)->toBe('inactive')
        ->and(Booking::where('vendor_id', $vendor->id)->count())->toBe(1);
});

test('vendor tanpa riwayat transaksi benar-benar dihapus', function () {
    [$vendor] = hardeningVendor('toko-bersih');

    $admin = User::factory()->create(['role' => 'superadmin']);
    $this->actingAs($admin);

    $this->delete(route('superadmin-vendor-management.destroy', $vendor->id))->assertRedirect();

    expect(User::find($vendor->id))->toBeNull();
});

// ---------------------------------------------------------------------------
// Langganan & pembayaran
// ---------------------------------------------------------------------------

test('langganan yang masa aktifnya sudah lewat dianggap tidak aktif', function () {
    [$vendor] = hardeningVendor('toko-kedaluwarsa', [], now()->subDay()->toDateString());

    expect($vendor->isSubscriptionActive())->toBeFalse();

    $this->actingAs($vendor);
    $this->get(route('vendor.items'))->assertRedirect(route('vendor.dashboard'));
});

test('halaman langganan tetap dapat dibuka saat langganan belum aktif', function () {
    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-baru']);
    VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner Baru', 'status' => 'active',
    ]);

    $this->actingAs($vendor);
    $this->get(route('vendor.subscription'))->assertOk();
});

test('bukti pembayaran langganan tersimpan dan terbaca dari disk proofs', function () {
    Storage::fake('proofs');

    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-bayar']);
    VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner Bayar', 'status' => 'active',
    ]);

    $plan = SubscriptionPlan::create([
        'name' => 'Paket Bayar', 'slug' => 'paket-bayar',
        'price' => 150000, 'billing_cycle' => 'monthly', 'is_active' => true,
    ]);

    $this->actingAs($vendor);

    $this->post(route('vendor.subscription-purchases.store'), [
        'subscription_plan_id' => $plan->id,
        'payment_proof' => UploadedFile::fake()->image('bukti.jpg'),
    ])->assertRedirect(route('vendor.subscription'));

    $purchase = SubscriptionPurchase::latest('id')->firstOrFail();

    expect($purchase->status)->toBe('pending')
        ->and($purchase->payment_proof_path)->not->toBeNull();

    Storage::disk('proofs')->assertExists($purchase->payment_proof_path);

    $this->get(route('vendor.subscription-purchases.proof', $purchase->id))->assertOk();
});

test('pengiriman pembayaran kedua ditolak selama yang pertama belum diverifikasi', function () {
    Storage::fake('proofs');

    $vendor = User::factory()->create(['role' => 'vendor', 'slug' => 'toko-dobel']);
    VendorProfiles::create([
        'user_id' => $vendor->id, 'owner_name' => 'Owner Dobel', 'status' => 'active',
    ]);
    $plan = SubscriptionPlan::create([
        'name' => 'Paket Dobel', 'slug' => 'paket-dobel',
        'price' => 150000, 'billing_cycle' => 'monthly', 'is_active' => true,
    ]);

    $this->actingAs($vendor);

    $payload = [
        'subscription_plan_id' => $plan->id,
        'payment_proof' => UploadedFile::fake()->image('bukti.jpg'),
    ];

    $this->post(route('vendor.subscription-purchases.store'), $payload);
    $this->post(route('vendor.subscription-purchases.store'), $payload);

    expect(SubscriptionPurchase::count())->toBe(1);
});

test('vendor tidak bisa berpindah paket selama langganan aktif', function () {
    Storage::fake('proofs');

    [$vendor] = hardeningVendor('toko-ganti-paket');
    $otherPlan = SubscriptionPlan::create([
        'name' => 'Paket Lain', 'slug' => 'paket-lain',
        'price' => 200000, 'billing_cycle' => 'monthly', 'is_active' => true,
    ]);

    $this->actingAs($vendor);

    $this->post(route('vendor.subscription-purchases.store'), [
        'subscription_plan_id' => $otherPlan->id,
        'payment_proof' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    expect(SubscriptionPurchase::count())->toBe(0);
});

test('verifikasi pembayaran hanya berlaku sekali dan memperpanjang dari tanggal berakhir', function () {
    [$vendor, $profile, $subscription, $plan] = hardeningVendor('toko-perpanjang');
    $admin = User::factory()->create(['role' => 'superadmin']);

    $purchase = SubscriptionPurchase::create([
        'subscription_id' => $subscription->id,
        'subscription_plan_id' => $plan->id,
        'amount' => $plan->price,
        'payment_proof_path' => 'proofs/x.jpg',
        'status' => 'pending',
        'submitted_at' => now(),
    ]);

    $expectedEnd = $subscription->end_date->copy()->addMonth()->toDateString();

    $this->actingAs($admin);
    $this->post(route('superadmin.payments.approve', $purchase->id))->assertRedirect();

    expect($purchase->fresh()->status)->toBe('verified')
        ->and($subscription->fresh()->end_date->toDateString())->toBe($expectedEnd);

    // Request ulang tidak boleh menambah masa aktif lagi.
    $this->post(route('superadmin.payments.approve', $purchase->id))->assertRedirect();

    expect($purchase->fresh()->status)->toBe('verified')
        ->and($subscription->fresh()->end_date->toDateString())->toBe($expectedEnd);
});

test('perpanjangan langganan yang sudah lewat dimulai dari hari verifikasi', function () {
    [$vendor, $profile, $subscription, $plan] = hardeningVendor(
        'toko-perpanjang-lewat',
        [],
        now()->subWeek()->toDateString()
    );
    $subscription->update(['status' => 'active']);

    $purchase = SubscriptionPurchase::create([
        'subscription_id' => $subscription->id,
        'subscription_plan_id' => $plan->id,
        'amount' => $plan->price,
        'payment_proof_path' => 'proofs/y.jpg',
        'status' => 'pending',
        'submitted_at' => now(),
    ]);

    $admin = User::factory()->create(['role' => 'superadmin']);
    $this->actingAs($admin);
    $this->post(route('superadmin.payments.approve', $purchase->id));

    expect($subscription->fresh()->end_date->toDateString())
        ->toBe(today()->addMonth()->toDateString());
});

test('pembayaran yang sudah diverifikasi tidak berubah saat ditolak', function () {
    [$vendor, $profile, $subscription, $plan] = hardeningVendor('toko-tolak');
    $purchase = SubscriptionPurchase::create([
        'subscription_id' => $subscription->id,
        'subscription_plan_id' => $plan->id,
        'amount' => $plan->price,
        'status' => 'pending',
    ]);

    $admin = User::factory()->create(['role' => 'superadmin']);
    $this->actingAs($admin);

    $this->post(route('superadmin.payments.approve', $purchase->id));
    $this->post(route('superadmin.payments.reject', $purchase->id))->assertRedirect();

    expect($purchase->fresh()->status)->toBe('verified');
});

// ---------------------------------------------------------------------------
// Aset
// ---------------------------------------------------------------------------

test('kuota aset paket ditegakkan di backend', function () {
    [$vendor] = hardeningVendor('toko-kuota', ['asset_management'], null, 1);

    Items::create([
        'vendor_id' => $vendor->id, 'name' => 'Aset Pertama',
        'price_per_day' => 50000, 'status' => 'available',
    ]);

    $this->actingAs($vendor);

    $this->post(route('vendor.items.store'), [
        'name' => 'Aset Kedua',
        'price_per_day' => 50000,
        'status' => 'available',
    ]);

    expect(Items::where('vendor_id', $vendor->id)->count())->toBe(1);
});

test('aset yang sudah punya riwayat transaksi diarsipkan dan tidak tampil publik', function () {
    [$vendor] = hardeningVendor('toko-arsip', ['asset_management']);
    $category = ItemsCategory::create(['vendor_id' => $vendor->id, 'name' => 'Cam']);
    $item = Items::create([
        'vendor_id' => $vendor->id, 'items_category_id' => $category->id,
        'name' => 'Kamera Arsip', 'price_per_day' => 100000, 'status' => 'available',
    ]);
    Booking::create([
        'vendor_id' => $vendor->id, 'item_id' => $item->id,
        'booking_code' => 'SWN-ARSIP-001', 'customer_name' => 'Penyewa',
        'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        'total_price' => 200000, 'status' => 'completed',
    ]);

    $this->actingAs($vendor);
    $this->delete(route('vendor.items.destroy', $item->id))->assertRedirect();

    expect($item->fresh()->status)->toBe('archived')
        ->and(Booking::where('item_id', $item->id)->count())->toBe(1);

    $this->get("/items/{$item->id}")->assertNotFound();
    $this->get(route('storefront.vendor', $vendor->slug))->assertDontSee('Kamera Arsip');
});

// ---------------------------------------------------------------------------
// Escaping data penyewa
// ---------------------------------------------------------------------------

test('detail booking tidak menyisipkan data penyewa ke javascript inline', function () {
    [$vendor] = hardeningVendor('toko-xss', ['booking_system']);
    $category = ItemsCategory::create(['vendor_id' => $vendor->id, 'name' => 'Cam']);
    $item = Items::create([
        'vendor_id' => $vendor->id, 'items_category_id' => $category->id,
        'name' => 'Item', 'price_per_day' => 100000, 'status' => 'available',
    ]);

    Booking::create([
        'vendor_id' => $vendor->id, 'item_id' => $item->id,
        'booking_code' => 'SWN-XSS-001',
        'customer_name' => "Budi'; alert('xss'); //",
        'customer_phone' => '08123',
        'rental_start' => '2026-11-01', 'rental_end' => '2026-11-03',
        'total_price' => 200000, 'status' => 'pending',
    ]);

    $this->actingAs($vendor);

    $response = $this->get(route('vendor.bookings'));

    $response->assertOk();
    // Handler lama menyuntikkan nama penyewa ke dalam string JavaScript inline.
    $response->assertDontSee("title: 'Detail Booking', html:", false);
    $response->assertDontSee("html: '<div", false);
    // Detail kini memakai dialog HTML biasa yang di-escape oleh Blade.
    $response->assertSee('detail_booking_modal_', false);
});

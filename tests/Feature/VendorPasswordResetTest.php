<?php

use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->superadmin = User::factory()->create([
        'role' => 'superadmin',
        'password' => 'superadminpass',
    ]);
    $this->vendor = User::factory()->create([
        'role' => 'vendor',
        'password' => 'vendorpass',
    ]);
    VendorProfiles::create([
        'user_id' => $this->vendor->id,
        'owner_name' => 'Owner',
        'status' => 'active',
        'address' => 'Jl Test',
    ]);
});

test('superadmin can reset vendor password', function () {
    $this->actingAs($this->superadmin);

    $response = $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id));

    $response->assertRedirect(route('superadmin-vendor-management.index'));
    $response->assertSessionHas('reset_password');

    $this->vendor->refresh();
    expect($this->vendor->must_change_password)->toBeTrue();
});

test('vendor login redirected to force-password after reset', function () {
    $this->actingAs($this->superadmin);
    $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id));
    $plain = session('reset_password')['password'];

    $this->post('/logout');

    $response = $this->post(route('login.store'), [
        'email' => $this->vendor->email,
        'password' => $plain,
    ]);

    $response->assertRedirect(route('vendor.force-password'));
});

test('non-superadmin cannot reset password', function () {
    $this->actingAs($this->vendor);

    $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id))
        ->assertForbidden();
});

test('guest cannot reset password', function () {
    $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id))
        ->assertRedirect(route('login'));
});

test('vendor must change password before accessing dashboard', function () {
    $this->vendor->update(['must_change_password' => true]);

    $this->actingAs($this->vendor);
    $this->get(route('vendor.dashboard'))->assertRedirect(route('vendor.force-password'));
});

test('vendor can update forced password with current password', function () {
    $this->actingAs($this->superadmin);
    $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id));
    $plain = session('reset_password')['password'];
    $this->post('/logout');

    $this->post(route('login.store'), [
        'email' => $this->vendor->email,
        'password' => $plain,
    ]);

    $response = $this->post(route('vendor.force-password.update'), [
        'current_password' => $plain,
        'password' => 'newSecurePass123',
        'password_confirmation' => 'newSecurePass123',
    ]);

    $response->assertRedirect(route('vendor.dashboard'));
    $this->vendor->refresh();
    expect($this->vendor->must_change_password)->toBeFalse();
});

test('reset invalidates old vendor sessions', function () {
    // create a fake session row for vendor
    DB::table('sessions')->insert([
        'id' => 'test-session-id',
        'user_id' => $this->vendor->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'test',
        'payload' => base64_encode('test'),
        'last_activity' => time(),
    ]);

    $this->actingAs($this->superadmin);
    $this->post(route('superadmin-vendor-management.reset-password', $this->vendor->id));

    expect(DB::table('sessions')->where('user_id', $this->vendor->id)->count())->toBe(0);
});

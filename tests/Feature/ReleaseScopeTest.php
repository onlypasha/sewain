<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Process;

uses(RefreshDatabase::class);

/**
 * Daftar URI yang benar-benar terdaftar ketika modul yang belum dirilis
 * (API Android, area customer, verifikasi KTP) dimatikan.
 *
 * @return array<int, string>
 */
function registeredUrisWithModulesOff(): array
{
    $result = Process::path(base_path())
        ->timeout(60)
        ->env([
            'SEWAIN_API_ENABLED' => 'false',
            'SEWAIN_CUSTOMER_ENABLED' => 'false',
            'SEWAIN_KTP_VERIFICATION_ENABLED' => 'false',
        ])
        ->run(['php', 'artisan', 'route:list', '--json', '--except-vendor']);

    expect($result->successful())->toBeTrue();

    return collect(json_decode($result->output(), true))
        ->pluck('uri')
        ->all();
}

test('API Android tidak didaftarkan saat modul dimatikan', function () {
    $uris = registeredUrisWithModulesOff();

    expect($uris)->not->toContain('api/v1/auth/login');
    expect($uris)->not->toContain('api/v1/items');
    expect($uris)->not->toContain('api/v1/bookings');
});

test('area customer tidak didaftarkan saat modul dimatikan', function () {
    $uris = registeredUrisWithModulesOff();

    expect($uris)->not->toContain('booking-saya');
    expect($uris)->not->toContain('items/{id}/booking');
    expect($uris)->not->toContain('booking-saya/{id}/payment');
});

test('verifikasi KTP tidak didaftarkan saat modul dimatikan', function () {
    expect(registeredUrisWithModulesOff())->not->toContain('vendor/verifications');
});

test('halaman publik dan area vendor tetap tersedia saat modul dimatikan', function () {
    $uris = registeredUrisWithModulesOff();

    expect($uris)->toContain('/');
    expect($uris)->toContain('toko/{slug}');
    expect($uris)->toContain('items/{id}');
    expect($uris)->toContain('login');
    expect($uris)->toContain('vendor/dashboard');
    expect($uris)->toContain('vendor/subscription');
    expect($uris)->toContain('vendor/items');
});

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modul yang Dirilis
    |--------------------------------------------------------------------------
    |
    | Fitur yang tidak dirilis tidak didaftarkan sama sekali, sehingga tidak
    | dapat dipanggil walaupun URL-nya diketahui. Nilai default di sini
    | adalah "mati" supaya konfigurasi produksi aman sejak awal.
    |
    */

    'modules' => [

        'api' => env('SEWAIN_API_ENABLED', false),

        'customer' => env('SEWAIN_CUSTOMER_ENABLED', false),

        'ktp_verification' => env('SEWAIN_KTP_VERIFICATION_ENABLED', false),

    ],

    /*
    |--------------------------------------------------------------------------
    | Akun Superadmin Awal
    |--------------------------------------------------------------------------
    |
    | Kredensial tidak lagi ditanam di dalam kode. Seeder hanya berjalan
    | kalau email dan password diisi lewat environment server.
    |
    */

    'superadmin' => [

        'name' => env('SEWAIN_SUPERADMIN_NAME', 'Super Admin'),

        'email' => env('SEWAIN_SUPERADMIN_EMAIL'),

        'password' => env('SEWAIN_SUPERADMIN_PASSWORD'),

        'phone' => env('SEWAIN_SUPERADMIN_PHONE'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Vendor
    |--------------------------------------------------------------------------
    |
    | Password awal vendor dibuat acak per akun oleh superadmin yang membuat
    | tenant, lalu wajib diganti saat login pertama.
    |
    */

    'vendor' => [

        'initial_password_length' => (int) env('SEWAIN_VENDOR_INITIAL_PASSWORD_LENGTH', 16),

    ],

];

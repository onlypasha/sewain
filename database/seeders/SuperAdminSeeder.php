<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Membuat akun superadmin pertama dari kredensial environment.
     *
     * Kredensial tidak lagi ditanam di dalam kode. Isi lewat .env server:
     * SEWAIN_SUPERADMIN_NAME, SEWAIN_SUPERADMIN_EMAIL,
     * SEWAIN_SUPERADMIN_PASSWORD, dan opsional SEWAIN_SUPERADMIN_PHONE.
     */
    public function run(): void
    {
        $email = config('sewain.superadmin.email');
        $password = config('sewain.superadmin.password');

        if (! $email || ! $password) {
            $this->command?->warn('SEWAIN_SUPERADMIN_EMAIL/PASSWORD belum diisi. Seeder superadmin dilewati.');

            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command?->info('Superadmin dengan email tersebut sudah ada. Seeder dilewati.');

            return;
        }

        User::create([
            'name' => config('sewain.superadmin.name'),
            'email' => $email,
            'password' => $password,
            'role' => 'superadmin',
            'slug' => 'super-admin',
            'phone' => config('sewain.superadmin.phone'),
        ]);

        $this->command?->info('Superadmin dibuat. Segera ganti password setelah login pertama.');
    }
}

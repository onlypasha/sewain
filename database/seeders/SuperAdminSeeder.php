<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'sa@sewain.com',
            'role' => 'superadmin',
            'slug' => 'super-admin',
            'phone' => '085695118600',
            'password' => bcrypt('pwsa!')
        ]); 
    }
}

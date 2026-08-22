<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\User;
use App\Models\VendorProfiles;

class VendorManagementController extends Controller
{
    public function index()
    {
        // get senmua data vendor
        $vendors = User::where('role', 'vendor')->get();

        return view('superadmin.tenant-management', compact('vendors'));
    }

    public function store(CreateVendorRequest $request)
    {
        $data = $request->validated();

        // simpan data vendor ke database
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('p@ssword'),
            'role' => 'vendor',
            'slug' => $data['slug'],
            'phone' => $data['phone'],
        ]);

        VendorProfiles::create([
            'user_id' => $user->id,
            'owner_name' => '',
            'subscription' => '',
            'status' => 'inactive',
            'assets' => 0,
            'address' => '',
        ]);

        return redirect()->route('superadmin.dashboard')->with('Warning', 'Vendor Berhasil dibuat. Silakan melengkapi profil vendor');
    }
}

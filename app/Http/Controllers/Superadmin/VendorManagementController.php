<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\User;
use Illuminate\Support\Str;

class VendorManagementController extends Controller
{
    public function index()
    {
        // get senmua data vendor
        $vendors = User::where('role', 'vendor')->get();
        return view('superadmin.dashboard', compact('vendors'));
    }

    public function store(CreateVendorRequest $request)
    {
        $data = $request->validated();

        // generate slug dari nama vendor
        $data['slug'] = Str::slug($data['name'], '-');

        // simpan data vendor ke database
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('p@ssword'),
            'role' => 'vendor',
            'slug' => $data['slug'],
            'phone' => $data['phone'],
        ]);

        return redirect()->route('superadmin.dashboard')->with('Warning', 'Vendor Berhasil dibuat. Silakan melengkapi profil vendor');
    }
}

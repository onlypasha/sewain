<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVendorRequest;
use App\Models\User;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index()
    {
        // get senmua data vendor
        $vendors = User::where('role', 'vendor')->get();
        return view('vendor.index', compact('vendors'));
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

        return redirect()->route('vendor.dashboard')->with('success', 'Vendor Berhasil dibuat.');
    }
}

<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Http\Request;

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

    public function update(Request $request, int $id)
    {
        $user = User::where('role', 'vendor')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'slug' => ['required', 'string', 'max:255', 'unique:users,slug,'.$id],
            'phone' => ['nullable', 'string', 'max:20'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'slug' => $validated['slug'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        if ($user->vendorProfiles) {
            $user->vendorProfiles->update([
                'owner_name' => $validated['owner_name'] ?? '',
                'status' => $validated['status'],
            ]);
        }

        return redirect()->route('superadmin-vendor-management.index')->with('Warning', 'Tenant berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        $user = User::where('role', 'vendor')->findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin-vendor-management.index')->with('Warning', 'Tenant berhasil dihapus');
    }
}

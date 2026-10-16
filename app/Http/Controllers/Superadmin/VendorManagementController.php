<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Models\User;
use App\Models\VendorProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VendorManagementController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')
            ->with(['vendorProfiles.subscriptions.subscriptionPlan'])
            ->withCount('items')
            ->get();

        return view('superadmin.tenant-management', compact('vendors'));
    }

    public function store(CreateVendorRequest $request)
    {
        $data = $request->validated();

        // Password awal dibuat acak per vendor, bukan memakai password bersama,
        // lalu wajib diganti saat login pertama.
        $plainPassword = Str::password(config('sewain.vendor.initial_password_length', 16));

        $user = DB::transaction(function () use ($data, $plainPassword) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $plainPassword,
                'role' => 'vendor',
                'slug' => $data['slug'],
                'phone' => $data['phone'],
                'must_change_password' => true,
            ]);

            VendorProfiles::create([
                'user_id' => $user->id,
                'owner_name' => '',
                'status' => 'inactive',
                'address' => '',
            ]);

            return $user;
        });

        return redirect()
            ->route('superadmin.dashboard')
            ->with('Warning', 'Vendor berhasil dibuat. Sampaikan kredensial di bawah ke pemilik toko, lalu aktifkan statusnya.')
            ->with('vendor_credentials', [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $plainPassword,
            ]);
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
        $profile = $user->vendorProfiles;

        // Vendor yang sudah punya riwayat transaksi diarsipkan supaya booking
        // dan bukti pembayaran tidak ikut terhapus.
        $hasHistory = $user->bookings()->exists()
            || ($profile && $profile->subscriptions()->whereHas('purchases')->exists());

        if ($hasHistory) {
            $profile?->update(['status' => 'inactive']);

            return redirect()
                ->route('superadmin-vendor-management.index')
                ->with('Warning', 'Vendor memiliki riwayat transaksi sehingga diarsipkan (dinonaktifkan), bukan dihapus.');
        }

        DB::transaction(function () use ($user) {
            $user->vendorProfiles()->delete();
            $user->delete();
        });

        return redirect()->route('superadmin-vendor-management.index')->with('Warning', 'Tenant berhasil dihapus');
    }

    public function resetPassword(int $id)
    {
        $user = User::where('role', 'vendor')->findOrFail($id);

        $plainPassword = Str::password(12);

        $user->update([
            'password' => $plainPassword,
            'must_change_password' => true,
            'remember_token' => Str::random(60),
        ]);

        DB::table('sessions')->where('user_id', $user->id)->delete();

        return redirect()
            ->route('superadmin-vendor-management.index')
            ->with('reset_password', [
                'name' => $user->name,
                'password' => $plainPassword,
            ]);
    }
}

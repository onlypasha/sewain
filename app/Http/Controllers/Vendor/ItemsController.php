<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\ItemsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class ItemsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription() ?? $user->vendorProfiles?->latestSubscription();

        $maxAsset = $subscription?->subscriptionPlan?->getMaxAssets() ?? 0;

        $categories = ItemsCategory::where('vendor_id', $user->id)->orderBy('name')->get();
        $items = Items::with('category')->where('vendor_id', $user->id)->latest()->paginate(20);

        $stats = [
            'total' => Items::where('vendor_id', $user->id)->where('status', '!=', 'archived')->count(),
            'available' => Items::where('vendor_id', $user->id)->where('status', 'available')->count(),
            'unavailable' => Items::where('vendor_id', $user->id)->whereIn('status', ['rented', 'maintenance'])->count(),
        ];

        return view('vendor.items', compact('items', 'categories', 'maxAsset', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'items_category_id' => ['nullable', Rule::exists('items_categories', 'id')->where('vendor_id', Auth::id())],
            'description' => ['nullable', 'string', 'max:1000'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:available,rented,maintenance'],
            'items_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $user = Auth::user();
        $limit = $this->assetLimit($user);

        if ($limit !== null && $user->items()->where('status', '!=', 'archived')->count() >= $limit) {
            Swal::error([
                'title' => 'Kuota Aset Penuh',
                'text' => 'Paket langganan Anda hanya mengizinkan '.$limit.' aset. Perpanjang atau tingkatkan paket untuk menambah aset.',
            ]);

            return redirect()->back()->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('items_photo')) {
            $photoPath = $request->file('items_photo')->store('foto-aset', 'b2');
        }

        Items::create([
            'vendor_id' => $user->id,
            'items_category_id' => $validated['items_category_id'] ?? null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price_per_day' => $validated['price_per_day'],
            'status' => $validated['status'],
            'items_photo' => $photoPath,
        ]);

        Swal::success([
            'title' => 'Aset Ditambahkan',
            'text' => 'Aset baru berhasil ditambahkan ke katalog toko Anda.',
        ]);

        return redirect()->route('vendor.items');
    }

    public function update(Request $request, $id)
    {
        $item = Items::where('vendor_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'items_category_id' => ['nullable', Rule::exists('items_categories', 'id')->where('vendor_id', Auth::id())],
            'description' => ['nullable', 'string', 'max:1000'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:available,rented,maintenance'],
            'items_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $itemData = [
            'name' => $validated['name'],
            'items_category_id' => $validated['items_category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'price_per_day' => $validated['price_per_day'],
            'status' => $validated['status'],
        ];

        $oldPhoto = null;
        if ($request->hasFile('items_photo')) {
            // Simpan foto baru lebih dulu; foto lama baru dihapus setelah
            // pembaruan tercatat, supaya gangguan storage tidak menghilangkan
            // foto yang lama.
            $itemData['items_photo'] = $request->file('items_photo')->store('foto-aset', 'b2');
            $oldPhoto = $item->items_photo;
        }

        $item->update($itemData);

        if ($oldPhoto && Storage::disk('b2')->exists($oldPhoto)) {
            Storage::disk('b2')->delete($oldPhoto);
        }

        Swal::success([
            'title' => 'Aset Diperbarui',
            'text' => 'Informasi aset telah berhasil diperbarui.',
        ]);

        return redirect()->route('vendor.items');
    }

    public function destroy($id)
    {
        $item = Items::where('vendor_id', Auth::id())->findOrFail($id);

        // Aset yang sudah memiliki riwayat transaksi diarsipkan, bukan dihapus,
        // supaya riwayat booking dan pembayaran tetap utuh.
        if ($item->bookings()->exists()) {
            $item->update(['status' => 'archived']);

            Swal::success([
                'title' => 'Aset Diarsipkan',
                'text' => 'Aset ini memiliki riwayat transaksi sehingga diarsipkan dan tidak lagi tampil di katalog.',
            ]);

            return redirect()->route('vendor.items');
        }

        $photo = $item->items_photo;
        $item->delete();

        if ($photo && Storage::disk('b2')->exists($photo)) {
            Storage::disk('b2')->delete($photo);
        }

        Swal::success([
            'title' => 'Aset Dihapus',
            'text' => 'Aset berhasil dihapus dari katalog toko Anda.',
        ]);

        return redirect()->route('vendor.items');
    }

    /**
     * Kuota aset paket yang sedang berlaku. Null berarti tanpa batas.
     */
    private function assetLimit($user): ?int
    {
        $subscription = $user->activeSubscription();

        if (! $subscription) {
            return 0;
        }

        $max = $subscription->subscriptionPlan?->getMaxAssets() ?? 0;

        return is_numeric($max) ? (int) $max : null;
    }
}

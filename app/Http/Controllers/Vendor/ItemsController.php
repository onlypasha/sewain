<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SweetAlert2\Laravel\Swal;

class ItemsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->vendorProfiles;
        $subscription = $profile ? Subscription::where('vendor_profile_id', $profile->id)->latest()->first() : null;

        $maxAsset = $subscription?->subscriptionPlan?->getMaxAssets() ?? 0;

        $categories = ItemsCategory::where('vendor_id', $user->id)->orderBy('name')->get();
        $items = Items::with('category')->where('vendor_id', $user->id)->latest()->get();

        return view('vendor.items', compact('items', 'categories', 'maxAsset'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'items_category_id' => ['nullable', 'exists:items_categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:available,rented,maintenance'],
            'items_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('items_photo')) {
            $file = $request->file('items_photo');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $photoPath = 'foto-aset/'.$filename;
            Storage::disk('b2')->put($photoPath, file_get_contents($file));
        }

        Items::create([
            'vendor_id' => Auth::id(),
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
            'items_category_id' => ['nullable', 'exists:items_categories,id'],
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

        if ($request->hasFile('items_photo')) {
            if ($item->items_photo && Storage::disk('b2')->exists($item->items_photo)) {
                Storage::disk('b2')->delete($item->items_photo);
            }
            $file = $request->file('items_photo');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $photoPath = 'foto-aset/'.$filename;
            Storage::disk('b2')->put($photoPath, file_get_contents($file));
            $itemData['items_photo'] = $photoPath;
        }

        $item->update($itemData);

        Swal::success([
            'title' => 'Aset Diperbarui',
            'text' => 'Informasi aset telah berhasil diperbarui.',
        ]);

        return redirect()->route('vendor.items');
    }

    public function destroy($id)
    {
        $item = Items::where('vendor_id', Auth::id())->findOrFail($id);

        if ($item->items_photo && Storage::disk('b2')->exists($item->items_photo)) {
            Storage::disk('b2')->delete($item->items_photo);
        }

        $item->delete();

        Swal::success([
            'title' => 'Aset Dihapus',
            'text' => 'Aset berhasil dihapus dari katalog toko Anda.',
        ]);

        return redirect()->route('vendor.items');
    }
}

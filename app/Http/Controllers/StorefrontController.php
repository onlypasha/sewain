<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\User;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    /**
     * Halaman publik toko vendor: /vendor/{slug}
     */
    public function show(string $slug)
    {
        $vendor = User::query()
            ->where('role', 'vendor')
            ->where('slug', $slug)
            ->whereHas('vendorProfiles', fn ($q) => $q->where('status', 'active'))
            ->with(['vendorProfiles'])
            ->firstOrFail();

        $items = Items::query()
            ->where('vendor_id', $vendor->id)
            ->where('status', 'available')
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('storefront.vendor', compact('vendor', 'items'));
    }

    /**
     * Detail item publik: /items/{id}
     */
    public function item(int $id)
    {
        $item = Items::query()
            ->with(['vendor.vendorProfiles', 'category'])
            ->findOrFail($id);

        return view('storefront.item', compact('item'));
    }
}

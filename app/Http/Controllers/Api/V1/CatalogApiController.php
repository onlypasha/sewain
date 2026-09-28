<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\ItemsCategory;
use App\Models\User;
use Illuminate\Http\Request;

class CatalogApiController extends Controller
{
    public function vendors(Request $request)
    {
        $vendors = User::query()
            ->where('role', 'vendor')
            ->whereHas('vendorProfiles', fn ($q) => $q->where('status', 'active'))
            ->with('vendorProfiles')
            ->paginate(12);

        return response()->json([
            'data' => $vendors->map(fn ($u) => [
                'id' => $u->id,
                'slug' => $u->slug,
                'name' => $u->name,
                'business_name' => $u->vendorProfiles->business_name ?? $u->name,
                'address' => $u->vendorProfiles->address ?? null,
            ]),
            'meta' => [
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'total' => $vendors->total(),
            ],
        ]);
    }

    public function vendorDetail(string $slug)
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

        return response()->json([
            'data' => [
                'id' => $vendor->id,
                'slug' => $vendor->slug,
                'name' => $vendor->name,
                'business_name' => $vendor->vendorProfiles->business_name ?? $vendor->name,
                'address' => $vendor->vendorProfiles->address ?? null,
                'items' => $items->map(fn ($i) => [
                    'id' => $i->id,
                    'name' => $i->name,
                    'price_per_day' => $i->price_per_day,
                    'status' => $i->status,
                ]),
            ],
        ]);
    }

    public function items(Request $request)
    {
        $items = Items::query()
            ->where('status', 'available')
            ->with(['vendor.vendorProfiles', 'category'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return response()->json([
            'data' => $items->map(fn ($i) => [
                'id' => $i->id,
                'name' => $i->name,
                'description' => $i->description,
                'price_per_day' => $i->price_per_day,
                'status' => $i->status,
                'vendor' => [
                    'id' => $i->vendor->id,
                    'slug' => $i->vendor->slug,
                    'name' => $i->vendor->name,
                ],
                'category' => $i->category ? ['id' => $i->category->id, 'name' => $i->category->name] : null,
            ]),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function itemDetail(int $id)
    {
        $item = Items::query()->with(['vendor.vendorProfiles', 'category'])->findOrFail($id);

        return response()->json([
            'data' => [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price_per_day' => $item->price_per_day,
                'status' => $item->status,
                'vendor' => [
                    'id' => $item->vendor->id,
                    'slug' => $item->vendor->slug,
                    'name' => $item->vendor->name,
                ],
                'category' => $item->category ? ['id' => $item->category->id, 'name' => $item->category->name] : null,
            ],
        ]);
    }

    public function categories()
    {
        $cats = ItemsCategory::all(['id', 'name']);
        return response()->json(['data' => $cats]);
    }
}

<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ItemsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class ItemsCategoryController extends Controller
{
    public function index()
    {
        $categories = ItemsCategory::where('vendor_id', Auth::id())
            ->withCount('items')
            ->latest()
            ->get();

        return view('vendor.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        ItemsCategory::create([
            'vendor_id' => Auth::id(),
            'name' => $validated['name'],
        ]);

        Swal::success([
            'title' => 'Kategori Ditambahkan',
            'text' => 'Kategori aset baru berhasil ditambahkan.',
        ]);

        return redirect()->route('vendor.category');
    }

    public function update(Request $request, $id)
    {
        $category = ItemsCategory::where('vendor_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->update([
            'name' => $validated['name'],
        ]);

        Swal::success([
            'title' => 'Kategori Diperbarui',
            'text' => 'Nama kategori aset berhasil diperbarui.',
        ]);

        return redirect()->route('vendor.category');
    }

    public function destroy($id)
    {
        $category = ItemsCategory::where('vendor_id', Auth::id())->findOrFail($id);

        $category->delete();

        Swal::success([
            'title' => 'Kategori Dihapus',
            'text' => 'Kategori aset berhasil dihapus.',
        ]);

        return redirect()->route('vendor.category');
    }
}

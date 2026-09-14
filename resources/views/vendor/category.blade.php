@extends('vendor.layout')
@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Kategori Aset</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola pengelompokan jenis barang rental toko Anda untuk memudahkan katalogisasi.</p>
            </div>
            <x-util.button variant="primary" size="md" onclick="add_category_modal.showModal()">
                + Tambah Kategori
            </x-util.button>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Total Kategori --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Total Kategori</span>
                    <span class="text-3xl font-extrabold text-slate-900 font-heading leading-none">{{ count($categories) }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Kategori terdaftar</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h10M7 12h10m-8 5h8" />
                    </svg>
                </div>
            </div>

            {{-- Total Barang Terkategori --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-emerald-600 font-mono font-bold uppercase tracking-wider block mb-1">Total Barang Terkategori</span>
                    <span class="text-3xl font-extrabold text-emerald-600 font-heading leading-none">
                        {{ $categories->sum('items_count') }}
                    </span>
                    <span class="text-xs text-slate-500 block mt-1">Barang terhubung</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Categories Table Container --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-slate-900 font-heading text-sm">Daftar Kategori Barang</h3>
                    <p class="text-[11px] text-slate-500">Daftar grup kategori barang yang digunakan untuk mengklasifikasikan aset toko.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5 text-left w-12">NO.</th>
                            <th class="py-3.5 px-4 text-left">Nama Kategori</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Barang</th>
                            <th class="py-3.5 px-4 text-left">Dibuat Pada</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- NO --}}
                                <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $loop->iteration }}</td>

                                {{-- Nama Kategori --}}
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900 text-sm font-heading">{{ $category->name }}</div>
                                </td>

                                {{-- Jumlah Barang --}}
                                <td class="py-4 px-4 text-center">
                                    <x-util.badge variant="neutral" size="sm" class="font-mono font-bold">
                                        {{ $category->items_count }} Barang
                                    </x-util.badge>
                                </td>

                                {{-- Tanggal Dibuat --}}
                                <td class="py-4 px-4 font-mono text-slate-600 text-xs">
                                    {{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-util.button variant="warning" size="xs" onclick="edit_category_modal_{{ $category->id }}.showModal()">
                                            Edit
                                        </x-util.button>
                                        <x-util.button variant="error" size="xs" onclick="delete_category_modal_{{ $category->id }}.showModal()">
                                            Hapus
                                        </x-util.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h10M7 12h10m-8 5h8" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Kategori</h4>
                                    <p class="text-xs text-slate-400 mt-1 font-mono">Klik tombol "+ Tambah Kategori" untuk membuat kategori barang baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal Tambah Kategori --}}
    <dialog id="add_category_modal" class="modal">
        <div class="modal-box bg-white rounded-3xl max-w-md p-6 sm:p-8">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
            </form>

            <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tambah Kategori Aset</h3>
            <p class="text-xs text-slate-500 mb-6">Masukkan nama kategori barang baru untuk toko Anda.</p>

            <form action="{{ route('vendor.category.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" required placeholder="Contoh: Kamera & Lensa, Kendaraan, Alat Camping"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium text-sm">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="add_category_modal.close()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                    <x-util.button variant="primary" type="submit" size="sm">
                        Simpan Kategori
                    </x-util.button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modals Edit & Delete Loop --}}
    @foreach ($categories as $category)
        {{-- Modal Edit Kategori --}}
        <dialog id="edit_category_modal_{{ $category->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 sm:p-8">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Edit Kategori</h3>
                <p class="text-xs text-slate-500 mb-6">Perbarui nama kategori barang ini.</p>

                <form action="{{ route('vendor.category.update', $category->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="edit_name_{{ $category->id }}" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori</label>
                        <input type="text" id="edit_name_{{ $category->id }}" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium text-sm">
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="edit_category_modal_{{ $category->id }}.close()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="warning" type="submit" size="sm">
                            Perbarui Kategori
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        {{-- Modal Hapus Kategori --}}
        <dialog id="delete_category_modal_{{ $category->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Hapus Kategori?</h3>
                <p class="text-xs text-slate-500 mb-5">
                    Apakah Anda yakin ingin menghapus kategori <strong class="text-slate-700">{{ $category->name }}</strong>? Barang yang menggunakan kategori ini akan dikosongkan kategorinya.
                </p>

                <form action="{{ route('vendor.category.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="delete_category_modal_{{ $category->id }}.close()" class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="error" type="submit" size="sm">
                            Ya, Hapus Kategori
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>
    @endforeach
@endsection

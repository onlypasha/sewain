@extends('vendor.layout')
@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Katalog & Stok Aset</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola barang rental toko Anda, tentukan harga sewa harian, dan
                    pantau status ketersediaan.</p>
            </div>
            <x-util.button variant="primary" size="md" onclick="add_item_modal.showModal()">
                + Tambah Aset Baru
            </x-util.button>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Aset --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Total Aset</span>
                    <span
                        class="text-3xl font-extrabold text-slate-900 font-heading leading-none">{{ count($items) }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Barang terdaftar</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            {{-- Kuota Aset --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider block mb-1">Batas Kuota
                        Paket</span>
                    <span
                        class="text-3xl font-extrabold text-indigo-600 font-heading leading-none">{{ $maxAsset }}</span>
                    <span class="text-xs text-slate-500 block mt-1">Slot maksimal</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>

            {{-- Unit Tersedia --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-emerald-600 font-mono font-bold uppercase tracking-wider block mb-1">Siap
                        Disewa</span>
                    <span class="text-3xl font-extrabold text-emerald-600 font-heading leading-none">
                        {{ $items->where('status', 'available')->count() }}
                    </span>
                    <span class="text-xs text-slate-500 block mt-1">Unit ready</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Disewa / Maintenance --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-amber-600 font-mono font-bold uppercase tracking-wider block mb-1">Disewa
                        / Maintenance</span>
                    <span class="text-3xl font-extrabold text-amber-600 font-heading leading-none">
                        {{ $items->whereIn('status', ['rented', 'maintenance'])->count() }}
                    </span>
                    <span class="text-xs text-slate-500 block mt-1">Sedang tidak aktif</span>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Items Table Container --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-slate-900 font-heading text-sm">Daftar Barang & Aset Rental</h3>
                    <p class="text-[11px] text-slate-500">Kelola informasi detail, foto produk, kategori, dan tarif sewa
                        barang toko Anda.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5 text-left w-12">NO.</th>
                            <th class="py-3.5 px-4 text-left">Nama Aset</th>
                            <th class="py-3.5 px-4 text-left">Kategori</th>
                            <th class="py-3.5 px-4 text-right">Sewa / Hari</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-left">Dibuat Pada</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($items as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- NO --}}
                                <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $loop->iteration }}</td>

                                {{-- Nama Aset & Foto --}}
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 flex items-center justify-center text-slate-400">
                                            @if ($item->items_photo)
                                                <img src="{{ Storage::disk('b2')->temporaryUrl($item->items_photo, now()->addMinutes(5)) }}"
                                                    alt="{{ $item->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-sm font-heading">
                                                {{ $item->name }}</div>
                                            <div class="text-[11px] text-slate-500 line-clamp-1 max-w-xs">
                                                {{ $item->description ?? 'Tidak ada deskripsi' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="py-4 px-4">
                                    @if ($item->category)
                                        <x-util.badge variant="neutral" size="xs" class="font-mono">
                                            {{ $item->category->name }}
                                        </x-util.badge>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs italic">-</span>
                                    @endif
                                </td>

                                {{-- Harga / Hari --}}
                                <td class="py-4 px-4 text-right font-mono font-extrabold text-emerald-600 text-sm">
                                    Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($item->status === 'available')
                                        <x-util.badge variant="success" size="sm" class="font-mono">
                                            Tersedia
                                        </x-util.badge>
                                    @elseif ($item->status === 'rented')
                                        <x-util.badge variant="warning" size="sm" class="font-mono">
                                            Disewa
                                        </x-util.badge>
                                    @else
                                        <x-util.badge variant="error" size="sm" class="font-mono">
                                            Maintenance
                                        </x-util.badge>
                                    @endif
                                </td>

                                {{-- Tanggal Dibuat --}}
                                <td class="py-4 px-4 font-mono text-slate-600 text-xs">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-util.button variant="warning" size="xs"
                                            onclick="edit_item_modal_{{ $item->id }}.showModal()">
                                            Edit
                                        </x-util.button>
                                        <x-util.button variant="error" size="xs"
                                            onclick="delete_item_modal_{{ $item->id }}.showModal()">
                                            Hapus
                                        </x-util.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Aset Terdaftar</h4>
                                    <p class="text-xs text-slate-400 mt-1 font-mono">Klik tombol "+ Tambah Aset Baru" di
                                        atas untuk menambahkan barang ke toko Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal Tambah Aset Baru --}}
    <dialog id="add_item_modal" class="modal">
        <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
            </form>

            <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tambah Aset Baru</h3>
            <p class="text-xs text-slate-500 mb-6">Isi informasi barang rental untuk ditambahkan ke katalog toko.</p>

            <form action="{{ route('vendor.items.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4 text-xs">
                @csrf

                <div>
                    <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Barang
                        / Aset</label>
                    <input type="text" id="name" name="name" required
                        placeholder="Contoh: Kamera Sony Alpha A7 III"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium text-sm">
                </div>

                <div>
                    <label for="items_category_id"
                        class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Barang</label>
                    <select id="items_category_id" name="items_category_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-bold text-xs focus:outline-none focus:border-emerald-600">
                        <option value="">Pilih Kategori (Opsional)</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price_per_day"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Sewa / Hari
                            (Rp)</label>
                        <input type="number" id="price_per_day" name="price_per_day" required min="0"
                            step="1000" placeholder="150000"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-mono font-bold text-sm focus:outline-none focus:border-emerald-600">
                    </div>

                    <div>
                        <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status
                            Ketersediaan</label>
                        <select id="status" name="status" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-bold text-xs focus:outline-none focus:border-emerald-600">
                            <option value="available" selected>Tersedia (Ready)</option>
                            <option value="rented">Disewa (Rented)</option>
                            <option value="maintenance">Dalam Perawatan (Maintenance)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description"
                        class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi &
                        Kelengkapan</label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="Jelaskan spesifikasi, kondisi, dan kelengkapan paket barang..."
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-emerald-600 resize-none"></textarea>
                </div>

                <div>
                    <label for="items_photo" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Foto
                        Barang</label>
                    <input type="file" id="items_photo" name="items_photo" accept="image/*"
                        class="file-input file-input-bordered file-input-sm w-full text-xs font-mono">
                    <span class="text-[10px] text-slate-400 mt-1 block font-mono">Format: JPG, PNG, WEBP. Maksimal
                        2MB.</span>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="add_item_modal.close()"
                        class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                    <x-util.button variant="primary" type="submit" size="sm">
                        Simpan Aset
                    </x-util.button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modals Edit & Delete Loop --}}
    @foreach ($items as $item)
        {{-- Modal Edit Aset --}}
        <dialog id="edit_item_modal_{{ $item->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Edit Informasi Aset</h3>
                <p class="text-xs text-slate-500 mb-6">Perbarui detail, harga sewa, kategori, atau status barang rental
                    ini.</p>

                <form action="{{ route('vendor.items.update', $item->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="edit_name_{{ $item->id }}"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Barang / Aset</label>
                        <input type="text" id="edit_name_{{ $item->id }}" name="name"
                            value="{{ old('name', $item->name) }}" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-600 font-medium text-sm">
                    </div>

                    <div>
                        <label for="edit_category_{{ $item->id }}"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Barang</label>
                        <select id="edit_category_{{ $item->id }}" name="items_category_id"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-bold text-xs focus:outline-none focus:border-emerald-600">
                            <option value="">Pilih Kategori (Opsional)</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $item->items_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_price_{{ $item->id }}"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Sewa / Hari
                                (Rp)
                            </label>
                            <input type="number" id="edit_price_{{ $item->id }}" name="price_per_day"
                                value="{{ old('price_per_day', (int) $item->price_per_day) }}" required min="0"
                                step="1000"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-mono font-bold text-sm focus:outline-none focus:border-emerald-600">
                        </div>

                        <div>
                            <label for="edit_status_{{ $item->id }}"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status
                                Ketersediaan</label>
                            <select id="edit_status_{{ $item->id }}" name="status" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-bold text-xs focus:outline-none focus:border-emerald-600">
                                <option value="available" {{ $item->status === 'available' ? 'selected' : '' }}>Tersedia
                                    (Ready)</option>
                                <option value="rented" {{ $item->status === 'rented' ? 'selected' : '' }}>Disewa (Rented)
                                </option>
                                <option value="maintenance" {{ $item->status === 'maintenance' ? 'selected' : '' }}>Dalam
                                    Perawatan (Maintenance)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="edit_desc_{{ $item->id }}"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi &
                            Kelengkapan</label>
                        <textarea id="edit_desc_{{ $item->id }}" name="description" rows="3"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-emerald-600 resize-none">{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div>
                        <label for="edit_photo_{{ $item->id }}"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Barang</label>
                        @if ($item->items_photo)
                            <div class="mb-2 flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img src="{{ Storage::disk('b2')->url($item->items_photo) }}"
                                        alt="{{ $item->name }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[11px] text-slate-500 font-mono">Foto saat ini</span>
                            </div>
                        @endif
                        <input type="file" id="edit_photo_{{ $item->id }}" name="items_photo" accept="image/*"
                            class="file-input file-input-bordered file-input-sm w-full text-xs font-mono">
                        <span class="text-[10px] text-slate-400 mt-1 block font-mono">Pilih foto baru jika ingin
                            mengganti.</span>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="edit_item_modal_{{ $item->id }}.close()"
                            class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="warning" type="submit" size="sm">
                            Perbarui Aset
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        {{-- Modal Hapus Aset --}}
        <dialog id="delete_item_modal_{{ $item->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <div
                    class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Hapus Aset?</h3>
                <p class="text-xs text-slate-500 mb-5">
                    Apakah Anda yakin ingin menghapus barang <strong class="text-slate-700">{{ $item->name }}</strong>
                    dari katalog toko? Tindakan ini tidak dapat dibatalkan.
                </p>

                <form action="{{ route('vendor.items.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="delete_item_modal_{{ $item->id }}.close()"
                            class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="error" type="submit" size="sm">
                            Ya, Hapus Barang
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>
    @endforeach
@endsection

@extends('superadmin.layout')
@section('content')
    <div class="space-y-6 p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Manajemen Fitur Global</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola fitur-fitur platform dan ketersediaannya pada setiap paket
                    langganan.</p>
            </div>
            <x-util.button variant="primary" size="md" onclick="add_feature_modal.showModal()">
                + Tambah Fitur Baru
            </x-util.button>
        </div>

        @if ($errors->any())
            <div class="alert alert-error text-white text-sm font-bold">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-white text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Nama Fitur</th>
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Paket yang Mendapatkan Fitur</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($features as $feature)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="font-mono font-bold text-slate-500 text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-bold text-slate-900 text-sm">{{ $feature->name }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $feature->description ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-sm badge-neutral font-mono">{{ $feature->key }}</span>
                                </td>
                                <td>
                                    @if ($feature->subscriptionPlans->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($feature->subscriptionPlans as $plan)
                                                <span
                                                    class="badge badge-sm bg-indigo-50 text-indigo-700 border-indigo-200 font-bold">
                                                    {{ $plan->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic text-[10px]">Belum diaktifkan di paket
                                            manapun</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($feature->is_maintenance)
                                        <x-util.badge variant="error" size="sm" class="font-mono">
                                            Maintenance
                                        </x-util.badge>
                                    @else
                                        <x-util.badge variant="success" size="sm" class="font-mono">
                                            Aktif
                                        </x-util.badge>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-util.button variant="neutral" size="xs"
                                            onclick="maintenance_feature_modal_{{ $feature->id }}.showModal()">
                                            Maintenance
                                        </x-util.button>
                                        <x-util.button variant="warning" size="xs"
                                            onclick="edit_feature_modal_{{ $feature->id }}.showModal()">
                                            Ubah
                                        </x-util.button>
                                        <x-util.button variant="error" size="xs"
                                            onclick="delete_feature_modal_{{ $feature->id }}.showModal()">
                                            Hapus
                                        </x-util.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Fitur</h4>
                                    <p class="text-xs text-slate-400 mt-1">Tambahkan fitur baru untuk mengatur akses
                                        berdasarkan paket langganan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <dialog id="add_feature_modal" class="modal">
        <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
            </form>

            <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tambah Fitur Baru</h3>
            <p class="text-xs text-slate-500 mb-6">Tambahkan fitur dan atur paket mana saja yang bisa mengaksesnya.</p>

            <form action="{{ route('superadmin.features.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Fitur</label>
                    <input type="text" name="name" required placeholder="Contoh: Modul Booking & Transaksi"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kode / Key</label>
                    <input type="text" name="key" required placeholder="Contoh: booking_system"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-mono text-sm focus:outline-none focus:border-indigo-600">
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan huruf kecil dan underscore. Contoh: api_access,
                        custom_domain.</p>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi</label>
                    <textarea name="description" rows="2" placeholder="Penjelasan singkat fungsi fitur ini..."
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-indigo-600 resize-none"></textarea>
                </div>

                <div class="pt-2">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tersedia untuk
                        Paket:</label>
                    <div class="space-y-2">
                        @foreach ($plans as $plan)
                            <label
                                class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                                <input type="checkbox" name="plans[]" value="{{ $plan->id }}"
                                    class="checkbox checkbox-sm checkbox-primary border-slate-300">
                                <div>
                                    <div class="font-bold text-slate-900">{{ $plan->name }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">Rp
                                        {{ number_format($plan->price, 0, ',', '.') }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="add_feature_modal.close()"
                        class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                    <x-util.button variant="primary" type="submit" size="sm">Simpan Fitur</x-util.button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modals Edit & Delete --}}
    @foreach ($features as $feature)
        <dialog id="edit_feature_modal_{{ $feature->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Ubah Fitur</h3>
                <form action="{{ route('superadmin.features.update', $feature->id) }}" method="POST"
                    class="space-y-4 text-xs mt-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Fitur</label>
                        <input type="text" name="name" value="{{ $feature->name }}" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kode / Key</label>
                        <input type="text" name="key" value="{{ $feature->key }}" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 font-mono text-sm focus:outline-none focus:border-indigo-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi</label>
                        <textarea name="description" rows="2"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-indigo-600 resize-none">{{ $feature->description }}</textarea>
                    </div>

                    <div class="pt-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tersedia untuk
                            Paket:</label>
                        <div class="space-y-2">
                            @foreach ($plans as $plan)
                                <label
                                    class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                                    <input type="checkbox" name="plans[]" value="{{ $plan->id }}"
                                        {{ $feature->subscriptionPlans->contains($plan->id) ? 'checked' : '' }}
                                        class="checkbox checkbox-sm checkbox-primary border-slate-300">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $plan->name }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="edit_feature_modal_{{ $feature->id }}.close()"
                            class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="primary" type="submit" size="sm">Perbarui</x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        <dialog id="delete_feature_modal_{{ $feature->id }}" class="modal">
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

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Hapus Fitur?</h3>
                <p class="text-xs text-slate-500 mb-5">Apakah Anda yakin ingin menghapus fitur <strong
                        class="text-slate-700">{{ $feature->name }}</strong>? Akses ke fitur ini akan ditarik dari semua
                    paket langganan terkait.</p>

                <form action="{{ route('superadmin.features.destroy', $feature->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="delete_feature_modal_{{ $feature->id }}.close()"
                            class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="error" type="submit" size="sm">Ya, Hapus</x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        {{-- Modal Maintenance --}}
        <dialog id="maintenance_feature_modal_{{ $feature->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Mode Maintenance</h3>
                <p class="text-xs text-slate-500 mb-6">Atur status maintenance untuk fitur <strong
                        class="text-slate-700">{{ $feature->name }}</strong>.</p>

                <form action="{{ route('superadmin.features.maintenance', $feature->id) }}" method="POST"
                    class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="hidden" name="is_maintenance" value="0">
                            <input type="checkbox" name="is_maintenance" value="1"
                                {{ $feature->is_maintenance ? 'checked' : '' }}
                                class="checkbox checkbox-sm checkbox-error border-slate-300"
                                onchange="document.getElementById('msg_container_{{ $feature->id }}').classList.toggle('hidden', !this.checked)">
                            <div>
                                <div class="font-bold text-slate-900">Aktifkan Mode Maintenance</div>
                                <div class="text-[10px] text-slate-500">Akan menutup fitur ini sementara untuk semua
                                    pengguna.</div>
                            </div>
                        </label>
                    </div>

                    <div id="msg_container_{{ $feature->id }}" class="{{ $feature->is_maintenance ? '' : 'hidden' }}">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pesan Maintenance
                            (Opsional)</label>
                        <textarea name="maintenance_message" rows="3"
                            placeholder="Contoh: Fitur Booking sedang dalam perbaikan rutin. Kami akan kembali secepatnya."
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-rose-500 resize-none">{{ $feature->maintenance_message }}</textarea>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="maintenance_feature_modal_{{ $feature->id }}.close()"
                            class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="primary" type="submit" size="sm">Simpan Pengaturan</x-util.button>
                    </div>
                </form>
            </div>
        </dialog>
    @endforeach
@endsection

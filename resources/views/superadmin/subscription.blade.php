@extends('superadmin.layout')
@section('content')
    <!-- TAB 3: LANGGANAN & TAGIHAN SAAS MRR -->
    <div id="super-tab-content-subscriptions" class="space-y-6 p-5">
        @if (session()->has('success'))
            <x-util.alert variant="success">
                Langganan berhasil!
            </x-util.alert>
        @endif
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Langganan</h1>
                <p class="text-slate-500 text-xs mt-0.5">Rekapitulasi transaksi berlangganan SaaS tenant, pembayaran
                    otomatis, dan invoice.</p>
            </div>
            <x-util.button variant="primary" size="md" shape="block" onclick="add_subscription.showModal()">
                Langganan baru +
            </x-util.button>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4">NO.</th>
                            <th class="py-3 px-4">Vendor</th>
                            <th class="py-3 px-4">Paket Langganan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Mulai dari</th>
                            <th class="py-3 px-4">Berakhir pada</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="font-mono font-bold text-indigo-700">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ $subscription->vendorProfile?->user?->name ?? 'Tidak diketahui' }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">
                                        {{ $subscription->vendorProfile?->user?->slug }}.sewain.id</div>
                                </td>
                                <td>
                                    <span class="text-lg">
                                        {{ $subscription->subscriptionPlan?->billing_cycle === 'monthly' ? 'Bulanan' : 'Tahunan' }}
                                    </span>
                                </td>
                                <td class="font-mono text-slate-700">
                                    @if ($subscription->status === 'active')
                                        <x-util.badge variant="success">
                                            Aktif
                                        </x-util.badge>
                                    @elseif($subscription->status === 'inactive')
                                        <x-util.badge variant="error">
                                            Tidak Aktif
                                        </x-util.badge>
                                    @else
                                        <x-util.badge variant="neutral">
                                            Dibatalkan
                                        </x-util.badge>
                                    @endif
                                </td>
                                <td class="font-extrabold text-slate-900">{{ $subscription->start_date }}</td>
                                <td class="font-extrabold text-slate-900">{{ $subscription->end_date }}</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-util.button variant="warning" size="xs" onclick="edit_subscription_{{ $subscription->id }}.showModal()">
                                            Perbarui
                                        </x-util.button>
                                        <x-util.button variant="error" size="xs" onclick="delete_subscription_{{ $subscription->id }}.showModal()">
                                            Hapus
                                        </x-util.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-util.alert variant="info">Tidak ada yang berlangganan</x-util.alert>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <dialog id="add_subscription" class="modal">
        <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
            </form>

            <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Daftarkan langganan baru</h3>
            <p class="text-xs text-slate-500 mb-6">Pastikan tidak salah memilih vendor dan paket langganan yang sesuai.</p>

            <form action="{{ route('superadmin.subscription.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label for="vendor_profile_id"
                        class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Vendor</label>
                    <select id="vendor_profile_id" name="vendor_profile_id" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                        <option value="" disabled selected>Pilih Vendor</option>
                        @forelse ($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->user?->name ?? 'Tanpa Nama' }}</option>
                        @empty
                            <option value="" disabled>Tidak ada vendor terdaftar</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label for="subscription_plan_id"
                        class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Paket Langganan</label>
                    <select id="subscription_plan_id" name="subscription_plan_id" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                        <option value="" disabled selected>Pilih Paket</option>
                        @forelse($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @empty
                            <option value="" disabled>Tidak ada paket tersedia</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label for="status" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status
                        Langganan</label>
                    <select id="status" name="status" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                        <option value="active">Aktif</option>
                        <option value="inactive" selected>Tidak aktif</option>
                        <option value="canceled">Dibatalkan</option>
                    </select>
                </div>

                {{-- Info Tanggal Mulai dan Berakhir --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mt-2">
                    <h4 class="font-bold text-indigo-900 text-sm mb-2 flex items-center gap-1.5">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Penagihan
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="block text-indigo-600/80 mb-0.5">Tanggal Mulai (started_at)</span>
                            <span class="font-mono font-bold text-indigo-900">Otomatis hari ini</span>
                        </div>
                        <div>
                            <span class="block text-indigo-600/80 mb-0.5">Tanggal Berakhir (ends_at)</span>
                            <span class="font-mono font-bold text-indigo-900">Menyesuaikan Siklus Paket</span>
                        </div>
                    </div>
                </div> {{-- Actions --}}
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="add_subscription.close()"
                        class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                    <x-util.button variant="primary" type="submit" size="sm">
                        Berlangganan
                    </x-util.button>
                </div>
            </form>
        </div>
    </dialog>

    @foreach($subscriptions as $subscription)
        <!-- Modal Edit -->
        <dialog id="edit_subscription_{{ $subscription->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Perbarui Langganan</h3>
                <p class="text-xs text-slate-500 mb-6">Ubah paket langganan atau status untuk vendor ini.</p>

                <form action="{{ route('superadmin.subscription.update', $subscription->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Vendor</label>
                        <input type="text" disabled value="{{ $subscription->vendorProfile?->user?->name ?? 'Tidak diketahui' }}"
                            class="w-full px-3 py-2.5 bg-slate-100 border border-slate-300 rounded-xl text-slate-500 font-bold text-sm cursor-not-allowed">
                    </div>

                    <div>
                        <label for="subscription_plan_id_{{ $subscription->id }}" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Paket Langganan</label>
                        <select id="subscription_plan_id_{{ $subscription->id }}" name="subscription_plan_id" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $subscription->subscription_plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status_{{ $subscription->id }}" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status Langganan</label>
                        <select id="status_{{ $subscription->id }}" name="status" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                            <option value="active" {{ $subscription->status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $subscription->status === 'inactive' ? 'selected' : '' }}>Tidak aktif</option>
                            <option value="canceled" {{ $subscription->status === 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="edit_subscription_{{ $subscription->id }}.close()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="warning" type="submit" size="sm">
                            Perbarui Langganan
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        <!-- Modal Hapus -->
        <dialog id="delete_subscription_{{ $subscription->id }}" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4 text-red-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                
                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-2">Hapus Langganan?</h3>
                <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus langganan untuk <strong class="text-slate-700">{{ $subscription->vendorProfile?->user?->name ?? 'Tidak diketahui' }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>

                <form action="{{ route('superadmin.subscription.destroy', $subscription->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" onclick="delete_subscription_{{ $subscription->id }}.close()" class="btn btn-ghost text-slate-600">Batal</button>
                        <x-util.button variant="error" type="submit">
                            Ya, Hapus Langganan
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>
    @endforeach
@endsection

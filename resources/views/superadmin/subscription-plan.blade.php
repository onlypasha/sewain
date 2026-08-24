@extends('superadmin.layout')
@section('content')
    <div id="super-tab-content-subscriptions" class="space-y-6 p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Manajemen Paket Langganan</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola paket langganan secara detail</p>
            </div>

            {{-- <button onclick="openCreateTenantModal()"
                class="btn btn-primary btn-sm font-bold text-white shadow-md bg-indigo-600 border-none">
                + Provision Tenant Baru
            </button> --}}
            <x-util.button variant="primary" size="md" shape="block" onclick="add_plan_modal.showModal()">
                Tambah Paket +
            </x-util.button>
        </div>

        @if ($errors->any())
            <x-util.alert variant="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </x-util.alert>
        @endif
        @session('success')
            <x-util.alert>
                {{ $value }}
            </x-util.alert>
        @endsession
        <!-- SUBSCRIPTION BILLING TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Siklus Tagihan</th>
                            <th class="py-3 px-4">Fitur</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="font-mono font-bold text-indigo-700">{{ $loop->iteration }}
                                <td>
                                    <div class="font-bold text-slate-900 text-sm">{{ $plan->name }}</div>
                                </td>
                                <td>
                                    @switch($plan->slug)
                                        @case('basic')
                                            <span class="badge badge-sm badge-success text-white">{{ $plan->slug }}</span>
                                        @break

                                        @case('pro')
                                            <span class="badge badge-sm badge-primary text-white">{{ $plan->slug }}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="font-mono text-slate-700">{{ 'Rp ' . number_format($plan->price, 2, ',', '.') }}
                                </td>
                                <td class="font-extrabold text-slate-900">
                                    {{ $plan->billing_cycle === 'monthly' ? 'bulanan' : 'tahunan' }}</td>
                                <td>
                                    <form action="{{ route('superadmin.subscription.features', $plan->id) }}">
                                        <x-util.button variant="primary" size="sm" type="submit">
                                            Lihat fitur
                                        </x-util.button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    @if ($plan->is_active)
                                        <span
                                            class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-sm badge-red text-red-800 bg-red-100 font-bold">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <x-util.button variant="warning" size="sm"
                                        onclick="update_plan_modal{{ $plan->id }}.showModal()">Ubah</x-util.button>
                                    <x-util.button variant="error" size="sm"
                                        onclick="delete_plan_modal{{ $plan->id }}.showModal()">Hapus</x-util.button>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <dialog id="add_plan_modal" class="modal">
            <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                <form method="dialog">
                    <button
                        class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                </form>

                <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Tambah Paket Langganan</h3>
                <p class="text-xs text-slate-500 mb-6">Buat paket langganan baru untuk ditawarkan kepada tenant.</p>

                <form action="{{ route('superadmin.subscription-plan.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    {{-- Nama Langganan --}}
                    <div>
                        <label for="plan-name" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama
                            Langganan</label>
                        <input type="text" id="plan-name" name="name" required placeholder="Contoh: Pro Business"
                            value="{{ old('name') }}"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="plan-slug"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                        <input type="text" id="plan-slug" name="slug" required placeholder="Contoh: pro-business"
                            value="{{ old('slug') }}"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                        @error('slug')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="plan-price"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Harga</label>
                        <input type="number" id="plan-price" name="price" required min="0" step="0.01"
                            placeholder="349000" value="{{ old('price') }}"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-mono font-medium text-sm">
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Siklus Tagihan --}}
                    <div>
                        <label for="plan-billing-cycle"
                            class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Siklus Tagihan</label>
                        <select id="plan-billing-cycle" name="billing_cycle" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                            <option value="" disabled {{ old('billing_cycle') ? '' : 'selected' }}>Pilih siklus tagihan
                            </option>
                            <option value="monthly" {{ old('billing_cycle') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ old('billing_cycle') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                        @error('billing_cycle')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apakah Aktif --}}
                    <div>
                        <label for="plan-is-active" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Apakah
                            Aktif</label>
                        <select id="plan-is-active" name="is_active" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>True</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>False</option>
                        </select>
                        @error('is_active')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="add_plan_modal.close()"
                            class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                        <x-util.button variant="primary" type="submit" size="sm">
                            Simpan Paket Langganan
                        </x-util.button>
                    </div>
                </form>
            </div>
        </dialog>

        @foreach ($plans as $plan)
            <dialog id="update_plan_modal{{ $plan->id }}" class="modal">
                <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                    <form method="dialog">
                        <button
                            class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                    </form>

                    <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Update Paket Langganan</h3>
                    <p class="text-xs text-slate-500 mb-6">Perbarui detail paket langganan.</p>

                    <form action="{{ route('superadmin.subscription-plan.update', $plan->id) }}" method="POST"
                        class="space-y-4 text-xs">
                        @csrf
                        @method('PUT')

                        {{-- Nama Langganan --}}
                        <div>
                            <label for="plan-name" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama
                                Langganan</label>
                            <input type="text" id="plan-name" name="name" required value="{{ $plan->name }}"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="plan-slug"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                            <input type="text" id="plan-slug" name="slug" required value="{{ $plan->slug }}"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-medium text-sm">
                            @error('slug')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label for="plan-price"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Harga</label>
                            <input type="number" id="plan-price" name="price" required min="0" step="0.01"
                                value="{{ $plan->price }}"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-mono font-medium text-sm">
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Siklus Tagihan --}}
                        <div>
                            <label for="plan-billing-cycle"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Siklus Tagihan</label>
                            <select id="plan-billing-cycle" name="billing_cycle" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                                <option value="monthly" {{ $plan->billing_cycle === 'monthly' ? 'selected' : '' }}>Bulanan
                                </option>
                                <option value="yearly" {{ $plan->billing_cycle === 'yearly' ? 'selected' : '' }}>Tahunan
                                </option>
                            </select>
                            @error('billing_cycle')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apakah Aktif --}}
                        <div>
                            <label for="plan-is-active"
                                class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Apakah
                                Aktif</label>
                            <select id="plan-is-active" name="is_active" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-600 font-bold text-sm">
                                <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>True</option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>False</option>
                            </select>
                            @error('is_active')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                            <button type="button" onclick="update_plan_modal{{ $plan->id }}.close()"
                                class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                            <x-util.button variant="primary" type="submit" size="sm">
                                Simpan Perubahan
                            </x-util.button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endforeach

        @foreach ($plans as $plan)
            <dialog id="delete_plan_modal{{ $plan->id }}" class="modal">
                <div class="modal-box bg-white rounded-3xl max-w-lg p-6 sm:p-8">
                    <form method="dialog">
                        <button
                            class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                    </form>

                    <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-1">Perhatian!</h3>
                    <p class="text-xs text-slate-500 mb-6">Apakah anda yakin ingin menghapus paket berikut:</p>
                    <ul>
                        <li>Nama paket: {{ $plan->name }}</li>
                        <li>Kategori: {{ $plan->slug }}</li>
                        <li>Harga Paket: {{ 'Rp ' . number_format($plan->price, 2, ',', '.') }}</li>
                        <li>Siklus tagihan: {{ $plan->billing_cycle }}</li>
                    </ul>
                    <form action="{{ route('superadmin.subscription-plan.destroy', $plan->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                            <button type="button" onclick="delete_plan_modal{{ $plan->id }}.close()"
                                class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                            {{-- <x-util.button variant="error" type="submit" size="sm">
                                Hapus paket ini
                            </x-util.button> --}}
                            <button class="btn btn-error" type="submit">
                                Hapus paket ini
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endforeach

        </div>
    @endsection

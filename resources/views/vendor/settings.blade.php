@extends('vendor.layout')
@section('content')
    <!-- TAB 5: PENGATURAN STOREFRONT & DOMAIN -->
    <div id="tab-content-settings" class="space-y-6">
        @if (session('success'))
            <x-util.alert variant="success">
                {{ session('success') }}
            </x-util.alert>
        @endif

        <form action="{{ route('vendor.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Pengaturan Toko</h1>
                </div>
                <x-util.button variant="primary" type="submit" size="sm">
                    Simpan Perubahan
                </x-util.button>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-900 text-base font-heading border-b border-slate-100 pb-3">Konfigurasi
                        profil
                        toko</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="owner_name" class="block font-bold text-slate-700 mb-1">Owner toko</label>
                            <input type="text" id="owner_name" name="owner_name"
                                value="{{ old('owner_name', $profiles->owner_name) }}"
                                class="input input-bordered input-sm font-mono text-emerald-700 font-bold w-full">
                            @error('owner_name')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block font-bold text-slate-700 mb-1">Nomor telepon toko</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $profiles->user->phone) }}"
                                class="input input-bordered input-sm font-mono text-emerald-700 font-bold w-full">
                            @error('phone')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="address" class="block font-bold text-slate-700 mb-1">Alamat toko</label>
                            <textarea id="address" name="address" class="textarea w-full h-75 resize-none" placeholder="Jl. Kita masih panjang">{{ old('address', $profiles->address) }}</textarea>
                            @error('address')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

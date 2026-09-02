@extends('vendor.layout')
@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <x-util.alert variant="success">
                {{ session('success') }}
            </x-util.alert>
        @endif

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Ubah Password</h1>
            </div>
        </div>

        <form action="{{ route('vendor.changepassword.update') }}" method="POST" class="space-y-6">
            @csrf

            <div id="zona-merah" class="bg-red-100 p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="font-bold text-red-900 text-base font-heading border-b border-slate-100 pb-3">Zona merah</h3>
                <div>
                    <label for="password" class="block font-bold text-slate-700 mb-1">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password baru"
                        class="input input-bordered input-sm font-mono text-emerald-700 font-bold w-full">
                    @error('password')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block font-bold text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password baru"
                        class="input input-bordered input-sm font-mono text-emerald-700 font-bold w-full">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-red-200">
                    <x-util.button variant="error" type="submit" size="sm">
                        Ubah Password
                    </x-util.button>
                </div>
            </div>
        </form>
    </div>
@endsection

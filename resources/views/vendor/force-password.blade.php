@extends('vendor.layout')
@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Ganti Password Wajib</h1>
            <p class="text-slate-500 text-xs mt-1">Superadmin mereset password Anda. Buat password baru untuk lanjut.</p>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-xs font-medium text-amber-800">Anda tidak bisa akses menu lain sebelum mengganti password.</p>
        </div>

        <form action="{{ route('vendor.force-password.update') }}" method="POST" class="space-y-6">
            @csrf
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div role="alert" class="alert alert-error py-2 text-xs">
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                @endif

                <div>
                    <label for="current_password" class="block font-bold text-xs uppercase tracking-wider text-slate-700 mb-1.5">Password Saat Ini (Temporary) <span class="text-rose-500">*</span></label>
                    <input type="password" id="current_password" name="current_password" required placeholder="Password dari superadmin" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:outline-none focus:border-emerald-500">
                    @error('current_password')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-700 mb-1.5">Password Baru <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:outline-none focus:border-emerald-500">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-bold text-xs uppercase tracking-wider text-slate-700 mb-1.5">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <div class="flex items-center justify-between gap-3 pt-4 border-t border-slate-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm text-slate-600">Logout</button>
                    </form>
                    <x-util.button variant="primary" type="submit" size="sm">Simpan & Lanjut</x-util.button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(id, btn) {
            const el = document.getElementById(id);
            if (!el) return;
            el.type = el.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection

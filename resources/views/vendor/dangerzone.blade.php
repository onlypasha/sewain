@extends('vendor.layout')
@section('content')
    <div class="max-w-3xl space-y-6">

        {{-- Header Section --}}
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Zona Merah & Keamanan</h1>
            <p class="text-slate-500 text-xs mt-0.5">Kelola pengaturan sensitif toko Anda seperti perubahan kata sandi dan status langganan.</p>
        </div>

        {{-- SECTION 1: Ubah Password --}}
        <form action="{{ route('vendor.dangerzone.password') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
                {{-- Card Title & Icon --}}
                <div class="flex items-center gap-3 border-b border-slate-100 pb-5">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shadow-xs border border-emerald-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base font-heading">Keamanan Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Gunakan kombinasi password yang kuat dan sulit ditebak orang lain.</p>
                    </div>
                </div>

                {{-- Fields Grid --}}
                <div class="space-y-5">
                    {{-- Password Baru --}}
                    <div>
                        <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-700 mb-1.5">
                            Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                placeholder="Masukkan password baru (min. 8 karakter)"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm font-mono focus:outline-none focus:border-emerald-500 focus:bg-white transition-all">
                            <button type="button" onclick="togglePasswordVisibility('password', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div>
                        <label for="password_confirmation" class="block font-bold text-xs uppercase tracking-wider text-slate-700 mb-1.5">
                            Konfirmasi Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                placeholder="Ulangi password baru Anda"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm font-mono focus:outline-none focus:border-emerald-500 focus:bg-white transition-all">
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Security Requirements Box --}}
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2">
                    <div class="text-xs font-bold text-slate-700 font-heading">Ketentuan Password:</div>
                    <ul class="text-xs text-slate-500 space-y-1.5 font-medium">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Panjang minimal 8 karakter</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pastikan konfirmasi password sama persis</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Button --}}
                <div class="pt-4 flex items-center justify-end border-t border-slate-100">
                    <x-util.button variant="primary" type="submit" size="sm">
                        Simpan Password Baru
                    </x-util.button>
                </div>
            </div>
        </form>

        {{-- SECTION 2: Pembatalan Langganan (Zona Merah) --}}
        @if ($subscription && $subscription->status === 'active')
            <div id="zona-merah" class="bg-rose-50 rounded-3xl border border-rose-200/80 p-6 sm:p-8 space-y-4">
                <div class="flex items-center gap-3 border-b border-rose-200/60 pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold shadow-xs border border-rose-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-rose-900 text-base font-heading">Pembatalan Langganan Toko</h3>
                        <p class="text-xs text-rose-700">Tindakan ini akan menonaktifkan perpanjangan otomatis toko Anda pada periode mendatang.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-2">
                    <div class="text-xs text-rose-800">
                        Akses operasional toko akan tetap berlaku hingga tanggal <strong class="font-mono text-rose-950">{{ $subscription->end_date?->format('d M Y') ?? '-' }}</strong>.
                    </div>
                    <x-util.button variant="error" size="sm" onclick="cancel_subscription_modal.showModal()">
                        Batalkan Langganan
                    </x-util.button>
                </div>
            </div>

            {{-- Modal Konfirmasi Pembatalan Langganan --}}
            <dialog id="cancel_subscription_modal" class="modal">
                <div class="modal-box bg-white rounded-3xl max-w-md p-6 text-center">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-slate-400 hover:text-slate-600">✕</button>
                    </form>

                    <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center mx-auto mb-4 text-rose-500">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="font-extrabold text-xl text-slate-900 font-heading mb-2">Batalkan Langganan Toko?</h3>
                    <p class="text-xs text-slate-500 mb-6">
                        Akses toko Anda akan tetap aktif hingga sisa periode berakhir pada
                        <strong class="text-slate-700">{{ $subscription->end_date?->format('d M Y') ?? '-' }}</strong>.
                        Setelah periode berakhir, toko Anda tidak akan diperpanjang secara otomatis dan menu sidebar akan terkunci.
                    </p>

                    <form action="{{ route('vendor.dangerzone.cancel-subscription') }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-center gap-3">
                            <button type="button" onclick="cancel_subscription_modal.close()" class="btn btn-ghost btn-sm text-slate-600">Batal</button>
                            <x-util.button variant="error" type="submit" size="sm">
                                Ya, Batalkan Langganan
                            </x-util.button>
                        </div>
                    </form>
                </div>
            </dialog>
        @elseif ($subscription && $subscription->status === 'canceled')
            <div id="zona-merah" class="bg-amber-50 rounded-3xl border border-amber-200/80 p-6 sm:p-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg border border-amber-200">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-900 text-base font-heading">Langganan Dalam Proses Pembatalan</h3>
                        <p class="text-xs text-amber-700 mt-0.5">Langganan Anda telah dibatalkan dan tidak akan diperpanjang otomatis pada periode berikutnya.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Interactive Toggle Password Visibility Script --}}
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                btn.classList.add('text-emerald-600');
                btn.classList.remove('text-slate-400');
            } else {
                input.type = 'password';
                btn.classList.remove('text-emerald-600');
                btn.classList.add('text-slate-400');
            }
        }
    </script>
@endsection

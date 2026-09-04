<!-- RIGHT PANEL: LOGIN FORM (7 COLS) -->
<div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between bg-white">
    <div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        @endif
        <!-- Form Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading tracking-tight">
                Masuk ke Dashboard
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1.5">
                Silakan masukkan kredensial akun tenant Anda untuk mengakses panel admin.
            </p>
        </div>

        <!-- LOGIN FORM -->
        <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- FIELD: EMAIL TENANT -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Email Admin Tenant
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                            </path>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required placeholder="admin@namatoko.sewain.id"w
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all font-medium">
                </div>

                <!-- Dynamic Subdomain Detection Pill -->
                <div id="tenant-preview-pill"
                    class="mt-2 text-[11px] font-mono text-slate-500 flex items-center gap-1.5 hidden">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Terdeteksi Portal Tenant: <strong id="detected-subdomain"
                            class="text-emerald-700 font-bold">namatoko.sewain.id</strong></span>
                </div>
            </div>

            <!-- FIELD: KATA SANDI -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    <a href="#"
                        onclick="Swal.fire({ title: 'Reset Password', text: 'Instruksi Reset Password telah disimulasikan ke email tenant Anda.', icon: 'info' })"
                        class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                        Lupa Kata Sandi?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="••••••••••••"
                        class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all font-medium">
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- OPTIONS: REMEMBER ME -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 text-slate-600 font-medium cursor-pointer">
                    <input type="checkbox" class="checkbox checkbox-emerald checkbox-xs rounded border-slate-300">
                    <span>Ingat Sesi Login di Perangkat Ini</span>
                </label>
            </div>

            <!-- PRIMARY EMERALD CTA BUTTON -->
            <button type="submit" id="btn-login-submit"
                class="btn btn-emerald btn-primary w-full py-3.5 font-bold text-white text-sm rounded-xl shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 transition-all group">
                <span>Masuk ke Dashboard Tenant</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </button>
        </form>

        <!-- QUICK DEMO PRESET BUTTONS -->

    </div>

    <!-- BOTTOM REGISTER FOOTER -->
    <div class="mt-8 text-center text-xs text-slate-500 pt-4 border-t border-slate-100">
        <span>Belum mendaftarkan toko sewa Anda?</span>
        <a href="/#subdomain-checker" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline ml-1">
            Cek Subdomain & Mulai Trial 14 Hari &rarr;
        </a>
    </div>
</div>

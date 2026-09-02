@extends('vendor.layout')
@section('content')
    <!-- TAB 4: VERIFIKASI E-KTP & PENYEWA -->
    <div id="tab-content-verifications" class="admin-tab-pane hidden space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Antrean Verifikasi E-KTP Penyewa</h1>
                <p class="text-slate-500 text-xs mt-0.5">Lindungi aset toko rental Anda dengan memverifikasi kelayakan
                    identitas calon penyewa.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Verification Card 1 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <span class="badge badge-sm badge-warning font-mono font-bold text-slate-950">PENDING
                            VERIFICATION</span>
                        <h3 class="font-bold text-slate-900 text-base font-heading mt-1">Siti Rahmawati</h3>
                    </div>
                    <span class="text-xs text-slate-400 font-mono">Order #SEW-94811</span>
                </div>

                <!-- E-KTP Simulation View -->
                <div class="bg-slate-900 text-white p-4 rounded-2xl border border-slate-800 space-y-3 font-mono text-xs">
                    <div
                        class="flex items-center justify-between text-[11px] text-emerald-400 border-b border-slate-800 pb-2">
                        <span>PROVINSI DKI JAKARTA</span>
                        <span>NIK: 3174**********01</span>
                    </div>
                    <div class="flex gap-3 items-center">
                        <div
                            class="w-16 h-20 bg-slate-800 rounded-lg border border-slate-700 flex items-center justify-center text-slate-400 font-bold text-xs shrink-0">
                            FOTO KTP
                        </div>
                        <div class="space-y-1 text-[11px] text-slate-300">
                            <div>Nama: <strong>SITI RAHMAWATI</strong></div>
                            <div>Tgl Lahir: <strong>14-08-1996</strong></div>
                            <div>Alamat: <strong>Kebayoran Baru, Jaksel</strong></div>
                            <div class="text-emerald-400">AI Face Match: <strong>98.4% Match</strong></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button onclick="alert('Verifikasi KTP Siti Rahmawati Ditolak');"
                        class="btn btn-xs btn-outline border-rose-300 text-rose-600 hover:bg-rose-50">Tolak
                        Identitas</button>
                    <button
                        onclick="alert('Verifikasi KTP Siti Rahmawati DISETUJUI! Notifikasi WA disimulasikan ke penyewa.');"
                        class="btn btn-xs btn-emerald btn-primary font-bold">Setujui & Terbitkan PDF Kontrak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

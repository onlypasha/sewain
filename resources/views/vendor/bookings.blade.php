@extends('vendor.layout')
@section('content')
    <!-- TAB 3: TRANSAKSI & PEMESANAN -->
    <div id="tab-content-bookings" class="admin-tab-pane hidden space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Daftar Transaksi & Pemesanan</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola status sewa, serah terima unit, penerbitan PDF kontrak, dan
                    pengembalian deposit.</p>
            </div>
        </div>

        <!-- BOOKINGS TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4">NO. ORDER</th>
                            <th class="py-3 px-4">NAMA PENYEWA & WA</th>
                            <th class="py-3 px-4">ITEM YANG DISEWA</th>
                            <th class="py-3 px-4">PERIODE SEWA</th>
                            <th class="py-3 px-4">TOTAL BIAYA + DEPOSIT</th>
                            <th class="py-3 px-4 text-center">E-KTP & KONTRAK</th>
                            <th class="py-3 px-4 text-center">STATUS SEWA</th>
                            <th class="py-3 px-4 text-right">AKSI OPERASIONAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <!-- Order 1 -->
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-mono font-bold text-emerald-700">#SEW-94812</td>
                            <td>
                                <div class="font-bold text-slate-900 text-sm">Budi Pratama</div>
                                <div class="text-[11px] text-slate-500 font-mono">+62 812-3456-7890</div>
                            </td>
                            <td>
                                <div class="font-bold text-slate-900">Sony Alpha 7 IV + Lensa 24-70mm</div>
                                <div class="text-[11px] text-slate-500">2 Unit • Paket Foto Wedding</div>
                            </td>
                            <td class="font-mono text-slate-700">
                                12 Aug - 15 Aug 2026<br>
                                <span class="text-[10px] text-slate-400 font-normal">(3 Hari)</span>
                            </td>
                            <td>
                                <div class="font-extrabold text-slate-900">Rp 1.375.000</div>
                                <div class="text-[10px] text-amber-700 font-mono">Inc. Deposit Rp 300k</div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-xs badge-success text-white font-mono mb-1">E-KTP
                                    VERIFIED</span><br>
                                <button
                                    onclick="alert('PDF Kontrak Sewa #SEW-94812 Diterbitkan dengan Tanda Tangan Digital.');"
                                    class="text-[10px] text-emerald-600 underline font-semibold">Lihat PDF</button>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-sm badge-info text-white font-bold">Sedang Disewa</span>
                            </td>
                            <td class="text-right">
                                <button
                                    onclick="alert('Pengembalian Unit Dikonfirmasi! Deposit Rp 300.000 dikembalikan ke Budi Pratama.');"
                                    class="btn btn-xs btn-emerald btn-primary font-bold">
                                    Terima Kembali & Refund Deposit
                                </button>
                            </td>
                        </tr>

                        <!-- Order 2 -->
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-mono font-bold text-emerald-700">#SEW-94811</td>
                            <td>
                                <div class="font-bold text-slate-900 text-sm">Siti Rahmawati</div>
                                <div class="text-[11px] text-slate-500 font-mono">+62 819-8765-4321</div>
                            </td>
                            <td>
                                <div class="font-bold text-slate-900">Godox SL60W LED Set</div>
                                <div class="text-[11px] text-slate-500">1 Unit Lighting</div>
                            </td>
                            <td class="font-mono text-slate-700">
                                12 Aug 2026<br>
                                <span class="text-[10px] text-slate-400 font-normal">(1 Hari)</span>
                            </td>
                            <td>
                                <div class="font-extrabold text-slate-900">Rp 220.000</div>
                                <div class="text-[10px] text-amber-700 font-mono">Inc. Deposit Rp 100k</div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-xs badge-warning font-mono font-bold text-slate-950">PERLU
                                    VERIFIKASI</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-sm badge-warning font-bold text-slate-950">Menunggu KTP</span>
                            </td>
                            <td class="text-right">
                                <button onclick="switchAdminTab('verifications')"
                                    class="btn btn-xs btn-warning font-bold text-slate-950">
                                    Cek Foto E-KTP
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('superadmin.layout')
@section('content')
    <!-- TAB 3: LANGGANAN & TAGIHAN SAAS MRR -->
    <div id="super-tab-content-subscriptions" class="space-y-6 p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Tagihan & Billing MRR Platform</h1>
                <p class="text-slate-500 text-xs mt-0.5">Rekapitulasi transaksi berlangganan SaaS tenant, pembayaran
                    otomatis, dan invoice.</p>
            </div>
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-mono font-bold text-indigo-700">#INV-2026-0801</td>
                            <td>
                                <div class="font-bold text-slate-900 text-sm">LensaMania Studio</div>
                                <div class="text-[11px] text-slate-500 font-mono">lensamania.sewain.id</div>
                            </td>
                            <td><span class="badge badge-sm badge-success text-white font-mono">Pro Business</span></td>
                            <td class="font-mono text-slate-700">Tahunan (Disc 20%)</td>
                            <td class="font-extrabold text-slate-900">Rp 3.348.000</td>
                            <td><span class="badge badge-sm badge-outline font-mono">QRIS Midtrans</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

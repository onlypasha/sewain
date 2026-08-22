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

        <!-- SUBSCRIPTION BILLING TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4">INVOICE NO.</th>
                            <th class="py-3 px-4">TENANT & DOMAIN</th>
                            <th class="py-3 px-4">PAKET SAAS</th>
                            <th class="py-3 px-4">SIKLUS TAGIHAN</th>
                            <th class="py-3 px-4">NOMINAL DITAGIH</th>
                            <th class="py-3 px-4">METODE BAYAR</th>
                            <th class="py-3 px-4 text-center">STATUS BAYAR</th>
                            <th class="py-3 px-4 text-right">AKSI INVOICE</th>
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
                            <td class="text-center"><span
                                    class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">PAID
                                    SETTLED</span></td>
                            <td class="text-right"><button onclick="alert('Unduh PDF Invoice #INV-2026-0801');"
                                    class="btn btn-xs btn-ghost text-indigo-600 font-bold">PDF Invoice</button></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-mono font-bold text-indigo-700">#INV-2026-0802</td>
                            <td>
                                <div class="font-bold text-slate-900 text-sm">TransJava Auto Fleet</div>
                                <div class="text-[11px] text-slate-500 font-mono">www.transjavafleet.com</div>
                            </td>
                            <td><span class="badge badge-sm bg-slate-900 text-white font-mono">Enterprise</span></td>
                            <td class="font-mono text-slate-700">Bulanan</td>
                            <td class="font-extrabold text-slate-900">Rp 799.000</td>
                            <td><span class="badge badge-sm badge-outline font-mono">Virtual Account BCA</span></td>
                            <td class="text-center"><span
                                    class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">PAID
                                    SETTLED</span></td>
                            <td class="text-right"><button onclick="alert('Unduh PDF Invoice #INV-2026-0802');"
                                    class="btn btn-xs btn-ghost text-indigo-600 font-bold">PDF Invoice</button> summer</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

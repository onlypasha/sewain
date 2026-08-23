@extends('superadmin.layout')
@section('content')
    <!-- TAB 3: LANGGANAN & TAGIHAN SAAS MRR -->
    <div id="super-tab-content-subscriptions" class="space-y-6 p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">Direktori & Manajemen Seluruh Tenant</h1>
                <p class="text-slate-500 text-xs mt-0.5">Kelola akses 1,428+ toko sewa terdaftar, alokasi subdomain, dan
                    lisensi langganan.</p>
            </div>

            <button onclick="openCreateTenantModal()"
                class="btn btn-primary btn-sm font-bold text-white shadow-md bg-indigo-600 border-none">
                + Provision Tenant Baru
            </button>
        </div>

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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

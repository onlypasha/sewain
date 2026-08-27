@extends('superadmin.layout')
@section('content')
    @props(['vendors'])

    <!-- TAB 2: MANAJEMEN TENANT PLATFORM -->
    <div id="super-tab-content-tenants" class="space-y-6 p-5">
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

        <!-- Filter & Search Bar -->
        {{-- <div
        class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-1 overflow-x-auto max-w-full pb-1 sm:pb-0">
            <button class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white">Semua Tenant
                (1,428)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Pro Business
                (1,240)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Enterprise
                (38)</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-100">Starter
                (150)</button>
        </div>

        <div class="w-full sm:w-64">
            <input type="text" placeholder="Filter nama toko atau domain..."
                class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-indigo-600">
        </div>
    </div> --}}
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

        @if (Session::has('Warning'))
            <div role="alert" class="alert alert-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ Session::get('Warning') }}</span>
            </div>
        @endif

        <!-- TENANTS MASTER TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-mono">
                        <tr>
                            <th class="py-3 px-4">NO. </th>
                            <th class="py-3 px-4">NAMA TOKO & PEMILIK</th>
                            <th class="py-3 px-4">SUBDOMAIN</th>
                            <th class="py-3 px-4">PAKET Langganan</th>
                            <th class="py-3 px-4 text-center">TOTAL ASET</th>
                            <th class="py-3 px-4 text-center">STATUS AKUN</th>
                            <th class="py-3 px-4 text-right">AKSI SUPERADMIN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <!-- Tenant 1 -->
                        {{-- <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="font-mono font-bold text-slate-900">#TNT-841</td>
                        <td>
                            <div class="font-bold text-slate-900 text-sm">LensaMania Studio & Rental</div>
                            <div class="text-[11px] text-slate-500">Andi Pratama • <code
                                    class="text-slate-700">andi@lensamania.com</code></div>
                        </td>
                        <td class="font-mono text-emerald-700 font-bold">lensamania.sewain.id</td>
                        <td><span class="badge badge-sm badge-success text-white font-bold font-mono">Pro
                                Business</span></td>
                        <td class="text-center font-mono font-bold">48 Unit</td>
                        <td class="text-center"><span
                                class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">Aktif</span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="/admin" target="_blank"
                                    class="btn btn-ghost btn-xs text-indigo-600 font-bold">Impersonate</a>
                                <button onclick="alert('Kelola Lisensi Tenant #TNT-841');"
                                    class="btn btn-ghost btn-xs text-slate-600">Edit Tier</button>
                            </div>
                        </td>
                    </tr> --}}
                        @forelse ($vendors as $vendor)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="font-mono font-bold text-slate-900">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-bold text-slate-900 text-sm">{{ $vendor->name }}</div>
                                    <div class="text-[11px] text-slate-500">
                                        {{ $vendor->vendorProfiles->owner_name == '' ? 'Tidak ada nama' : $vendor->vendorProfiles->owner_name }}
                                        •
                                        <code class="text-slate-700">{{ $vendor->email }}</code>
                                    </div>
                                </td>
                                <td class="font-mono text-emerald-700 font-bold">{{ $vendor->slug }}.sewain.id</td>
                                <td>
                                    {{ $vendor->vendorProfiles?->subscriptions->first()?->subscriptionPlan?->name ?? 'Tidak berlangganan' }}
                                </td>
                                <td class="text-center font-mono font-bold">{{ $vendor->vendorProfiles->assets }}</td>
                                <td class="text-center">
                                    @if ($vendor->vendorProfiles->status == 'active')
                                        <span
                                            class="badge badge-sm badge-emerald text-emerald-800 bg-emerald-100 font-bold">Active</span>
                                    @else
                                        <span
                                            class="badge badge-sm badge-red text-red-800 bg-red-100 font-bold">InActive</span>
                                    @endif

                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="/admin" target="_blank"
                                            class="btn btn-ghost btn-xs text-indigo-600 font-bold">Impersonate</a>
                                        <button onclick="alert('Kelola Lisensi Tenant #TNT-841');"
                                            class="btn btn-ghost btn-xs text-slate-600">Edit Tier</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-util.alert variant="info">
                                Tidak ada Vendor terdaftar
                            </x-util.alert>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

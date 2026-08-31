@extends('superadmin.layout')
@section('content')
    <main class="flex-1 p-4 sm:p-6 md:p-8">
        <x-superadmin.overview :vendors="$vendors" :latestVendors="$latestVendors" />
        {{-- <x-superadmin.tenants :vendors="$vendors" /> --}}
        {{-- <x-superadmin.subscriptions />
        <x-superadmin.system-health />
        <x-superadmin.settings /> --}}
    </main>
@endsection

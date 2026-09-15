@extends('vendor.layout')
@section('content')
    <div class="h-[70vh] flex flex-col items-center justify-center text-center px-4">

        {{-- <div
            class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-6 border-4 border-white shadow-xl shadow-slate-200/50">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div> --}}

        <h1 class="text-3xl font-extrabold text-slate-900 font-heading mb-3">Fitur Dalam Perbaikan</h1>

        <div class="max-w-md mx-auto">
            <img src="{{ asset('image/maintenance.png') }}" alt="maintenance">

            <p class="text-slate-600 text-sm leading-relaxed mb-8">
                {{ $message }}
            </p>

            <a href="{{ route('vendor.dashboard') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 hover:shadow-lg hover:shadow-slate-900/20 transition-all">
                &larr; Kembali ke Dashboard
            </a>
        </div>

    </div>
@endsection

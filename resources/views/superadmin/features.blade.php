@extends('superadmin.layout')
@section('content')
    <div class="space-y-6 p-5">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('superadmin.subscription-plan') }}"
                        class="text-indigo-600 hover:text-indigo-800 font-bold text-xs">&larr; Kembali ke Paket</a>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-heading">
                    {{ $plan->name }}</h1>
                <p class="text-slate-500 text-xs mt-0.5">
                    {{ $plan->slug }} &bull;
                    Rp {{ number_format($plan->price, 0, ',', '.') }} /
                    {{ $plan->billing_cycle === 'monthly' ? 'bulan' : 'tahun' }}
                </p>
            </div>
        </div>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success text-white text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Features Form --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <form action="{{ route('superadmin.subscription.features.store', $plan->id) }}" method="POST"
                id="features-form">
                @csrf

                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base font-heading">Daftar Fitur</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tambah atau hapus fitur yang termasuk dalam paket
                            ini.</p>
                    </div>
                    <button type="button" onclick="addFeatureRow()"
                        class="btn btn-primary btn-sm font-bold text-white bg-indigo-600 border-none gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Fitur
                    </button>
                </div>

                @error('features')
                    <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                @enderror

                {{-- Table header --}}
                <div class="grid grid-cols-12 gap-3 mb-2 px-1">
                    <div class="col-span-1 text-[10px] font-mono font-bold text-slate-400 uppercase">#</div>
                    <div class="col-span-5 text-[10px] font-mono font-bold text-slate-400 uppercase">Nama Fitur</div>
                    <div class="col-span-4 text-[10px] font-mono font-bold text-slate-400 uppercase">Nilai / Keterangan
                    </div>
                    <div class="col-span-2 text-[10px] font-mono font-bold text-slate-400 uppercase text-center">Aksi</div>
                </div>

                {{-- Dynamic rows container --}}
                <div id="features-container" class="space-y-2">
                    @forelse ($plan->features ?? [] as $index => $feature)
                        <div class="feature-row grid grid-cols-12 gap-3 items-center bg-slate-50 rounded-xl p-3 border border-slate-200"
                            data-index="{{ $index }}">
                            <div class="col-span-1 text-xs font-mono font-bold text-slate-400 feature-number">
                                {{ $index + 1 }}</div>
                            <div class="col-span-5">
                                <input type="text" name="features[{{ $index }}][name]"
                                    value="{{ $feature['name'] ?? '' }}" required placeholder="Contoh: Maksimal Aset"
                                    class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:border-indigo-600 font-medium">
                                @error("features.{$index}.name")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-4">
                                <input type="text" name="features[{{ $index }}][value]"
                                    value="{{ $feature['value'] ?? '' }}" required
                                    placeholder="Contoh: 50 Unit / Ya / Tidak"
                                    class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:border-indigo-600 font-medium">
                                @error("features.{$index}.value")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 text-center">
                                <button type="button" onclick="removeFeatureRow(this)"
                                    class="btn btn-ghost btn-sm text-red-500 hover:text-red-700 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div id="empty-state"
                            class="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-2xl">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Belum ada fitur. Klik "Tambah Fitur" untuk menambahkan.
                        </div>
                    @endforelse
                </div>

                {{-- Submit --}}
                <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('superadmin.subscription-plan') }}"
                        class="btn btn-ghost btn-sm text-slate-600">Batal</a>
                    <x-util.button variant="primary" type="submit" size="sm">
                        Simpan Semua Fitur
                    </x-util.button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let featureIndex = {{ count($plan->features ?? []) }};

        function addFeatureRow() {
            const container = document.getElementById('features-container');
            const emptyState = document.getElementById('empty-state');
            if (emptyState) emptyState.remove();

            const row = document.createElement('div');
            row.className =
                'feature-row grid grid-cols-12 gap-3 items-center bg-slate-50 rounded-xl p-3 border border-slate-200';
            row.dataset.index = featureIndex;
            row.innerHTML = `
                <div class="col-span-1 text-xs font-mono font-bold text-slate-400 feature-number">${featureIndex + 1}</div>
                <div class="col-span-5">
                    <input type="text"
                           name="features[${featureIndex}][name]"
                           required
                           placeholder="Contoh: Maksimal Aset"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:border-indigo-600 font-medium">
                </div>
                <div class="col-span-4">
                    <input type="text"
                           name="features[${featureIndex}][value]"
                           required
                           placeholder="Contoh: 50 Unit / Ya / Tidak"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:border-indigo-600 font-medium">
                </div>
                <div class="col-span-2 text-center">
                    <button type="button" onclick="removeFeatureRow(this)"
                            class="btn btn-ghost btn-sm text-red-500 hover:text-red-700 hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(row);
            featureIndex++;
            renumberRows();

            row.querySelector('input[name$="[name]"]').focus();
        }

        function removeFeatureRow(button) {
            const row = button.closest('.feature-row');
            row.remove();
            renumberRows();

            const container = document.getElementById('features-container');
            if (container.querySelectorAll('.feature-row').length === 0) {
                const emptyState = document.createElement('div');
                emptyState.id = 'empty-state';
                emptyState.className =
                    'text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-2xl';
                emptyState.innerHTML = `
                    <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Belum ada fitur. Klik "Tambah Fitur" untuk menambahkan.
                `;
                container.appendChild(emptyState);
            }
        }

        function renumberRows() {
            const rows = document.querySelectorAll('.feature-row');
            rows.forEach((row, i) => {
                row.querySelector('.feature-number').textContent = i + 1;
            });
        }
    </script>
@endsection

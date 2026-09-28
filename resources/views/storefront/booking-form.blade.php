@extends('storefront.layout')

@section('title', 'Booking ' . $item->name . ' | Sewain')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="flex items-center gap-2 text-sm text-ink-soft mb-6">
            <a href="{{ route('landing') }}" class="hover:text-ink">Beranda</a>
            <span>/</span>
            @if ($item->vendor?->slug)
                <a href="{{ route('storefront.vendor', $item->vendor->slug) }}" class="hover:text-ink">
                    {{ $item->vendor->name }}
                </a>
                <span>/</span>
            @endif
            <a href="{{ route('storefront.item', $item->id) }}" class="hover:text-ink">{{ $item->name }}</a>
            <span>/</span>
            <span class="text-ink font-medium">Booking</span>
        </nav>

        <h1 class="text-2xl font-display font-bold mb-6">Form Booking</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Form --}}
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('customer.bookings.store', $item->id) }}"
                    class="bg-white rounded-2xl border border-ink/10 p-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="rental_start" class="block text-sm font-medium mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="rental_start" id="rental_start"
                                value="{{ old('rental_start') }}" min="{{ date('Y-m-d') }}" required
                                class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">
                        </div>
                        <div>
                            <label for="rental_end" class="block text-sm font-medium mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="rental_end" id="rental_end"
                                value="{{ old('rental_end') }}" min="{{ date('Y-m-d') }}" required
                                class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">
                        </div>
                    </div>

                    <div>
                        <label for="customer_name" class="block text-sm font-medium mb-1.5">Nama Penyewa</label>
                        <input type="text" name="customer_name" id="customer_name"
                            value="{{ old('customer_name', auth()->user()->name) }}"
                            class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium mb-1.5">No. HP / WhatsApp</label>
                            <input type="text" name="customer_phone" id="customer_phone"
                                value="{{ old('customer_phone', auth()->user()->phone) }}"
                                class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium mb-1.5">Email</label>
                            <input type="email" name="customer_email" id="customer_email"
                                value="{{ old('customer_email', auth()->user()->email) }}"
                                class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium mb-1.5">Catatan (opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-3 py-2 border border-ink/20 rounded-lg text-sm focus:outline-none focus:border-brand-400">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center bg-stempel text-paper font-semibold px-6 py-2.5 rounded-xl hover:bg-stempel-deep transition-all active:scale-[0.99]">
                            Ajukan Booking
                        </button>
                        <a href="{{ route('storefront.item', $item->id) }}"
                            class="text-sm text-ink-soft hover:text-ink px-4 py-2.5">Batal</a>
                    </div>
                </form>
            </div>

            {{-- Ringkasan --}}
            <div class="lg:col-span-1">
                <div class="bg-ink/5 rounded-2xl p-5 sticky top-24">
                    <h2 class="font-semibold mb-3">Ringkasan</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-ink-soft">Item</span>
                            <span class="font-medium text-right">{{ $item->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-ink-soft">Tarif</span>
                            <span class="font-medium">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-ink-soft">Toko</span>
                            <span class="font-medium">{{ $item->vendor->name }}</span>
                        </div>
                    </div>
                    <div class="border-t border-ink/10 mt-4 pt-4">
                        <div class="flex justify-between items-baseline">
                            <span class="text-sm text-ink-soft">Estimasi total</span>
                            <span id="estimate-total" class="text-lg font-bold">Rp 0</span>
                        </div>
                        <p class="text-[11px] text-ink-soft mt-1">Total final dihitung sistem setelah tanggal dipilih.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const rate = {{ (float) $item->price_per_day }};
        const startEl = document.getElementById('rental_start');
        const endEl = document.getElementById('rental_end');
        const totalEl = document.getElementById('estimate-total');

        function updateEstimate() {
            if (!startEl.value || !endEl.value) return;
            const start = new Date(startEl.value);
            const end = new Date(endEl.value);
            const days = Math.floor((end - start) / 86400000) + 1;
            if (days > 0) {
                totalEl.innerText = 'Rp ' + (rate * days).toLocaleString('id-ID');
            }
        }

        startEl.addEventListener('change', () => { endEl.min = startEl.value; updateEstimate(); });
        endEl.addEventListener('change', updateEstimate);
    </script>
@endsection

<section id="faq" class="border-b border-ink/10 py-16 md:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl">
            <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl">Pertanyaan yang sering ditanyakan</h2>
        </div>

        <div class="mt-10 divide-y divide-ink/10 border-y border-ink/10">
            @php
                $faqs = [
                    ['q' => 'Bagaimana cara kerja toko multi-tenant Sewain?', 'a' => 'Setiap toko punya data, penyimpanan, dan alamat sendiri (namatoko.sewain.id). Data toko Anda terpisah sepenuhnya dan tidak tercampur dengan toko lain.'],
                    ['q' => 'Apakah ada potongan komisi dari setiap transaksi?', 'a' => 'Tidak. Sewain memakai biaya langganan tetap, bukan potongan per transaksi. Seluruh hasil sewa 100% milik toko Anda.'],
                    ['q' => 'Bagaimana keamanan e-KTP dan kontrak digital?', 'a' => 'Foto e-KTP dicocokkan dengan swafoto penyewa secara otomatis. Kontrak digital diterbitkan sebagai PDF dengan cap waktu dan enkripsi, berstandar hukum Indonesia.'],
                    ['q' => 'Berapa lama proses pendaftaran?', 'a' => 'Kurang dari lima menit. Anda bisa mencoba 14 hari gratis tanpa kartu kredit, lalu berhenti kapan saja.'],
                    ['q' => 'Bisakah memakai domain sendiri?', 'a' => 'Bisa. Anda bebas memakai subdomain sewain.id atau menghubungkan nama domain milik Anda sendiri.'],
                ];
            @endphp

            @foreach ($faqs as $faq)
                <details class="group">
                    <summary class="flex items-center justify-between gap-4 py-4 cursor-pointer list-none font-semibold text-ink hover:text-stempel transition-colors">
                        {{ $faq['q'] }}
                        <span class="shrink-0 text-ink-faint group-open:rotate-45 transition-transform duration-200" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </span>
                    </summary>
                    <p class="pb-4 text-ink-soft leading-relaxed -mt-1 max-w-xl">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

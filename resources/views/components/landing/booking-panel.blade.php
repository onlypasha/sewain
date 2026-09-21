<div class="border-2 border-stempel rounded-md p-5 flex flex-col justify-between">
    <div>
        <div class="flex items-center justify-between border-b border-ink/10 pb-3">
            <div>
                <div class="font-data text-xs text-ink-faint">Simulasi pemesanan</div>
                <h5 id="sim-item-name" class="font-display font-bold text-lg mt-0.5">Sony Alpha 7 IV</h5>
            </div>
            <span class="text-xs text-ink-soft font-data">durasi bebas</span>
        </div>

        <div class="mt-4">
            <label for="sim-days-range" class="block text-sm text-ink-soft mb-2">Durasi sewa</label>
            <div class="flex items-center gap-3">
                <input type="range" id="sim-days-range" min="1" max="7" value="3" class="flex-1 accent-stempel" oninput="updateSimulatedBooking()">
                <span id="sim-days-label" class="font-data text-sm font-semibold bg-paper border border-ink/10 px-2 py-1 rounded">3 hari</span>
            </div>
        </div>

        <div class="mt-4 bg-paper border border-ink/10 rounded-md p-4 space-y-2.5 text-sm">
            <div class="flex justify-between text-ink-soft">
                <span>Biaya sewa</span>
                <span id="sim-rental-subtotal" class="font-data text-ink">Rp 1.050.000</span>
            </div>
            <div class="flex justify-between text-ink-soft">
                <span>Jaminan (kembali)</span>
                <span class="font-data text-ink">Rp 300.000</span>
            </div>
            <div class="flex justify-between text-ink-soft">
                <span>Proteksi alat</span>
                <span class="font-data text-ink">Rp 25.000</span>
            </div>
            <div class="border-t border-ink/10 pt-2.5 flex justify-between font-semibold">
                <span>Total</span>
                <span id="sim-total-price" class="font-data text-stempel">Rp 1.375.000</span>
            </div>
        </div>
    </div>

    <button onclick="triggerSimulatedCheckout()" class="mt-5 w-full bg-stempel text-paper font-semibold py-3 rounded-md hover:bg-stempel-deep transition-all duration-150 active:scale-[0.98]">
        Kirim pesanan ke toko
    </button>

    <div class="mt-3 text-[11px] text-ink-faint text-center font-data">Kontrak PDF &amp; verifikasi e-KTP dibuat otomatis</div>
</div>

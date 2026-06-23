<!-- SECTION 8: DISTRIBUSI & DO -->
<div id="section-dist-do" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Delivery Order (DO)</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Buat DO pengiriman, tunjuk driver, dan perbarui status logistik kiriman air.</p>
        </div>
        <button onclick="openDeliveryOrderModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat DO Baru
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. DO</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Driver</th>
                        <th class="py-3 px-4">Item Pengiriman</th>
                        <th class="py-3 px-4">Status Pengiriman</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="do-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 8.2: BUKTI KIRIM -->
<div id="section-dist-bukti" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Bukti Kirim Delivery</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Upload dokumentasi foto pengantaran depo/outlet dan tandatangan digital customer.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. DO</th>
                        <th class="py-3 px-4">Penerima</th>
                        <th class="py-3 px-4">Foto Dokumentasi</th>
                        <th class="py-3 px-4">Tanda Tangan Digital</th>
                        <th class="py-3 px-4">Tanggal Upload</th>
                        <th class="py-3 px-4 text-right">Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="bukti-kirim-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

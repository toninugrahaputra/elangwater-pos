<!-- SECTION 8: DISTRIBUSI & DO -->
<div id="section-dist-do" class="space-y-6 hidden" data-permission="sales.create">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Delivery Order (DO)</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Buat DO pengiriman, tunjuk driver, dan perbarui status logistik kiriman air.</p>
        </div>
        <button onclick="openDeliveryOrderModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="sales.create">
            <i data-lucide="plus" class="w-5 h-5"></i> Buat DO Baru
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-8 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-4 px-5">No. DO</th>
                        <th class="py-4 px-5">Customer</th>
                        <th class="py-4 px-5">Driver</th>
                        <th class="py-4 px-5">Item Pengiriman</th>
                        <th class="py-4 px-5">Status Pengiriman</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
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
<div id="section-dist-bukti" class="space-y-6 hidden" data-permission="sales.index">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Bukti Kirim Delivery</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Upload dokumentasi foto pengantaran depo/outlet dan tandatangan digital customer.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-8 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-4 px-5">No. DO</th>
                        <th class="py-4 px-5">Penerima</th>
                        <th class="py-4 px-5">Foto Dokumentasi</th>
                        <th class="py-4 px-5">Tanda Tangan Digital</th>
                        <th class="py-4 px-5">Tanggal Upload</th>
                        <th class="py-4 px-5 text-right">Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="bukti-kirim-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

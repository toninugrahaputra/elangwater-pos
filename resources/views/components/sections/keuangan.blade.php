<!-- SECTION 9: KEUANGAN - KAS MASUK KELUAR -->
<div id="section-keu-kas" class="space-y-6 hidden" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Kas & Jurnal Keuangan</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Log arus uang tunai dan bank (Pemasukan, Pengeluaran Operasional).</p>
        </div>
        <button onclick="openCashFlowModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="cash-transactions.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Catat Kas Masuk/Keluar
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. Jurnal</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Jenis</th>
                        <th class="py-3 px-4">Kategori Jurnal</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="keu-kas-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 9.2: KEUANGAN - PEMBAYARAN TAGIHAN -->
<div id="section-keu-tagihan" class="space-y-6 hidden" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Tagihan (Piutang)</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi dan pelunasan piutang outlet/distributor air.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. Invoice / Penjualan</th>
                        <th class="py-3 px-4">Nama Pelanggan</th>
                        <th class="py-3 px-4">Total Piutang</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status Tagihan</th>
                        <th class="py-3 px-4 text-right">Aksi Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="keu-tagihan-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 9.3: KEUANGAN - PEMBAYARAN HUTANG -->
<div id="section-keu-hutang" class="space-y-6 hidden" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Hutang ke Supplier</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi transfer pelunasan belanja stok bahan baku kepada supplier.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. PO Referensi</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Total Hutang</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status Hutang</th>
                        <th class="py-3 px-4 text-right">Aksi Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="keu-hutang-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
    
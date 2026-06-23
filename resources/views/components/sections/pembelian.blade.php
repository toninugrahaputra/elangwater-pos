<!-- SECTION 6: PEMBELIAN (Pre-Order / PO) -->
<div id="section-po-buat" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pre-Order Pembelian & Receive Barang</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola PO barang ke supplier, persetujuan admin, dan pencatatan penerimaan gudang.</p>
        </div>
        <button onclick="openPOModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i> Buat Pre-Order
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. PO</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Tanggal PO</th>
                        <th class="py-3 px-4">Item & Qty</th>
                        <th class="py-3 px-4">Total Biaya</th>
                        <th class="py-3 px-4">Status PO</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="po-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 6.2: RETUR PEMBELIAN -->
<div id="section-po-retur" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Retur Pembelian</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola pengembalian barang rusak (bocor, penyok) ke Supplier.</p>
        </div>
        <button onclick="openReturPembelianModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat Retur Pembelian
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. Retur</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Detail Barang</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="po-retur-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

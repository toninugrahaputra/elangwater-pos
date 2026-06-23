<!-- SECTION 3: INVENTORI - GUDANG -->
<div id="section-inv-gudang" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Multi Gudang / Cabang Depo</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Pantau dan kelola multi gudang fisik penyimpanan air minum Anda.</p>
        </div>
        <button onclick="addNewWarehouse()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Gudang Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="warehouse-grid">
        <!-- Loaded dynamically -->
    </div>
</div>

<!-- SECTION 3.2: STOK REAL TIME -->
<div id="section-inv-stok" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Informasi Stok Real-Time</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Status persediaan aktual di setiap gudang dengan Safety Stock & Reorder Point.</p>
        </div>
    </div>

    <div class="bg-white border border-cream-dark rounded-2xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">Nama Produk</th>
                        <th class="py-3 px-4">Gudang</th>
                        <th class="py-3 px-4">Stok Aktual</th>
                        <th class="py-3 px-4">Safety Stock</th>
                        <th class="py-3 px-4">Reorder Point</th>
                        <th class="py-3 px-4">Status Kekurangan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="realtime-stock-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 3.3: INVENTORI - BARANG MASUK -->
<div id="section-inv-masuk" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Barang Masuk</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Catatan barang masuk baik dari Pembelian Supplier maupun dari Transfer Antar Gudang.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. Referensi</th>
                        <th class="py-3 px-4">Tanggal Masuk</th>
                        <th class="py-3 px-4">Gudang Penerima</th>
                        <th class="py-3 px-4">Sumber</th>
                        <th class="py-3 px-4">Detail Item</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="incoming-stock-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 3.4: INVENTORI - BARANG KELUAR -->
<div id="section-inv-keluar" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Barang Keluar</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Catatan barang keluar karena transaksi Penjualan POS maupun Mutasi Gudang.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. Transaksi / DO</th>
                        <th class="py-3 px-4">Tanggal Keluar</th>
                        <th class="py-3 px-4">Gudang Asal</th>
                        <th class="py-3 px-4">Tujuan / Outlet</th>
                        <th class="py-3 px-4">Detail Item</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="outgoing-stock-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 3.5: INVENTORI - TRANSFER GUDANG -->
<div id="section-inv-transfer" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Transfer & Mutasi Antar Gudang</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kirim persediaan dari satu gudang ke gudang cabang/depo lainnya.</p>
        </div>
        <button onclick="openTransferModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Buat Transfer Baru
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. Mutasi</th>
                        <th class="py-3 px-4">Gudang Asal</th>
                        <th class="py-3 px-4">Gudang Tujuan</th>
                        <th class="py-3 px-4">Item & Qty</th>
                        <th class="py-3 px-4">Tanggal Permohonan</th>
                        <th class="py-3 px-4">Status Approval</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="transfer-stock-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 3.6: STOCK OPNAME -->
<div id="section-inv-opname" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Stock Opname</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Penyesuaian stok berkala antara stok fisik di gudang dengan catatan di sistem.</p>
        </div>
        <button onclick="openOpnameModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-4 h-4"></i> Buat Stock Opname
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">No. Opname</th>
                        <th class="py-3 px-4">Gudang</th>
                        <th class="py-3 px-4">Item</th>
                        <th class="py-3 px-4 text-center">Stok Buku</th>
                        <th class="py-3 px-4 text-center">Stok Fisik</th>
                        <th class="py-3 px-4 text-center">Selisih</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Status Approval</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="opname-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 3.7: KARTU STOK -->
<div id="section-inv-kartustok" class="space-y-6 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Kartu Stok & Riwayat Mutasi</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Log pergerakan keluar-masuk setiap SKU di gudang secara FIFO.</p>
        </div>
        <div class="flex gap-2">
            <select id="kartu-stok-sku-filter" onchange="filterKartuStok()" class="bg-white border border-cream-dark px-3 py-1.5 rounded-lg text-xs font-semibold">
                <!-- populated by JS -->
            </select>
            <select id="kartu-stok-gudang-filter" onchange="filterKartuStok()" class="bg-white border border-cream-dark px-3 py-1.5 rounded-lg text-xs font-semibold">
                <option value="">Semua Gudang</option>
                <option value="Gudang Utama">Gudang Utama</option>
                <option value="Depo Elang Utara">Depo Elang Utara</option>
            </select>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">Tanggal & Jam</th>
                        <th class="py-3 px-4">Gudang</th>
                        <th class="py-3 px-4">SKU / Nama Produk</th>
                        <th class="py-3 px-4">Keterangan Aktivitas</th>
                        <th class="py-3 px-4 text-center">Masuk (+)</th>
                        <th class="py-3 px-4 text-center">Keluar (-)</th>
                        <th class="py-3 px-4 text-right">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="kartu-stok-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

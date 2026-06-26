<!-- SECTION 10: LAPORAN ANALITIS -->
<div id="section-laporan" class="space-y-6 hidden" data-permission="reports.view">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Laporan Analitis & Performance</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Analisis tren data komprehensif, ekspor laporan penjualan, barang, & laba rugi.</p>
        </div>
    </div>

    <!-- Report Submodules tab-bar -->
    <div class="bg-white p-2 rounded-xl border border-cream-dark flex flex-wrap gap-1">
        <button onclick="switchLaporanSubTab('laporan-penjualan', 'penjualan-harian')" id="btn-rep-sales" class="laporan-subtab-btn flex-1 min-w-[120px] py-2 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm">Penjualan</button>
        <button onclick="switchLaporanSubTab('laporan-inventori', 'stok-tanggal')" id="btn-rep-inv" class="laporan-subtab-btn flex-1 min-w-[120px] py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream">Inventori / Stok</button>
        <button onclick="switchLaporanSubTab('laporan-pembelian', 'pembelian-supplier')" id="btn-rep-buy" class="laporan-subtab-btn flex-1 min-w-[120px] py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream">Pembelian Supplier</button>
        <button onclick="switchLaporanSubTab('laporan-pelanggan', 'top-customer')" id="btn-rep-cust" class="laporan-subtab-btn flex-1 min-w-[120px] py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream">Top Pelanggan</button>
        <button onclick="switchLaporanSubTab('laporan-keuangan', 'arus-kas')" id="btn-rep-fin" class="laporan-subtab-btn flex-1 min-w-[120px] py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream">Laba Rugi & Kas</button>
    </div>

    <!-- SUB-REPORT: PENJUALAN -->
    <div id="laporan-penjualan" class="space-y-4 laporan-sub-pane">
        <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-zinc-500">Jenis Laporan Penjualan:</label>
                <select id="sel-rep-sales" onchange="loadReport('penjualan', this.value)" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-64 font-bold focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                    <option value="penjualan-harian">Penjualan Harian</option>
                    <option value="penjualan-bulanan">Penjualan Bulanan</option>
                    <option value="penjualan-tahunan">Penjualan Tahunan</option>
                    <option value="penjualan-sku">Penjualan Per SKU</option>
                    <option value="penjualan-kategori">Penjualan Per Kategori</option>
                    <option value="penjualan-brand">Penjualan Per Brand</option>
                    <option value="penjualan-customer">Penjualan Per Customer</option>
                    <option value="produk-terlaris">Produk Terlaris</option>
                    <option value="produk-kurang-laku">Produk Kurang Laku</option>
                </select>
            </div>
            <button onclick="Swal.fire('Ekspor Berhasil', 'Laporan berhasil diekspor ke format Excel!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor Excel
            </button>
        </div>

        <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
            <div class="relative h-48 mb-4">
                <canvas id="reportSalesChart"></canvas>
            </div>
            <div class="overflow-x-auto" id="table-rep-sales-container">
                <!-- Filled dynamically -->
            </div>
        </div>
    </div>

    <!-- SUB-REPORT: INVENTORI -->
    <div id="laporan-inventori" class="hidden space-y-4 laporan-sub-pane">
        <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-zinc-500">Jenis Laporan Inventori:</label>
                <select id="sel-rep-inv" onchange="loadReport('inventori', this.value)" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-64 font-bold focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                    <option value="stok-tanggal">Qty Stok Berdasarkan Tanggal</option>
                    <option value="stok-masuk">Stok Masuk</option>
                    <option value="stok-keluar">Stok Keluar</option>
                    <option value="qty-produk-keluar">Qty Produk Keluar</option>
                    <option value="sisa-stok">Sisa Stok Produk</option>
                    <option value="sisa-stok-grup">Sisa Stok Grup Produk</option>
                    <option value="usia-stok">Usia Stok</option>
                    <option value="pergerakan-stok">Pergerakan Stok</option>
                    <option value="value-pergerakan">Value Pergerakan Stok</option>
                    <option value="peringatan-stok">Peringatan Sisa Stok</option>
                    <option value="fifo-compare">Perbandingan Stok & FIFO</option>
                    <option value="perubahan-harga">Perubahan Harga</option>
                </select>
            </div>
            <button onclick="Swal.fire('Ekspor Berhasil', 'Laporan berhasil diekspor ke format Excel!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor Excel
            </button>
        </div>

        <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
            <div class="overflow-x-auto" id="table-rep-inv-container">
                <!-- Filled dynamically -->
            </div>
        </div>
    </div>

    <!-- SUB-REPORT: PEMBELIAN -->
    <div id="laporan-pembelian" class="hidden space-y-4 laporan-sub-pane">
        <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-zinc-500">Jenis Laporan Pembelian:</label>
                <select id="sel-rep-buy" onchange="loadReport('pembelian', this.value)" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-64 font-bold focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                    <option value="pembelian-supplier">Pembelian Per Supplier</option>
                    <option value="pembelian-produk">Pembelian Per Produk</option>
                </select>
            </div>
            <button onclick="Swal.fire('Ekspor Berhasil', 'Laporan berhasil diekspor ke format Excel!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor Excel
            </button>
        </div>

        <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
            <div class="relative h-48 mb-4">
                <canvas id="reportPurchaseChart"></canvas>
            </div>
            <div class="overflow-x-auto" id="table-rep-buy-container">
                <!-- Filled dynamically -->
            </div>
        </div>
    </div>

    <!-- SUB-REPORT: PELANGGAN -->
    <div id="laporan-pelanggan" class="hidden space-y-4 laporan-sub-pane">
        <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-zinc-500">Jenis Laporan Pelanggan:</label>
                <select id="sel-rep-cust" onchange="loadReport('pelanggan', this.value)" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-64 font-bold focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                    <option value="top-customer">Top Customer</option>
                    <option value="customer-aktif">Customer Aktif</option>
                    <option value="customer-tidak-aktif">Customer Tidak Aktif</option>
                </select>
            </div>
            <button onclick="Swal.fire('Ekspor Berhasil', 'Laporan berhasil diekspor ke format Excel!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor Excel
            </button>
        </div>

        <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
            <div class="overflow-x-auto" id="table-rep-cust-container">
                <!-- Filled dynamically -->
            </div>
        </div>
    </div>

    <!-- SUB-REPORT: KEUANGAN -->
    <div id="laporan-keuangan" class="hidden space-y-4 laporan-sub-pane">
        <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-zinc-500">Jenis Laporan Keuangan:</label>
                <select id="sel-rep-fin" onchange="loadReport('keuangan', this.value)" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-64 font-bold focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                    <option value="arus-kas">Arus Kas</option>
                    <option value="pendapatan">Pendapatan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                    <option value="laba-rugi">Laba Rugi</option>
                </select>
            </div>
            <button onclick="Swal.fire('Ekspor Berhasil', 'Laporan berhasil diekspor ke format Excel!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor Excel
            </button>
        </div>

        <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
            <div class="overflow-x-auto" id="table-rep-fin-container">
                <!-- Filled dynamically -->
            </div>
        </div>
    </div>
</div>

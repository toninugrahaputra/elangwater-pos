@extends('layouts.app')

@section('content')
<!-- SECTION 10: LAPORAN ANALITIS -->
<div id="section-laporan" class="space-y-6" data-permission="reports.view">
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
@endsection

@push('scripts')
<script>
    // LAPORAN SUBTAB
    function switchLaporanSubTab(paneId, defaultReport) {
        document.querySelectorAll('.laporan-sub-pane').forEach(p => p.classList.add('hidden'));
        document.getElementById(paneId).classList.remove('hidden');

        document.querySelectorAll('.laporan-subtab-btn').forEach(btn => {
            btn.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream";
        });
        
        let targetBtn = event ? event.target : null;
        if (!targetBtn) {
            const btnMap = {
                'laporan-penjualan': 'btn-rep-sales',
                'laporan-inventori': 'btn-rep-inv',
                'laporan-pembelian': 'btn-rep-buy',
                'laporan-pelanggan': 'btn-rep-cust',
                'laporan-keuangan': 'btn-rep-fin'
            };
            targetBtn = document.getElementById(btnMap[paneId]);
        }
        
        if (targetBtn) {
            targetBtn.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm";
        }

        let category = paneId.replace('laporan-', '');
        let selectId = '';
        if (category === 'penjualan') selectId = 'sel-rep-sales';
        else if (category === 'inventori') selectId = 'sel-rep-inv';
        else if (category === 'pembelian') selectId = 'sel-rep-buy';
        else if (category === 'pelanggan') selectId = 'sel-rep-cust';
        else if (category === 'keuangan') selectId = 'sel-rep-fin';

        if (selectId) {
            let sel = document.getElementById(selectId);
            sel.value = defaultReport;
            loadReport(category, defaultReport);
        }
    }

    // DYNAMIC REPORT GENERATOR
    function loadReport(category, reportType) {
        let containerId = 'table-rep-' + (category === 'penjualan' ? 'sales' : (category === 'inventori' ? 'inv' : (category === 'pembelian' ? 'buy' : (category === 'pelanggan' ? 'cust' : 'fin')))) + '-container';
        let container = document.getElementById(containerId);
        if (!container) return;

        let html = '';

        if (category === 'penjualan') {
            if (reportType === 'penjualan-harian') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3 text-center">Jumlah Transaksi</th>
                                <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                <th class="py-2.5 px-3 text-right">Total Diskon</th>
                                <th class="py-2.5 px-3 text-right">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">23 Juni 2026</td><td class="py-2 px-3 text-center">42</td><td class="py-2 px-3 text-center">210 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 120.000</td><td class="py-2 px-3 text-right font-bold">Rp 12.450.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">22 Juni 2026</td><td class="py-2 px-3 text-center">38</td><td class="py-2 px-3 text-center">180 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 85.000</td><td class="py-2 px-3 text-right font-bold">Rp 9.850.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">21 Juni 2026</td><td class="py-2 px-3 text-center">50</td><td class="py-2 px-3 text-center">245 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 150.000</td><td class="py-2 px-3 text-right font-bold">Rp 14.200.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-bulanan') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Bulan</th>
                                <th class="py-2.5 px-3 text-center">Total Transaksi</th>
                                <th class="py-2.5 px-3">Paling Laku</th>
                                <th class="py-2.5 px-3 text-right">Rata-Rata Harian</th>
                                <th class="py-2.5 px-3 text-right">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">Juni 2026</td><td class="py-2.5 px-3 text-center">980</td><td class="py-2.5 px-3">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-right">Rp 2.500.000</td><td class="py-2.5 px-3 text-right font-bold">Rp 75.400.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">Mei 2026</td><td class="py-2.5 px-3 text-center">910</td><td class="py-2.5 px-3">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-right">Rp 2.190.000</td><td class="py-2.5 px-3 text-right font-bold">Rp 68.000.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-tahunan') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tahun</th>
                                <th class="py-2.5 px-3 text-center">Total Penjualan</th>
                                <th class="py-2.5 px-3 text-center">Pertumbuhan</th>
                                <th class="py-2.5 px-3 text-right">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">2026 (YTD)</td><td class="py-2.5 px-3 text-center">5.420 Transaksi</td><td class="py-2.5 px-3 text-center text-green-600 font-bold">+18%</td><td class="py-2.5 px-3 text-right font-bold">Rp 412.000.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">2025</td><td class="py-2.5 px-3 text-center">10.890 Transaksi</td><td class="py-2.5 px-3 text-center text-green-600 font-bold">+24%</td><td class="py-2.5 px-3 text-right font-bold">Rp 820.500.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-sku') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3">Kategori</th>
                                <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                <th class="py-2.5 px-3 text-right">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${products.map(p => `
                                <tr class="border-b border-cream/50">
                                    <td class="py-2 px-3 font-mono">${p.sku}</td>
                                    <td class="py-2 px-3 font-bold">${p.name}</td>
                                    <td class="py-2 px-3">${p.category}</td>
                                    <td class="py-2 px-3 text-center">1.280 Pcs</td>
                                    <td class="py-2 px-3 text-right font-bold">Rp ${(p.retailPrice * 1280).toLocaleString('id-ID')}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-kategori') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Kategori</th>
                                <th class="py-2.5 px-3 text-center">Jumlah SKU</th>
                                <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                <th class="py-2.5 px-3 text-right">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Galon</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">1.820 Galon</td><td class="py-2.5 px-3 text-right font-bold">Rp 27.300.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Botol</td><td class="py-2.5 px-3 text-center">2</td><td class="py-2.5 px-3 text-center">1.670 Box</td><td class="py-2.5 px-3 text-right font-bold">Rp 65.140.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Gelas</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">80 Box</td><td class="py-2.5 px-3 text-right font-bold">Rp 1.920.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-brand') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Brand</th>
                                <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                <th class="py-2.5 px-3 text-right">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Elangwater</td><td class="py-2.5 px-3 text-center">3.570 Unit</td><td class="py-2.5 px-3 text-right font-bold">Rp 94.360.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'penjualan-customer') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Nama Customer</th>
                                <th class="py-2.5 px-3">Kategori</th>
                                <th class="py-2.5 px-3 text-center">Total Transaksi</th>
                                <th class="py-2.5 px-3 text-right">Nilai Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${customers.map(c => `
                                <tr class="border-b border-cream/50">
                                    <td class="py-2.5 px-3 font-bold">${c.name}</td>
                                    <td class="py-2.5 px-3">${c.type}</td>
                                    <td class="py-2.5 px-3 text-center">${c.spend > 0 ? 12 : 0} kali</td>
                                    <td class="py-2.5 px-3 text-right font-bold">Rp ${c.spend.toLocaleString('id-ID')}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'produk-terlaris') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3 text-center">Rank</th>
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Total Qty Terjual</th>
                                <th class="py-2.5 px-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#1</td><td class="py-2.5 px-3 font-mono">ELG-GAL-19L</td><td class="py-2.5 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-center font-bold">1.820 Galon</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Fast Moving</span></td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#2</td><td class="py-2.5 px-3 font-mono">ELG-BOT-600M</td><td class="py-2.5 px-3 font-bold">Botol Elangwater 600ml</td><td class="py-2.5 px-3 text-center font-bold">1.250 Box</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Fast Moving</span></td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'produk-kurang-laku') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3 text-center">Rank</th>
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Stok Mengendap</th>
                                <th class="py-2.5 px-3 text-right">Terjual 30 Hari Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-red-500">#1</td><td class="py-2.5 px-3 font-mono">ELG-CUP-240M</td><td class="py-2.5 px-3 font-bold">Gelas Elangwater 240ml</td><td class="py-2.5 px-3 text-center font-semibold text-red-500">27 Box</td><td class="py-2.5 px-3 text-right font-bold text-zinc-500">80 Box</td></tr>
                        </tbody>
                    </table>
                `;
            }
        } else if (category === 'inventori') {
            if (reportType === 'stok-tanggal') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Stok Awal</th>
                                <th class="py-2.5 px-3 text-center">Stok Masuk</th>
                                <th class="py-2.5 px-3 text-center">Stok Keluar</th>
                                <th class="py-2.5 px-3 text-right">Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center">950</td><td class="py-2 px-3 text-center">0</td><td class="py-2 px-3 text-center">98</td><td class="py-2 px-3 text-right font-bold">852</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'stok-masuk') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Ref Penerimaan</th>
                                <th class="py-2.5 px-3">Supplier/Asal</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Qty Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-mono font-bold">IN-2026-0044</td><td class="py-2 px-3">PT Kemasan Plastik Indonesia</td><td class="py-2 px-3 font-bold">Botol Kosong 600ml</td><td class="py-2 px-3 text-center font-bold text-green-600">10.000 Pcs</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'stok-keluar') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Ref DO</th>
                                <th class="py-2.5 px-3">Tujuan</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Qty Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-mono font-bold">DO-2026-092</td><td class="py-2 px-3">Toko Makmur Sejahtera</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center font-bold text-red-500">150 Pcs</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'usia-stok') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3">Tanggal Masuk Pertama</th>
                                <th class="py-2.5 px-3 text-center">Usia Stok (Hari)</th>
                                <th class="py-2.5 px-3 text-right">Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3">15 Juni 2026</td><td class="py-2 px-3 text-center font-bold text-green-600">8 Hari</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-green-50 text-green-800 rounded font-semibold text-[10px]">Rotasi Normal</span></td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-CUP-240M</td><td class="py-2 px-3 font-bold">Gelas Elangwater 240ml</td><td class="py-2 px-3">10 Mei 2026</td><td class="py-2 px-3 text-center font-bold text-red-500">44 Hari</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded font-bold text-[10px]">Cuci Gudang / Diskon</span></td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'pergerakan-stok') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Waktu</th>
                                <th class="py-2.5 px-3">SKU / Produk</th>
                                <th class="py-2.5 px-3">Gudang</th>
                                <th class="py-2.5 px-3">Aktivitas</th>
                                <th class="py-2.5 px-3 text-center">Qty Selisih</th>
                                <th class="py-2.5 px-3 text-right">Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Jun 10:48</td><td class="py-2 px-3 font-bold">ELG-GAL-19L</td><td class="py-2 px-3">Gudang Utama</td><td class="py-2 px-3">Mutasi Transfer Gudang</td><td class="py-2 px-3 text-center text-red-500 font-bold">-100</td><td class="py-2 px-3 text-right font-bold">850</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'value-pergerakan') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Bulan</th>
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-right">Value Masuk (HPP)</th>
                                <th class="py-2.5 px-3 text-right">Value Keluar (HPP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">Juni 2026</td><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-right text-green-600 font-bold">Rp 12.000.000</td><td class="py-2 px-3 text-right text-red-500 font-bold">Rp 9.600.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'peringatan-stok') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-center">Stok Aktual</th>
                                <th class="py-2.5 px-3 text-center">Safety Stock</th>
                                <th class="py-2.5 px-3 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L (Depo Utara)</td><td class="py-2 px-3 text-center text-red-500 font-bold">2 Pcs</td><td class="py-2.5 px-3 text-center">10 Pcs</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-[9px] font-black uppercase">REORDER POINT</span></td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'fifo-compare') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Batch ID</th>
                                <th class="py-2.5 px-3">Tanggal Masuk</th>
                                <th class="py-2.5 px-3 text-right">Harga Beli Batch</th>
                                <th class="py-2.5 px-3 text-right">Sisa Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">BATCH-0881</td><td class="py-2 px-3">15 Juni 2026</td><td class="py-2 px-3 text-right">Rp 8.000</td><td class="py-2 px-3 text-right font-bold">850 Pcs</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'perubahan-harga') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3 text-right">Harga Lama</th>
                                <th class="py-2.5 px-3 text-right">Harga Baru</th>
                                <th class="py-2.5 px-3 text-right">Diubah Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">20 Juni 2026</td><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-right">Rp 14.500</td><td class="py-2 px-3 text-right text-green-700 font-bold">Rp 15.000</td><td class="py-2 px-3 text-right">admin.elang</td></tr>
                        </tbody>
                    </table>
                `;
            }
        } else if (category === 'pembelian') {
            if (reportType === 'pembelian-supplier') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Supplier</th>
                                <th class="py-2.5 px-3 text-center">Total PO Selesai</th>
                                <th class="py-2.5 px-3 text-center">Total Qty Bahan</th>
                                <th class="py-2.5 px-3 text-right">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">PT Kemasan Plastik Indonesia</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">10.000 Pcs</td><td class="py-2.5 px-3 text-right font-extrabold">Rp 15.000.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">CV Sumber Mata Air Pegunungan</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">10.000L</td><td class="py-2.5 px-3 text-right font-extrabold">Rp 4.000.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'pembelian-produk') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Nama Produk</th>
                                <th class="py-2.5 px-3">Supplier Utama</th>
                                <th class="py-2.5 px-3 text-center">Total Qty Dibeli</th>
                                <th class="py-2.5 px-3 text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-BOT-600M</td><td class="py-2 px-3 font-bold">Botol Elangwater 600ml</td><td class="py-2 px-3">PT Kemasan Plastik Indonesia</td><td class="py-2 px-3 text-center font-bold">10.000 Pcs</td><td class="py-2 px-3 text-right font-bold">Rp 15.000.000</td></tr>
                        </tbody>
                    </table>
                `;
            }
        } else if (category === 'pelanggan') {
            if (reportType === 'top-customer') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3 text-center">Rank</th>
                                <th class="py-2.5 px-3">Nama Customer</th>
                                <th class="py-2.5 px-3">Kategori</th>
                                <th class="py-2.5 px-3 text-center">Total Kunjungan/Order</th>
                                <th class="py-2.5 px-3 text-right">Akumulasi Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#1</td><td class="py-2.5 px-3 font-bold">Toko Makmur Sejahtera</td><td class="py-2.5 px-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded font-bold">Distributor</span></td><td class="py-2.5 px-3 text-center">45 kali</td><td class="py-2.5 px-3 text-right font-bold text-green-700">Rp 48.900.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#2</td><td class="py-2.5 px-3 font-bold">Budi Agen Air Lestari</td><td class="py-2.5 px-3"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded font-bold">Agen</span></td><td class="py-2.5 px-3 text-center">28 kali</td><td class="py-2.5 px-3 text-right font-bold text-green-700">Rp 15.200.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'customer-aktif') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Nama Customer</th>
                                <th class="py-2.5 px-3 font-mono">No. Telp</th>
                                <th class="py-2.5 px-3">Terakhir Belanja</th>
                                <th class="py-2.5 px-3 text-right font-bold">Status Keaktifan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Toko Makmur Sejahtera</td><td class="py-2.5 px-3 font-mono">081299887711</td><td class="py-2.5 px-3">23 Juni 2026</td><td class="py-2.5 px-3 text-right"><span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded font-bold">AKTIF</span></td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Budi Agen Air Lestari</td><td class="py-2.5 px-3 font-mono">085711223344</td><td class="py-2.5 px-3">22 Juni 2026</td><td class="py-2.5 px-3 text-right"><span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded font-bold">AKTIF</span></td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'customer-tidak-aktif') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Nama Customer</th>
                                <th class="py-2.5 px-3">Terakhir Transaksi</th>
                                <th class="py-2.5 px-3 text-center">Hari Tidak Aktif</th>
                                <th class="py-2.5 px-3 text-right">Rekomendasi Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Depo Air Tirta (Toko)</td><td class="py-2.5 px-3 text-zinc-500">12 Maret 2026</td><td class="py-2.5 px-3 text-center font-bold text-red-500">103 Hari</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded font-bold text-[9px]">Hubungi Driver/Sales</span></td></tr>
                        </tbody>
                    </table>
                `;
            }
        } else if (category === 'keuangan') {
            if (reportType === 'arus-kas') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Kategori Kas</th>
                                <th class="py-2.5 px-3">Keterangan</th>
                                <th class="py-2.5 px-3 text-right">Kas Masuk</th>
                                <th class="py-2.5 px-3 text-right">Kas Keluar</th>
                                <th class="py-2.5 px-3 text-right">Saldo Berjalan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-semibold">Penjualan POS</td><td class="py-2 px-3">Penjualan Tunai / Bank</td><td class="py-2 px-3 text-right text-green-600 font-bold">Rp 12.450.000</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right font-black">Rp 15.700.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-semibold">Operasional</td><td class="py-2 px-3">Beli Bensin Delivery</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">Rp 250.000</td><td class="py-2 px-3 text-right font-black">Rp 3.250.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'pendapatan') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Sumber Pendapatan</th>
                                <th class="py-2.5 px-3">Metode Pembayaran</th>
                                <th class="py-2.5 px-3 text-center">Jumlah Transaksi</th>
                                <th class="py-2.5 px-3 text-right">Total Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Penjualan Retail Kasir</td><td class="py-2 px-3">Cash / Tunai</td><td class="py-2 px-3 text-center">31</td><td class="py-2 px-3 text-right font-bold text-green-700">Rp 3.500.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Penjualan Agen & Toko</td><td class="py-2 px-3">Transfer / QRIS</td><td class="py-2 px-3 text-center">11</td><td class="py-2 px-3 text-right font-bold text-green-700">Rp 8.950.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'pengeluaran') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Kategori Pengeluaran</th>
                                <th class="py-2.5 px-3">Tanggal Jurnal</th>
                                <th class="py-2.5 px-3">Keterangan</th>
                                <th class="py-2.5 px-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Operasional Kendaraan</td><td class="py-2 px-3 text-zinc-500">23 Juni 2026</td><td class="py-2 px-3 text-zinc-600">Beli Bensin Delivery Truck</td><td class="py-2 px-3 text-right font-bold text-red-500">Rp 250.000</td></tr>
                        </tbody>
                    </table>
                `;
            } else if (reportType === 'laba-rugi') {
                html = `
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                <th class="py-2.5 px-3">Komponen Keuangan</th>
                                <th class="py-2.5 px-3 text-right">Pemasukan (Rp)</th>
                                <th class="py-2.5 px-3 text-right">Pengeluaran (Rp)</th>
                                <th class="py-2.5 px-3 text-right">Subtotal / Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Pendapatan Penjualan Kotor</td><td class="py-2 px-3 text-right text-green-600 font-bold">75.400.000</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right">-</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">(-) Harga Pokok Penjualan (HPP)</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">42.150.000</td><td class="py-2 px-3 text-right">-</td></tr>
                            <tr class="border-b border-cream/50 bg-cream-dark/30"><td class="py-2 px-3 font-black text-sm">LABA KOTOR</td><td class="py-2 px-3 text-right font-bold">-</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right font-black text-sm">33.250.000</td></tr>
                            <tr class="border-b border-cream/50"><td class="py-2 px-3">(-) Pengeluaran Operasional & Gaji</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">16.200.000</td><td class="py-2 px-3 text-right">-</td></tr>
                            <tr class="border-b border-cream/50 bg-green-50"><td class="py-2.5 px-3 font-extrabold text-sm text-green-800">LABA BERSIH (NET PROFIT)</td><td class="py-2 px-3 text-right font-bold">-</td><td class="py-2 px-3 text-right">-</td><td class="py-2.5 px-3 text-right font-black text-green-700 text-sm">Rp 17.050.000</td></tr>
                        </tbody>
                    </table>
                `;
            }
        }

        container.innerHTML = html;
        try {
            container.querySelectorAll('table').forEach(t => {
                if (!/min-w-\[/.test(t.className)) t.classList.add('min-w-[640px]');
            });
        } catch (e) {
            console.warn('loadReport: could not normalize table widths', e);
        }
        lucide.createIcons();
    }

    // CHARTS INITIALIZATION
    let reportSalesChartRef, reportPurchaseChartRef;

    function initCharts() {
        // Laporan Sales Tren
        const ctx2 = document.getElementById('reportSalesChart');
        if (ctx2) {
            reportSalesChartRef = new Chart(ctx2.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Omset Bulanan (Juta Rp)',
                        data: [48, 52, 60, 58, 68, 75],
                        backgroundColor: '#F8C24E',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Laporan Purchases
        const ctx3 = document.getElementById('reportPurchaseChart');
        if (ctx3) {
            reportPurchaseChartRef = new Chart(ctx3.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['PT Kemasan Plastik', 'CV Sumber Mata Air', 'Lain-Lain'],
                    datasets: [{
                        data: [12.5, 32.0, 4.5],
                        backgroundColor: ['#FCE1A2', '#F8C24E', '#E2AD3B']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }

    function pageInit() {
        initCharts();
        // Load default reports
        loadReport('penjualan', 'penjualan-harian');
        loadReport('inventori', 'stok-tanggal');
        loadReport('pembelian', 'pembelian-supplier');
        loadReport('pelanggan', 'top-customer');
        loadReport('keuangan', 'arus-kas');
    }
</script>
@endpush

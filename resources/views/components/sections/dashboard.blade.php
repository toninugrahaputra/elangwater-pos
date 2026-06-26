<!-- SECTION 1: DASHBOARD -->
<div id="section-dashboard" class="space-y-6" data-permission="reports.view">
    <!-- Header & Period -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Dashboard Ringkasan</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Pantau kinerja penjualan, stok, dan piutang saat ini.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-xs font-semibold text-zinc-500">Periode:</span>
            <select class="bg-white border border-cream-dark px-4 py-2 rounded-lg text-sm font-semibold focus:outline-none min-w-[200px]">
                <option>Hari Ini (23 Juni 2026)</option>
                <option>7 Hari Terakhir</option>
                <option>Bulan Ini (Juni 2026)</option>
            </select>
        </div>
    </div>

    <!-- Stats Summary Cards (Ringkasan Penjualan, Tagihan, Hutang) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Penjualan Hari Ini</span>
                <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold" id="dash-sales-summary">Rp 12.450.000</p>
            <p class="text-xs text-green-600 font-semibold mt-2 flex items-center gap-2">
                <i data-lucide="arrow-up-right" class="w-4 h-4"></i> +12% dibanding kemarin
            </p>
        </div>

        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Tagihan (Piutang)</span>
                <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold" id="dash-receivables">Rp 8.760.000</p>
            <p class="text-xs text-zinc-500 font-medium mt-2">Dari 14 outlet distributor / agen</p>
        </div>

        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Hutang Supplier</span>
                <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold" id="dash-debts">Rp 4.200.000</p>
            <p class="text-xs text-red-600 font-semibold mt-2">Jatuh tempo minggu ini: 2 transaksi</p>
        </div>

        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Safety Stock Alert</span>
                <div class="w-9 h-9 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-red-600" id="dash-min-stock-alert">3 SKU</p>
            <p class="text-xs text-zinc-500 font-medium mt-2">Perlu reorder point hari ini</p>
        </div>
    </div>

    <!-- Charts & Critical Stock Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Chart Penjualan Harian -->
        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow lg:col-span-2">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-5">
                <h3 class="font-bold text-lg">Tren Penjualan Pekan Ini</h3>
                <span class="text-xs bg-cream px-3 py-1.5 rounded text-zinc-600 font-semibold">Grafik Real-Time</span>
            </div>
            <div class="relative h-[340px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Ringkasan Produk Terlaris & Kurang Laku -->
        <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-lg mb-5">Kinerja Produk (Volume 30 Hari)</h3>

                <!-- Terlaris -->
                <div class="mb-5">
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-3">Produk Terlaris 🔥</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-green-50/50 p-3 rounded-xl border border-green-100">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-green-100 text-green-700 text-xs font-bold rounded-lg flex items-center justify-center">1</span>
                                <div>
                                    <p class="text-xs font-bold">Galon Elangwater 19L</p>
                                    <p class="text-[10px] text-zinc-500">Kategori: Galon</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-700">1.820 Pcs</span>
                        </div>
                        <div class="flex items-center justify-between bg-green-50/30 p-3 rounded-xl border border-green-100/50">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-green-100/80 text-green-700 text-xs font-bold rounded-lg flex items-center justify-center">2</span>
                                <div>
                                    <p class="text-xs font-bold">Botol Elangwater 600ml</p>
                                    <p class="text-[10px] text-zinc-500">Kategori: Botol</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-700">1.250 Box</span>
                        </div>
                    </div>
                </div>

                <!-- Kurang Laku -->
                <div>
                    <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-3">Kurang Laku ⚠️</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-orange-50/50 p-3 rounded-xl border border-orange-100">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg flex items-center justify-center">1</span>
                                <div>
                                    <p class="text-xs font-bold">Gelas Elangwater 240ml</p>
                                    <p class="text-[10px] text-zinc-500">Kategori: Cup/Gelas</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-orange-700">80 Box</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Minimum Table Alert -->
    <div class="bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-lg flex items-center gap-3">
                <i data-lucide="shield-alert" class="w-5 h-5 text-red-500"></i>
                Peringatan Stok Minimum & Safety Stock
            </h3>
            <button onclick="switchTab('inv-stok')" class="text-sm text-primary-dark font-bold hover:underline" data-permission="product-stocks.index" data-role="admin_toko,superadmin">
                Kelola Semua Stok →
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left border-collapse">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-4 px-5">SKU / Nama Produk</th>
                        <th class="py-4 px-5">Gudang</th>
                        <th class="py-4 px-5">Stok Saat Ini</th>
                        <th class="py-4 px-5">Safety Stock</th>
                        <th class="py-4 px-5">Reorder Point</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="dash-min-stock-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

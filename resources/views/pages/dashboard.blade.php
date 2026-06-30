@extends('layouts.app')

@section('content')
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
            <a href="{{ route('inventori.stok') }}" class="text-sm text-primary-dark font-bold hover:underline" data-permission="product-stocks.index" data-role="admin_toko,superadmin">
                Kelola Semua Stok →
            </a>
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
@endsection

@push('scripts')
<script>
    // DASHBOARD SCRIPTS
    function renderDashboard() {
        let tableBody = document.getElementById('dash-min-stock-table-body');
        if (!tableBody) return;
        tableBody.innerHTML = '';

        let lowStockItems = [];
        products.forEach(p => {
            Object.keys(p.stock).forEach(gudang => {
                let qty = p.stock[gudang];
                // simulate safety stock limit
                let safetyLimit = p.category === 'Galon' ? 10 : 30;
                let reorderPoint = safetyLimit * 1.5;

                if (qty <= reorderPoint) {
                    lowStockItems.push({
                        name: p.name,
                        sku: p.sku,
                        gudang: gudang,
                        qty: qty,
                        safety: safetyLimit,
                        rop: reorderPoint,
                        status: qty <= safetyLimit ? 'KRITIS' : 'Reorder Point'
                    });
                }
            });
        });

        lowStockItems.forEach(item => {
            let badgeClass = item.status === 'KRITIS' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-800';
            tableBody.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-bold">${item.name}<p class="text-[10px] text-zinc-400 font-medium">${item.sku}</p></td>
                    <td class="py-3 px-4 text-zinc-500">${item.gudang}</td>
                    <td class="py-3 px-4 font-extrabold text-sm">${item.qty} Pcs</td>
                    <td class="py-3 px-4 text-zinc-500">${item.safety} Pcs</td>
                    <td class="py-3 px-4 text-zinc-500">${item.rop} Pcs</td>
                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold ${badgeClass}">${item.status}</span></td>
                    <td class="py-3 px-4 text-right">
                        <button onclick="orderStockSim('${item.name}')" class="bg-primary hover:bg-primary-dark font-bold text-[10px] px-2 py-1 rounded">Reorder</button>
                    </td>
                </tr>
            `;
        });
    }

    function orderStockSim(name) {
        Swal.fire({
            title: 'Buat PO Otomatis?',
            text: `Ingin membuat Pre-Order otomatis untuk ${name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Buat PO',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Berhasil', 'Pre-Order berhasil dibuat dan masuk di modul Pembelian!', 'success');
            }
        });
    }

    // CHARTS INITIALIZATION
    let salesChartRef;

    function initCharts() {
        const ctx1 = document.getElementById('salesChart');
        if (!ctx1) return;
        
        salesChartRef = new Chart(ctx1.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Penjualan (Juta Rp)',
                    data: [8.5, 9.2, 7.8, 11.2, 12.4, 15.0, 10.5],
                    borderColor: '#E2AD3B',
                    backgroundColor: 'rgba(248, 194, 78, 0.2)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    function pageInit() {
        renderDashboard();
        initCharts();
    }
</script>
@endpush

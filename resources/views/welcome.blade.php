<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elangwater POS & ERP</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- CSS & JS Assets (Tailwind v4 via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome & Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- ChartJS for Laporan & Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 for Interactive UI Popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #FCFAF6;
        }
        ::-webkit-scrollbar-thumb {
            background: #E2AD3B;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #F8C24E;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        main,
        section,
        div {
            min-width: 0;
        }

        table {
            border-collapse: collapse;
        }

        canvas {
            max-width: 100%;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="min-h-screen bg-cream text-zinc-800 flex flex-col">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-cream-dark h-auto min-h-[64px] px-4 sm:px-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between shrink-0 z-20 py-3">
        <div class="flex items-center gap-3 flex-wrap">
            <button onclick="toggleMobileSidebar()" class="md:hidden p-2 rounded-lg bg-cream hover:bg-cream-dark text-zinc-700 transition-colors">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center font-bold text-zinc-900 shadow-md">
                <i data-lucide="droplet" class="w-6 h-6 text-zinc-900 fill-zinc-900/20"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight tracking-tight">Elangwater POS & ERP</h1>
                <span class="text-xs text-zinc-500 font-medium">Sistem Informasi Penjualan & Distribusi Air</span>
            </div>
        </div>

        <!-- Global Quick Info & Profile -->
        <div class="flex flex-wrap items-center gap-3 justify-end">
            <!-- Active Notification Bell -->
            <div class="relative cursor-pointer" onclick="showNotificationCenter()">
                <div class="p-2 rounded-lg hover:bg-cream-dark transition-colors">
                    <i data-lucide="bell" class="w-5 h-5 text-zinc-600"></i>
                    <span id="notif-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-[10px] text-white flex items-center justify-center rounded-full font-bold">5</span>
                </div>
            </div>

            <!-- Role Selector (Simulation) -->
            <div class="flex items-center gap-2 bg-cream-dark/50 px-3 py-1.5 rounded-lg border border-cream-dark">
                <i data-lucide="shield-check" class="w-4 h-4 text-primary-dark"></i>
                <select id="role-selector" class="bg-transparent text-xs font-semibold focus:outline-none cursor-pointer" onchange="changeRoleSim(this.value)">
                    <option value="admin">Super Admin</option>
                    <option value="kasir">Kasir / POS</option>
                    <option value="gudang">Staf Gudang</option>
                    <option value="distributor">Driver / Distribusi</option>
                </select>
            </div>

            <!-- User Info -->
            <div class="flex items-center gap-3 border-l border-cream-dark pl-4">
                <div class="text-right hidden md:block">
                    <p id="user-display-name" class="text-sm font-semibold">Rakryan Alangwater</p>
                    <p id="user-display-role" class="text-[11px] text-zinc-500 font-medium">Administrator</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-primary-light flex items-center justify-center font-bold text-primary-dark text-sm border border-primary">
                    RA
                </div>
            </div>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <div class="flex flex-1 min-h-0 relative">
        <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-10 md:hidden" onclick="closeMobileSidebar()"></div>

        <!-- Sidebar Navigation -->
        <aside id="main-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-cream-dark flex flex-col justify-between overflow-y-auto transform -translate-x-full transition-transform duration-300 md:static md:translate-x-0 md:w-64 shrink-0">
            <!-- Navigation Items -->
            <nav class="p-4 space-y-1.5" id="main-navigation">
                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 mb-2">Utama</p>
                
                <!-- Dashboard -->
                <button onclick="switchTab('dashboard')" id="nav-dashboard" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream active:scale-95 bg-primary text-zinc-900 shadow-sm border border-primary/20">
                    <span class="flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard</span>
                    </span>
                </button>

                <!-- POS -->
                <button onclick="switchTab('pos')" id="nav-pos" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream active:scale-95 text-zinc-700 hover:text-zinc-900">
                    <span class="flex items-center gap-3">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-primary-dark"></i>
                        <span class="font-bold">POS / Kasir</span>
                    </span>
                    <span class="px-1.5 py-0.5 text-[10px] bg-red-100 text-red-600 rounded font-bold uppercase">Live</span>
                </button>

                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 pt-4 mb-2">Manajemen Data</p>

                <!-- Master Data Menu -->
                <div>
                    <button onclick="toggleSubmenu('submenu-master')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                        <span class="flex items-center gap-3">
                            <i data-lucide="database" class="w-4 h-4"></i>
                            <span>Master Data</span>
                        </span>
                        <i data-lucide="chevron-down" id="arrow-master" class="w-4 h-4 transition-transform duration-200"></i>
                    </button>
                    <div id="submenu-master" class="hidden pl-8 pr-2 py-1 space-y-1">
                        <a href="#" onclick="switchTab('master-produk')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Produk (SKU/Barcode)</a>
                        <a href="#" onclick="switchTab('master-harga')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Skema Harga</a>
                        <a href="#" onclick="switchTab('master-kategori')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Kategori</a>
                        <a href="#" onclick="switchTab('master-brand')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Brand</a>
                        <a href="#" onclick="switchTab('master-satuan')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Satuan</a>
                    </div>
                </div>

                <!-- Inventori Menu -->
                <div>
                    <button onclick="toggleSubmenu('submenu-inventori')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                        <span class="flex items-center gap-3">
                            <i data-lucide="package" class="w-4 h-4"></i>
                            <span>Inventori / Stok</span>
                        </span>
                        <i data-lucide="chevron-down" id="arrow-inventori" class="w-4 h-4 transition-transform duration-200"></i>
                    </button>
                    <div id="submenu-inventori" class="hidden pl-8 pr-2 py-1 space-y-1">
                        <a href="#" onclick="switchTab('inv-gudang')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Multi Gudang</a>
                        <a href="#" onclick="switchTab('inv-stok')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Stok Real Time</a>
                        <a href="#" onclick="switchTab('inv-masuk')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Barang Masuk</a>
                        <a href="#" onclick="switchTab('inv-keluar')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Barang Keluar</a>
                        <a href="#" onclick="switchTab('inv-transfer')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Transfer Gudang</a>
                        <a href="#" onclick="switchTab('inv-opname')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Stock Opname</a>
                        <a href="#" onclick="switchTab('inv-kartustok')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Kartu Stok</a>
                    </div>
                </div>

                <!-- Pelanggan Menu -->
                <button onclick="switchTab('pelanggan')" id="nav-pelanggan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                    <span class="flex items-center gap-3">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Pelanggan</span>
                    </span>
                </button>

                <!-- Supplier Menu -->
                <button onclick="switchTab('supplier')" id="nav-supplier" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                    <span class="flex items-center gap-3">
                        <i data-lucide="truck" class="w-4 h-4"></i>
                        <span>Supplier</span>
                    </span>
                </button>

                <!-- Pembelian Menu -->
                <div>
                    <button onclick="toggleSubmenu('submenu-pembelian')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                        <span class="flex items-center gap-3">
                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                            <span>Pembelian (PO)</span>
                        </span>
                        <i data-lucide="chevron-down" id="arrow-pembelian" class="w-4 h-4 transition-transform duration-200"></i>
                    </button>
                    <div id="submenu-pembelian" class="hidden pl-8 pr-2 py-1 space-y-1">
                        <a href="#" onclick="switchTab('po-buat')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Pre-Order & Receive</a>
                        <a href="#" onclick="switchTab('po-retur')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Retur Pembelian</a>
                    </div>
                </div>

                <!-- Distribusi Menu -->
                <div>
                    <button onclick="toggleSubmenu('submenu-distribusi')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                        <span class="flex items-center gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>Distribusi & DO</span>
                        </span>
                        <i data-lucide="chevron-down" id="arrow-distribusi" class="w-4 h-4 transition-transform duration-200"></i>
                    </button>
                    <div id="submenu-distribusi" class="hidden pl-8 pr-2 py-1 space-y-1">
                        <a href="#" onclick="switchTab('dist-do')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Delivery Order</a>
                        <a href="#" onclick="switchTab('dist-bukti')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Bukti Kirim</a>
                    </div>
                </div>

                <!-- Keuangan Menu -->
                <div>
                    <button onclick="toggleSubmenu('submenu-keuangan')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                        <span class="flex items-center gap-3">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                            <span>Keuangan / Kas</span>
                        </span>
                        <i data-lucide="chevron-down" id="arrow-keuangan" class="w-4 h-4 transition-transform duration-200"></i>
                    </button>
                    <div id="submenu-keuangan" class="hidden pl-8 pr-2 py-1 space-y-1">
                        <a href="#" onclick="switchTab('keu-kas')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Kas Masuk & Keluar</a>
                        <a href="#" onclick="switchTab('keu-tagihan')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Pembayaran Tagihan</a>
                        <a href="#" onclick="switchTab('keu-hutang')" class="block py-1.5 text-xs font-medium text-zinc-600 hover:text-zinc-900">Pembayaran Hutang</a>
                    </div>
                </div>

                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 pt-4 mb-2">Analisa & Konfigurasi</p>

                <!-- Laporan -->
                <button onclick="switchTab('laporan')" id="nav-laporan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                    <span class="flex items-center gap-3">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                        <span>Laporan Analitis</span>
                    </span>
                </button>

                <!-- Sistem -->
                <button onclick="switchTab('sistem')" id="nav-sistem" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream text-zinc-700 hover:text-zinc-900">
                    <span class="flex items-center gap-3">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        <span>Pengaturan Sistem</span>
                    </span>
                </button>
            </nav>

            <!-- Bottom Brand Info -->
            <div class="p-4 border-t border-cream-dark bg-cream/30 text-center">
                <p class="text-xs font-semibold text-zinc-600">Elangwater POS v1.0</p>
                <p class="text-[10px] text-zinc-400 mt-0.5">© 2026 PT Elang Air Persada</p>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <main class="flex-1 min-w-0 bg-cream p-4 md:p-6 overflow-y-auto" id="workspace-content">
            <!-- content will be dynamically updated by Javascript. Let's provide all static template containers in HTML and switch their visibility. -->
            
            <!-- SECTION 1: DASHBOARD -->
            <div id="section-dashboard" class="space-y-6">
                <!-- Header & Period -->
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Dashboard Ringkasan</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Pantau kinerja penjualan, stok, dan piutang saat ini.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold text-zinc-500">Periode:</span>
                        <select class="bg-white border border-cream-dark px-3 py-1.5 rounded-lg text-xs font-semibold focus:outline-none min-w-[180px]">
                            <option>Hari Ini (23 Juni 2026)</option>
                            <option>7 Hari Terakhir</option>
                            <option>Bulan Ini (Juni 2026)</option>
                        </select>
                    </div>
                </div>

                <!-- Stats Summary Cards (Ringkasan Penjualan, Tagihan, Hutang) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Penjualan Hari Ini</span>
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                                <i data-lucide="trending-up" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold" id="dash-sales-summary">Rp 12.450.000</p>
                        <p class="text-xs text-green-600 font-semibold mt-1 flex items-center gap-1">
                            <i data-lucide="arrow-up-right" class="w-3 h-3"></i> +12% dibanding kemarin
                        </p>
                    </div>

                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Tagihan (Piutang)</span>
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                                <i data-lucide="receipt" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold" id="dash-receivables">Rp 8.760.000</p>
                        <p class="text-xs text-zinc-500 font-medium mt-1">Dari 14 outlet distributor / agen</p>
                    </div>

                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Hutang Supplier</span>
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold" id="dash-debts">Rp 4.200.000</p>
                        <p class="text-xs text-red-600 font-semibold mt-1">Jatuh tempo minggu ini: 2 transaksi</p>
                    </div>

                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Safety Stock Alert</span>
                            <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600">
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold text-red-600" id="dash-min-stock-alert">3 SKU</p>
                        <p class="text-xs text-zinc-500 font-medium mt-1">Perlu reorder point hari ini</p>
                    </div>
                </div>

                <!-- Charts & Critical Stock Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Chart Penjualan Harian -->
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm lg:col-span-2">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-4">
                            <h3 class="font-bold text-base">Tren Penjualan Pekan Ini</h3>
                            <span class="text-xs bg-cream px-2 py-1 rounded text-zinc-600 font-semibold">Grafik Real-Time</span>
                        </div>
                        <div class="relative h-[320px]">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Ringkasan Produk Terlaris & Kurang Laku -->
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-base mb-4">Kinerja Produk (Volume 30 Hari)</h3>
                            
                            <!-- Terlaris -->
                            <div class="mb-4">
                                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Produk Terlaris 🔥</p>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between bg-green-50/50 p-2.5 rounded-xl border border-green-100">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 bg-green-100 text-green-700 text-xs font-bold rounded-lg flex items-center justify-center">1</span>
                                            <div>
                                                <p class="text-xs font-bold">Galon Elangwater 19L</p>
                                                <p class="text-[10px] text-zinc-500">Kategori: Galon</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-green-700">1.820 Pcs</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-green-50/30 p-2.5 rounded-xl border border-green-100/50">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 bg-green-100/80 text-green-700 text-xs font-bold rounded-lg flex items-center justify-center">2</span>
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
                                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Kurang Laku ⚠️</p>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between bg-orange-50/50 p-2.5 rounded-xl border border-orange-100">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg flex items-center justify-center">1</span>
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
                <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-base flex items-center gap-2">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-red-500"></i>
                            Peringatan Stok Minimum & Safety Stock
                        </h3>
                        <button onclick="switchTab('inv-stok')" class="text-xs text-primary-dark font-bold hover:underline">Kelola Semua Stok →</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                    <th class="py-3 px-4">SKU / Nama Produk</th>
                                    <th class="py-3 px-4">Gudang</th>
                                    <th class="py-3 px-4">Stok Saat Ini</th>
                                    <th class="py-3 px-4">Safety Stock</th>
                                    <th class="py-3 px-4">Reorder Point</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs divide-y divide-cream-dark" id="dash-min-stock-table-body">
                                <!-- filled dynamically -->
                            </tbody>
                        </table>
                            </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: MASTER DATA - PRODUK -->
            <div id="section-master-produk" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Data Produk & SKU</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Kelola barang dagangan, barcode, satuan, dan skema harga dasar.</p>
                    </div>
                    <button onclick="openAddProductModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2 shadow-sm transition-all hover:scale-105 active:scale-95">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Produk Baru
                    </button>
                </div>

                <!-- Filters -->
                <div class="bg-white p-4 rounded-xl border border-cream-dark flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative w-72">
                            <i data-lucide="search" class="w-4 h-4 text-zinc-400 absolute left-3 top-3"></i>
                            <input type="text" id="prod-search-input" onkeyup="filterProducts()" placeholder="Cari SKU, Barcode, atau nama produk..." class="bg-cream border border-cream-dark text-xs rounded-xl pl-9 pr-4 py-2.5 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        <select id="prod-filter-category" onchange="filterProducts()" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                            <option value="">Semua Kategori</option>
                            <option value="Galon">Galon</option>
                            <option value="Botol">Botol</option>
                            <option value="Gelas">Gelas / Cup</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-zinc-500">
                        Total Produk: <span class="text-zinc-900 font-bold" id="master-prod-total-count">0</span>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="bg-white border border-cream-dark rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                    <th class="py-4 px-6">Info Produk</th>
                                    <th class="py-4 px-6">SKU / Barcode</th>
                                    <th class="py-4 px-6">Kategori / Brand</th>
                                    <th class="py-4 px-6">Volume & Satuan</th>
                                    <th class="py-4 px-6">Harga Modal</th>
                                    <th class="py-4 px-6">Harga Jual Retail / Grosir</th>
                                    <th class="py-4 px-6">Status</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs divide-y divide-cream-dark" id="master-produk-table-body">
                                <!-- Loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION 2.2: MASTER HARGA (Skema Harga) -->
            <div id="section-master-harga" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Skema Level Harga</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Atur skema penentuan harga bertingkat untuk Retail, Agen, dan Distributor.</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-cream-dark space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Retail Pricing Rule -->
                        <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2.5 py-1 rounded">Level 1: Retail</span>
                                <i data-lucide="user" class="w-5 h-5 text-green-700"></i>
                            </div>
                            <h3 class="font-bold text-sm">Pelanggan Umum & Eceran</h3>
                            <p class="text-xs text-zinc-500">Harga standar penjualan kasir tanpa minimal pembelian. Margin rata-rata 25% - 30%.</p>
                            <div class="pt-2">
                                <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                                <input type="number" value="30" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                            </div>
                        </div>

                        <!-- Agen Pricing Rule -->
                        <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold bg-blue-100 text-blue-800 px-2.5 py-1 rounded">Level 2: Agen</span>
                                <i data-lucide="store" class="w-5 h-5 text-blue-700"></i>
                            </div>
                            <h3 class="font-bold text-sm">Agen Resmi & Toko Kecil</h3>
                            <p class="text-xs text-zinc-500">Diberikan pada agen yang terdaftar dengan minimal repeat order bulanan. Margin rata-rata 15% - 20%.</p>
                            <div class="pt-2">
                                <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                                <input type="number" value="20" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                            </div>
                        </div>

                        <!-- Distributor Pricing Rule -->
                        <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold bg-purple-100 text-purple-800 px-2.5 py-1 rounded">Level 3: Distributor</span>
                                <i data-lucide="truck" class="w-5 h-5 text-purple-700"></i>
                            </div>
                            <h3 class="font-bold text-sm">Grosir & Distributor Wilayah</h3>
                            <p class="text-xs text-zinc-500">Harga terendah khusus pengiriman partai besar / kontainer ke depo. Margin rata-rata 5% - 10%.</p>
                            <div class="pt-2">
                                <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                                <input type="number" value="8" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-cream-dark">
                        <button onclick="Swal.fire('Berhasil', 'Konfigurasi Level Skema Harga Berhasil Diperbarui!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-6 py-2.5 rounded-xl text-xs transition-colors">
                            Simpan Perubahan Skema
                        </button>
                    </div>
                </div>
            </div>

            <!-- SECTION 2.3: MASTER KATEGORI, BRAND, SATUAN -->
            <div id="section-master-kategori" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Kategori Produk</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Klasifikasikan produk Anda untuk memudahkan pencarian dan filter kasir.</p>
                    </div>
                    <button onclick="addNewCategory()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                <th class="py-3 px-4">Nama Kategori</th>
                                <th class="py-3 px-4">Jumlah SKU Aktif</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-cream-dark" id="category-table-body">
                            <!-- filled dynamically -->
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>

            <!-- SECTION 2.4: MASTER BRAND -->
            <div id="section-master-brand" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Brand / Merek</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Kelola brand produk air yang didistribusikan.</p>
                    </div>
                    <button onclick="addNewBrand()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Brand
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                <th class="py-3 px-4">Nama Brand</th>
                                <th class="py-3 px-4">Perusahaan Produsen</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-cream-dark" id="brand-table-body">
                            <!-- filled dynamically -->
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>

            <!-- SECTION 2.5: MASTER SATUAN -->
            <div id="section-master-satuan" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Satuan Ukuran</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Kelola satuan kemasan/volume (Pcs, Box, Galon, Kardus, Liter, ml).</p>
                    </div>
                    <button onclick="addNewUnit()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Satuan
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                <th class="py-3 px-4">Nama Satuan</th>
                                <th class="py-3 px-4">Singkatan</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-cream-dark" id="unit-table-body">
                            <!-- filled dynamically -->
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>

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
                                <th class="py-3 px-4 text-center">Masuk (+)</th >
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

            <!-- SECTION 4: PELANGGAN -->
            <div id="section-pelanggan" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Pelanggan</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Kelola data pelanggan Retail, Agen, Distributor, Toko, dan Kantor.</p>
                    </div>
                    <button onclick="openAddCustomerModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pelanggan
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                <th class="py-3 px-4">Nama Pelanggan</th>
                                <th class="py-3 px-4">Kategori Pelanggan</th>
                                <th class="py-3 px-4">No. Telp</th>
                                <th class="py-3 px-4">Alamat / Wilayah</th>
                                <th class="py-3 px-4">Total Belanja</th>
                                <th class="py-3 px-4">Tagihan Berjalan</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-cream-dark" id="customer-table-body">
                            <!-- filled dynamically -->
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>

            <!-- SECTION 5: SUPPLIER -->
            <div id="section-supplier" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Supplier / Vendor</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Daftar pabrik kemasan, distributor galon kosong, atau vendor operasional.</p>
                    </div>
                    <button onclick="openAddSupplierModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Supplier
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                                <th class="py-3 px-4">Nama Supplier</th>
                                <th class="py-3 px-4">Narahubung</th>
                                <th class="py-3 px-4">No. Telp</th>
                                <th class="py-3 px-4">Alamat</th>
                                <th class="py-3 px-4">Total Transaksi</th>
                                <th class="py-3 px-4">Hutang Outstanding</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-cream-dark" id="supplier-table-body">
                            <!-- filled dynamically -->
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>

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

            <!-- SECTION 7: POS / KASIR LIVE VIEW -->
            <div id="section-pos" class="h-full flex flex-col gap-6 min-h-0 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between shrink-0">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">POS Kasir Kas-Air</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Transaksi cepat, cari produk, hold bill, dan cetak struk penjualan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Hold & Resume Bill Button -->
                        <button onclick="openHoldBillsModal()" class="bg-white border border-cream-dark text-zinc-700 font-bold px-3 py-2 rounded-xl text-xs flex items-center gap-2 hover:bg-cream-dark">
                            <i data-lucide="archive" class="w-4 h-4"></i>
                            Hold Bills (<span id="hold-bills-count">0</span>)
                        </button>
                    </div>
                </div>

                <!-- Main POS Workstation Grid -->
                <div class="flex-1 min-h-0 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Products Catalog (2 Columns width on lg) -->
                    <div class="lg:col-span-2 flex flex-col gap-4 bg-white border border-cream-dark p-4 rounded-2xl min-h-0">
                        <!-- Catalog controls -->
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between shrink-0">
                            <!-- Search -->
                            <div class="relative flex-1 min-w-0">
                                <i data-lucide="search" class="w-4 h-4 text-zinc-400 absolute left-3 top-3"></i>
                                <input type="text" id="pos-search-input" onkeyup="filterPOSCatalog()" placeholder="Ketik nama produk atau scan barcode..." class="bg-cream border border-cream-dark text-xs rounded-xl pl-9 pr-4 py-2.5 w-full min-w-0 focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            <!-- Barcode scan simulation button -->
                            <button onclick="simulateBarcodeScan()" class="bg-primary-light text-primary-dark border border-primary font-semibold px-3 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1 hover:bg-primary transition-colors whitespace-nowrap">
                                <i data-lucide="qr-code" class="w-4 h-4"></i> Scan
                            </button>
                        </div>

                        <!-- Category Filter Bubbles -->
                        <div class="flex gap-2 overflow-x-auto shrink-0 pb-2 border-b border-cream-dark" id="pos-category-filters">
                            <button onclick="filterPOSCategory(event, '')" class="pos-cat-btn px-4 py-1.5 bg-zinc-950 text-white rounded-full text-xs font-bold transition-all">Semua</button>
                            <button onclick="filterPOSCategory(event, 'Galon')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Galon</button>
                            <button onclick="filterPOSCategory(event, 'Botol')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Botol</button>
                            <button onclick="filterPOSCategory(event, 'Gelas')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Gelas</button>
                        </div>

                        <!-- Catalog Grid -->
                        <div class="flex-1 overflow-y-auto min-h-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 p-1" id="pos-catalog-grid">
                            <!-- dynamically populated with premium product cards -->
                        </div>
                    </div>

                    <!-- Right: Active Cart & Billing Checkout (1 Column) -->
                    <div class="bg-white border border-cream-dark rounded-2xl flex flex-col justify-between overflow-hidden shadow-sm">
                        <!-- Cart Header & Customer Selector -->
                        <div class="p-4 border-b border-cream-dark shrink-0 space-y-3">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <span class="font-bold text-sm flex items-center gap-1.5">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 text-primary-dark"></i> Detail Belanja
                                </span>
                                <button onclick="clearPOSCart()" class="text-xs text-red-500 hover:underline">Hapus Semua</button>
                            </div>
                            
                            <!-- Customer Selection -->
                            <div>
                                <label class="text-[10px] font-bold text-zinc-400 block mb-1">Customer / Level Harga</label>
                                <select id="pos-customer-select" onchange="updatePOSCartPricing()" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-full font-bold focus:outline-none">
                                    <!-- populated dynamically -->
                                </select>
                            </div>
                        </div>

                        <!-- Cart Items List -->
                        <div class="flex-1 overflow-y-auto p-4 space-y-3 min-h-0 bg-cream/10" id="pos-cart-items">
                            <!-- cart items list loaded here -->
                        </div>

                        <!-- Pricing Summary, Discounts, Hold Bill & Checkout -->
                        <div class="p-4 border-t border-cream-dark bg-white shrink-0 space-y-3">
                            <!-- Diskon Item / Transaksi -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div class="bg-cream/40 p-2 rounded-xl border border-cream-dark">
                                    <span class="text-[9px] font-bold text-zinc-400 block uppercase">Diskon Transaksi</span>
                                    <div class="flex items-center gap-1 mt-1">
                                        <span class="text-xs font-bold text-zinc-600">%</span>
                                        <input type="number" id="pos-discount-input" onkeyup="recalculatePOSCartTotal()" value="0" min="0" max="100" class="bg-transparent border-none p-0 text-xs font-bold w-full focus:outline-none">
                                    </div>
                                </div>
                                <div class="bg-cream/40 p-2 rounded-xl border border-cream-dark flex flex-col justify-center">
                                    <span class="text-[9px] font-bold text-zinc-400 block uppercase">Metode Default</span>
                                    <span class="text-xs font-bold text-zinc-800 mt-1">Tunai / Cash</span>
                                </div>
                            </div>

                            <!-- Final Total -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs text-zinc-500">
                                    <span>Subtotal</span>
                                    <span id="pos-cart-subtotal">Rp 0</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-zinc-500">
                                    <span>Diskon Transaksi</span>
                                    <span id="pos-cart-discount-value" class="text-red-500">- Rp 0</span>
                                </div>
                                <div class="flex items-center justify-between border-t border-dashed border-cream-dark pt-2">
                                    <span class="font-extrabold text-sm">TOTAL AKHIR</span>
                                    <span class="font-black text-lg text-zinc-900" id="pos-cart-total-display">Rp 0</span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="grid grid-cols-1 gap-2 pt-1 sm:grid-cols-3">
                                <!-- Hold bill -->
                                <button onclick="holdActiveBill()" class="bg-cream-dark hover:bg-zinc-200 text-zinc-800 text-xs font-bold py-3 rounded-xl transition-all active:scale-95 flex flex-col items-center justify-center gap-1">
                                    <i data-lucide="archive" class="w-4 h-4"></i>
                                    <span>Hold Bill</span>
                                </button>
                                <!-- Checkout / Pembayaran -->
                                <button onclick="openPaymentModal()" class="sm:col-span-2 bg-primary hover:bg-primary-dark text-zinc-900 text-sm font-black py-3 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 border border-primary-dark/20">
                                    <i data-lucide="credit-card" class="w-5 h-5 text-zinc-950"></i>
                                    <span>BAYAR SEKARANG</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <!-- SECTION 9: KEUANGAN - KAS MASUK KELUAR -->
            <div id="section-keu-kas" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Kas & Jurnal Keuangan</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Log arus uang tunai dan bank (Pemasukan, Pengeluaran Operasional).</p>
                    </div>
                    <button onclick="openCashFlowModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Catat Kas Masuk/Keluar
                    </button>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
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
            <div id="section-keu-tagihan" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Tagihan (Piutang)</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi dan pelunasan piutang outlet/distributor air.</p>
                    </div>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
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
            <div id="section-keu-hutang" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Hutang ke Supplier</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi transfer pelunasan belanja stok bahan baku kepada supplier.</p>
                    </div>
                </div>
                <div class="bg-white border border-cream-dark rounded-xl p-6">
                        <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
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

            <!-- SECTION 10: LAPORAN ANALITIS -->
            <div id="section-laporan" class="space-y-6 hidden">
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

            <!-- SECTION 11: PENGATURAN SISTEM -->
            <div id="section-sistem" class="space-y-6 hidden">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Pengaturan Sistem & User</h2>
                        <p class="text-zinc-500 text-sm mt-0.5">Kelola data user, hak akses, audit log, dan limit perigatan notifikasi.</p>
                    </div>
                </div>

                <!-- Inner Settings Tab Bar -->
                <div class="bg-white p-1 rounded-xl border border-cream-dark flex flex-wrap gap-1">
                    <button onclick="switchSettingsSubTab(event, 'set-user')" id="btn-set-user" class="settings-subtab-btn px-4 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm">User, Role & Audit Log</button>
                    <button onclick="switchSettingsSubTab(event, 'set-struk')" id="btn-set-struk" class="settings-subtab-btn px-4 py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream">Pengaturan Struk & Notifikasi</button>
                </div>

                <!-- SUB-SETTING: USER, ROLE & AUDIT LOG -->
                <div id="set-user" class="grid grid-cols-1 lg:grid-cols-2 gap-6 settings-sub-pane">
                    <!-- User & Role CRUD -->
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-sm">Manajemen User & Hak Akses</h3>
                            <button onclick="addNewUser()" class="bg-primary text-xs font-bold px-3 py-1.5 rounded-lg">Tambah User</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[640px] text-left text-xs">
                                <thead>
                                    <tr class="border-b border-cream-dark text-zinc-400 font-bold">
                                        <th class="pb-2">Username</th>
                                        <th class="pb-2">Role</th>
                                        <th class="pb-2">Permissions</th>
                                        <th class="pb-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 font-semibold">admin.elang</td><td class="py-2">Super Admin</td><td class="py-2">Semua Fitur</td><td class="py-2 text-right text-zinc-400">Default</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 font-semibold">lia.kasir</td><td class="py-2">Kasir</td><td class="py-2">POS, Kas Kecil</td><td class="py-2 text-right text-red-500 cursor-pointer" onclick="Swal.fire('Info', 'User default tidak bisa dihapus', 'info')">Hapus</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 font-semibold">budi.driver</td><td class="py-2">Distributor / Driver</td><td class="py-2">DO, Upload Bukti</td><td class="py-2 text-right text-red-500 cursor-pointer" onclick="Swal.fire('Info', 'User default tidak bisa dihapus', 'info')">Hapus</td></tr>
                            </tbody>
                        </table>
                            </div>
                    </div>

                    <!-- Audit Log & Notifikasi Alert Manager -->
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl space-y-4">
                        <h3 class="font-bold text-sm border-b border-cream-dark pb-2">Audit Log Aktivitas Sistem Terakhir</h3>
                        <div class="space-y-3 text-[11px] max-h-56 overflow-y-auto pr-1">
                            <div class="p-2 bg-cream/30 border-l-2 border-primary rounded">
                                <span class="font-bold">admin.elang</span> melakukan <span class="font-bold text-zinc-900">Stock Opname Approval</span> untuk Gudang Utama.
                                <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 10:48</p>
                            </div>
                            <div class="p-2 bg-cream/30 border-l-2 border-green-500 rounded">
                                <span class="font-bold">lia.kasir</span> melakukan checkout penjualan <span class="font-bold text-green-700">Rp 120.000</span> (Tunai).
                                <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 10:30</p>
                            </div>
                            <div class="p-2 bg-cream/30 border-l-2 border-blue-500 rounded">
                                <span class="font-bold">budi.driver</span> memperbarui status <span class="font-bold text-blue-700">DO-0092 menjadi Terkirim</span>.
                                <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 09:15</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUB-SETTING: PENGATURAN STRUK & NOTIFIKASI -->
                <div id="set-struk" class="settings-sub-pane hidden" style="display:none"><div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Form Pengaturan Struk -->
                    <div class="lg:col-span-2 bg-white border border-cream-dark p-5 rounded-2xl space-y-4">
                        <h3 class="font-bold text-sm border-b border-cream-dark pb-2 flex items-center gap-2">
                            <i data-lucide="receipt" class="w-4 h-4 text-primary-dark"></i> Pengaturan Printer & Struk Belanja
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Judul Struk / Nama Toko</label>
                                <input type="text" id="set-receipt-title" onkeyup="updateLiveReceiptPreview()" value="DEPOT AIR ELANGWATER" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Email Toko</label>
                                <input type="email" id="set-receipt-email" onkeyup="updateLiveReceiptPreview()" value="info@elangwater.com" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="font-bold text-zinc-500 block mb-1">Alamat Toko</label>
                                <input type="text" id="set-receipt-address" onkeyup="updateLiveReceiptPreview()" value="Jl. Tumenggung Suryo 76A Malang" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="font-bold text-zinc-500 block mb-1">Catatan Kaki Struk (Footer Notes)</label>
                                <textarea id="set-receipt-footer" onkeyup="updateLiveReceiptPreview()" rows="2" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">Air Bersih Sehat Keluarga Anda</textarea>
                            </div>
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Tampilkan Logo Toko di Struk</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <input type="checkbox" id="set-receipt-show-logo" onchange="updateLiveReceiptPreview()" checked class="w-4 h-4 accent-primary">
                                    <span class="font-semibold text-zinc-600">Aktif</span>
                                </div>
                            </div>
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Upload File Logo Struk</label>
                                <button onclick="Swal.fire('Upload File', 'Pilih file logo untuk struk belanja Anda', 'info')" class="bg-cream border border-cream-dark text-zinc-700 font-bold px-3 py-1.5 rounded-lg text-[10px] w-full flex items-center justify-center gap-1">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i> Pilih Gambar Logo
                                </button>
                            </div>
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Ukuran Kertas Thermal</label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-1.5 font-semibold">
                                        <input type="radio" name="paper-size" value="58mm" onchange="updateLiveReceiptPreview()" checked class="accent-primary"> 58mm
                                    </label>
                                    <label class="flex items-center gap-1.5 font-semibold">
                                        <input type="radio" name="paper-size" value="80mm" onchange="updateLiveReceiptPreview()" class="accent-primary"> 80mm
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="font-bold text-zinc-500 block mb-1">Kirim Salinan Struk Otomatis ke Email</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <input type="checkbox" id="set-receipt-email-auto" class="w-4 h-4 accent-primary">
                                    <span class="font-semibold text-zinc-600">Aktifkan Kirim Email</span>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label class="font-bold text-zinc-500 block mb-1">Cetak Otomatis Setelah Pembayaran Sukses</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <input type="checkbox" id="set-receipt-print-auto" checked class="w-4 h-4 accent-primary">
                                    <span class="font-semibold text-zinc-600">Langsung Cetak ke Printer Lpt/Bluetooth</span>
                                </div>
                            </div>
                        </div>

                        <!-- Config Limit Notifikasi -->
                        <div class="border-t border-cream-dark pt-4 space-y-3">
                            <h4 class="font-bold text-xs text-zinc-700">Pengaturan Notifikasi Alert & Limit System</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <label class="font-bold text-zinc-500 block mb-1">Stok Minimum (Alert)</label>
                                    <input type="number" value="15" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                                </div>
                                <div>
                                    <label class="font-bold text-zinc-500 block mb-1">Tagihan Jatuh Tempo (Hari)</label>
                                    <input type="number" value="7" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                                </div>
                                <div>
                                    <label class="font-bold text-zinc-500 block mb-1">Hutang Jatuh Tempo (Hari)</label>
                                    <input type="number" value="14" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-3">
                            <button onclick="saveReceiptSettingsSim()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-6 py-2 rounded-xl text-xs">
                                Simpan Semua Konfigurasi
                            </button>
                        </div>
                    </div>

                    <!-- Live Preview Struk (Interactive) -->
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl space-y-4">
                        <h3 class="font-bold text-sm border-b border-cream-dark pb-2 flex items-center justify-between">
                            <span>Live Preview Struk</span>
                            <span id="preview-paper-size-badge" class="px-2 py-0.5 bg-zinc-200 text-zinc-700 rounded text-[9px] font-bold">58mm</span>
                        </h3>
                        
                        <!-- Simulated Struk Paper -->
                        <div id="live-receipt-paper" class="border border-zinc-300 p-4 bg-zinc-50 rounded-lg text-zinc-800 text-[10px] font-mono space-y-2 max-w-[240px] mx-auto shadow-sm">
                            <div class="text-center border-b border-dashed border-zinc-400 pb-2">
                                <div id="preview-logo-icon" class="mb-1"><i data-lucide="droplet" class="w-5 h-5 mx-auto text-primary-dark"></i></div>
                                <p id="preview-rec-title" class="font-bold text-[11px] uppercase">DEPOT AIR ELANGWATER</p>
                                <p id="preview-rec-email">info@elangwater.com</p>
                                <p id="preview-rec-address" class="text-[10px] text-zinc-500">Jl. H. Abdurrahman No. 12, Denpasar</p>
                                <p>HP: 0812-3456-7890</p>
                            </div>
                            <div class="space-y-0.5">
                                <p>No: TRX-171912459</p>
                                <p>Tgl: 23/06/2026 13:40</p>
                                <p>Ksr: Lia Kasir</p>
                            </div>
                            <div class="border-t border-b border-dashed border-zinc-400 py-1 space-y-0.5">
                                <div class="flex justify-between">
                                    <span>Galon Elangwater x1</span>
                                    <span>Rp 15.000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Botol 600ml x2</span>
                                    <span>Rp 76.000</span>
                                </div>
                            </div>
                            <div class="text-right space-y-0.5">
                                <p>Subtotal: Rp 91.000</p>
                                <p class="font-bold">Total: Rp 91.000</p>
                            </div>
                            <div class="text-center border-t border-dashed border-zinc-400 pt-2 text-[9px]">
                                <p class="font-bold">TERIMA KASIH</p>
                                <p id="preview-rec-footer">Air Bersih Sehat Keluarga Anda</p>
                            </div>
                        </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL 1: CHECKOUT POS PAYMENT -->
    <div id="payment-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <!-- Modal Header -->
            <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
                <span class="font-bold text-base flex items-center gap-2">
                    <i data-lucide="check-square" class="w-5 h-5"></i> Selesaikan Transaksi Penjualan
                </span>
                <button onclick="closePaymentModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-4">
                <div class="text-center bg-cream/50 p-4 rounded-xl border border-cream-dark">
                    <span class="text-xs text-zinc-500 font-bold block uppercase">Total Tagihan Pembayaran</span>
                    <h3 class="text-3xl font-black text-zinc-950 mt-1" id="payment-modal-total">Rp 0</h3>
                </div>

                <!-- Payment Method Select -->
                <div>
                    <label class="text-xs font-bold text-zinc-500 block mb-1">Metode Pembayaran</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button onclick="selectPaymentMethod('Tunai')" id="pay-btn-Tunai" class="pay-method-btn py-3 border border-primary bg-primary-light text-zinc-900 rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                            <i data-lucide="banknote" class="w-5 h-5"></i> Tunai / Cash
                        </button>
                        <button onclick="selectPaymentMethod('Transfer')" id="pay-btn-Transfer" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                            <i data-lucide="send" class="w-5 h-5"></i> Bank Transfer
                        </button>
                        <button onclick="selectPaymentMethod('QRIS')" id="pay-btn-QRIS" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                            <i data-lucide="qr-code" class="w-5 h-5"></i> QRIS GPN
                        </button>
                        <button onclick="selectPaymentMethod('E-Wallet')" id="pay-btn-E-Wallet" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                            <i data-lucide="smartphone" class="w-5 h-5"></i> E-Wallet
                        </button>
                    </div>
                </div>

                <!-- Cash input (Visible when Tunai is active) -->
                <div id="cash-input-group" class="space-y-3">
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="presetCashAmount(10000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">10.000</button>
                        <button onclick="presetCashAmount(50000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">50.000</button>
                        <button onclick="presetCashAmount(100000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">100.000</button>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-zinc-500 block mb-1">Nominal Uang Diterima</label>
                        <input type="number" id="cash-received-input" onkeyup="calculateChange()" class="bg-cream border border-cream-dark text-lg font-black rounded-xl px-4 py-2.5 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right" placeholder="0">
                    </div>
                    <div class="flex justify-between items-center text-xs font-semibold text-zinc-500 bg-red-50/50 p-2.5 rounded-lg border border-red-100/50">
                        <span>Kembalian Uang Tunai</span>
                        <span class="font-extrabold text-red-600 text-sm" id="cash-change-display">Rp 0</span>
                    </div>
                </div>

                <button onclick="processPOSCheckout()" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 text-sm font-black py-3.5 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 border border-primary-dark/20">
                    <i data-lucide="printer" class="w-4 h-4"></i> PROSES TRANSAKSI & CETAK STRUK
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: PRINT STRUK PREVIEW (Simulated receipt) -->
    <div id="receipt-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-sm max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6 space-y-4">
                <!-- Struk Paper Mockup -->
                <div class="border border-zinc-300 p-4 bg-zinc-50 rounded-lg text-zinc-800 text-[11px] font-mono space-y-2">
                    <div class="text-center border-b border-dashed border-zinc-400 pb-2">
                        <p id="rec-header-title" class="font-bold text-xs uppercase">DEPOT AIR ELANGWATER</p>
                        <p id="rec-header-email" class="text-[9px] text-zinc-500">info@elangwater.com</p>
                        <p id="rec-header-address" class="text-[9px] text-zinc-500">Jl. H. Abdurrahman No. 12, Denpasar</p>
                        <p>HP: 0812-3456-7890</p>
                    </div>
                    <div class="space-y-1">
                        <p>No: <span id="rec-no">TRX-20260623-01</span></p>
                        <p>Tgl: <span id="rec-date">23/06/2026 10:55</span></p>
                        <p>Ksr: <span id="rec-cashier">Lia Kasir</span></p>
                        <p>Cust: <span id="rec-customer">Retail / Pelanggan Umum</span></p>
                    </div>
                    <div class="border-t border-b border-dashed border-zinc-400 py-1 space-y-1" id="rec-items">
                        <!-- loaded dynamically -->
                    </div>
                    <div class="text-right space-y-0.5">
                        <p>Subtotal: <span id="rec-subtotal">Rp 0</span></p>
                        <p>Diskon: <span id="rec-discount">Rp 0</span></p>
                        <p class="font-bold">Total: <span id="rec-total">Rp 0</span></p>
                        <p>Bayar: <span id="rec-paid">Rp 0</span></p>
                        <p>Kembali: <span id="rec-change">Rp 0</span></p>
                    </div>
                    <div class="text-center border-t border-dashed border-zinc-400 pt-2 text-[10px]">
                        <p class="font-bold">TERIMA KASIH</p>
                        <p id="rec-footer-text">Air Bersih Sehat Keluarga Anda</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <button onclick="closeReceiptModal()" class="bg-cream-dark hover:bg-zinc-200 text-zinc-800 text-xs font-bold py-2.5 rounded-xl transition-all">Tutup</button>
                    <button onclick="window.print();" class="bg-primary hover:bg-primary-dark text-zinc-900 text-xs font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="printer" class="w-4 h-4"></i> Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 3: ADD NEW PRODUCT -->
    <div id="add-product-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
                <span class="font-bold text-base flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Produk Baru
                </span>
                <button onclick="closeAddProductModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <form id="new-product-form" onsubmit="saveProduct(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Nama Produk</label>
                        <input type="text" id="new-prod-name" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">SKU</label>
                        <input type="text" id="new-prod-sku" required placeholder="ELG-XXX-XXX" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Barcode</label>
                        <input type="text" id="new-prod-barcode" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Kategori</label>
                        <select id="new-prod-cat" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                            <option>Galon</option>
                            <option>Botol</option>
                            <option>Gelas</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Brand</label>
                        <input type="text" id="new-prod-brand" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Volume (Liter / ml / kardus)</label>
                        <input type="text" id="new-prod-vol" required placeholder="19L atau 600ml" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Satuan</label>
                        <input type="text" id="new-prod-unit" required placeholder="Galon, Box, Pcs" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Harga Modal</label>
                        <input type="number" id="new-prod-modal" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Harga Jual Retail</label>
                        <input type="number" id="new-prod-retail" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Harga Jual Grosir</label>
                        <input type="number" id="new-prod-wholesale" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                    </div>
                    <div class="col-span-2">
                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 font-bold py-2.5 rounded-xl transition-all">Simpan Produk Baru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 4: SIMULATE WAREHOUSE TRANSFER -->
    <div id="transfer-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
                <span class="font-bold text-base flex items-center gap-2">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i> Permohonan Transfer Gudang
                </span>
                <button onclick="closeTransferModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <form id="transfer-form" onsubmit="saveTransfer(event)" class="space-y-3 text-xs">
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Gudang Pengirim (Asal)</label>
                        <select id="tf-source" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                            <option>Gudang Utama</option>
                            <option>Depo Elang Utara</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Gudang Penerima (Tujuan)</label>
                        <select id="tf-dest" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                            <option>Depo Elang Utara</option>
                            <option>Gudang Utama</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Pilih Produk</label>
                        <select id="tf-product" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                            <!-- populated by JS -->
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Jumlah Qty Transfer</label>
                        <input type="number" id="tf-qty" required min="1" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 font-bold py-2.5 rounded-xl transition-all">Kirim Permohonan Transfer</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT STATE ENGINE -->
    <script>
        // Init state database
        let products = [
            { id: 1, name: 'Galon Elangwater 19L', sku: 'ELG-GAL-19L', barcode: '8991234560012', category: 'Galon', brand: 'Elangwater', volume: '19L', unit: 'Galon', cost: 8000, retailPrice: 15000, wholesalePrice: 12000, agencyPrice: 13500, active: true, image: 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 850, 'Depo Elang Utara': 2 } },
            { id: 2, name: 'Botol Elangwater 600ml', sku: 'ELG-BOT-600M', barcode: '8991234560029', category: 'Botol', brand: 'Elangwater', volume: '600ml', unit: 'Box', cost: 28000, retailPrice: 38000, wholesalePrice: 33000, agencyPrice: 35000, active: true, image: 'https://images.unsplash.com/photo-1608885898957-a599fb18de37?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 120, 'Depo Elang Utara': 40 } },
            { id: 3, name: 'Botol Elangwater 1500ml', sku: 'ELG-BOT-1500M', barcode: '8991234560036', category: 'Botol', brand: 'Elangwater', volume: '1500ml', unit: 'Box', cost: 30000, retailPrice: 42000, wholesalePrice: 36000, agencyPrice: 38500, active: true, image: 'https://images.unsplash.com/photo-1548839130-3bf604e40290?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 90, 'Depo Elang Utara': 5 } },
            { id: 4, name: 'Gelas Elangwater 240ml', sku: 'ELG-CUP-240M', barcode: '8991234560043', category: 'Gelas', brand: 'Elangwater', volume: '240ml', unit: 'Box', cost: 18000, retailPrice: 24000, wholesalePrice: 20000, agencyPrice: 22000, active: true, image: 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 15, 'Depo Elang Utara': 12 } }
        ];

        let warehouses = [
            { name: 'Gudang Utama', code: 'GD-UTAMA', pic: 'Slamet', address: 'Kawasan Industri Cikarang Blok B-12', isMulti: true },
            { name: 'Depo Elang Utara', code: 'GD-UTARA', pic: 'Dedi', address: 'Jl. Danau Sunter Barat No. 8', isMulti: true }
        ];

        let customers = [
            { name: 'Toko Makmur Sejahtera', type: 'Distributor', phone: '081299887711', address: 'Jakarta Utara', spend: 48900000, debt: 4500000 },
            { name: 'Budi Agen Air Lestari', type: 'Agen', phone: '085711223344', address: 'Bekasi Barat', spend: 15200000, debt: 2100000 },
            { name: 'Pelanggan Umum', type: 'Retail', phone: '-', address: 'Outlet Kasir', spend: 12450000, debt: 0 }
        ];

        let suppliers = [
            { name: 'PT Kemasan Plastik Indonesia', contact: 'Rita', phone: '021-8990123', address: 'Tangerang', spend: 12500000, debt: 2200000 },
            { name: 'CV Sumber Mata Air Pegunungan', contact: 'Anto', phone: '0811990088', address: 'Bogor', spend: 32000000, debt: 2000000 }
        ];

        let transfers = [
            { code: 'TF-0081', from: 'Gudang Utama', to: 'Depo Elang Utara', item: 'Galon Elangwater 19L', qty: 100, date: '2026-06-22', status: 'Pending' },
            { code: 'TF-0080', from: 'Depo Elang Utara', to: 'Gudang Utama', item: 'Botol Elangwater 600ml', qty: 50, date: '2026-06-20', status: 'Approved' }
        ];

        let opnames = [
            { code: 'OP-005', warehouse: 'Gudang Utama', item: 'Gelas Elangwater 240ml', bookStock: 15, physicalStock: 15, diff: 0, remark: 'Stok Sesuai', status: 'Approved' }
        ];

        let purchasing = [
            { poNo: 'PO-2026-012', supplier: 'PT Kemasan Plastik Indonesia', date: '2026-06-21', item: 'Botol Kosong 600ml (10.000 Pcs)', totalCost: 15000000, status: 'Received' },
            { poNo: 'PO-2026-013', supplier: 'CV Sumber Mata Air Pegunungan', date: '2026-06-23', item: 'Pasokan Air Tangki 10.000L (2 Tangki)', totalCost: 4000000, status: 'Approved' }
        ];

        let deliverOrders = [
            { doNo: 'DO-2026-092', customer: 'Toko Makmur Sejahtera', driver: 'Agus Delivery', items: 'Galon Elangwater 19L (150 Pcs)', status: 'Sedang Dikirim' },
            { doNo: 'DO-2026-091', customer: 'Budi Agen Air Lestari', driver: 'Rian Delivery', items: 'Botol Elangwater 600ml (20 Box)', status: 'Selesai' }
        ];

        let cashFlow = [
            { journalNo: 'JRN-2026-045', date: '2026-06-23', type: 'Masuk', category: 'Penjualan POS', remark: 'Penjualan POS Cash Shift Pagi', amount: 3500000 },
            { journalNo: 'JRN-2026-046', date: '2026-06-23', type: 'Keluar', category: 'Operasional', remark: 'Beli Bensin Delivery Truck', amount: 250000 }
        ];

        // POS Cart State
        let posCart = [];
        let activePaymentMethod = 'Tunai';

        // Hold bills state
        let holdBills = [];

        // Active workspace tab
        let activeTab = 'dashboard';
        let mobileSidebarOpen = false;

        window.onload = function() {
            lucide.createIcons();
            renderDashboard();
            renderProducts();
            renderPOSCatalog();
            populateSelects();
            renderWarehouses();
            renderStockTable();
            renderSuppliers();
            renderCustomers();
            renderTransfers();
            renderOpnameTable();
            renderIncomingStock();
            renderOutgoingStock();
            renderKartuStok();
            renderPembelian();
            renderDO();
            renderBuktiKirim();
            renderKeuanganKas();
            renderKeuanganTagihan();
            renderKeuanganHutang();
            initCharts();
            // Load default reports
            loadReport('penjualan', 'penjualan-harian');
            loadReport('inventori', 'stok-tanggal');
            loadReport('pembelian', 'pembelian-supplier');
            loadReport('pelanggan', 'top-customer');
            loadReport('keuangan', 'arus-kas');
            // Init settings pane visibility (uses style.display, not hidden class)
            const setUserPane = document.getElementById('set-user');
            if (setUserPane) setUserPane.style.display = 'grid';
            const setStrukPane = document.getElementById('set-struk');
            if (setStrukPane) setStrukPane.style.display = 'none';
        };

        // Navigation
        function switchTab(tabId) {
            document.querySelectorAll('#workspace-content > div').forEach(div => div.classList.add('hidden'));
            
            // Handle sub-sections switching correctly
            let targetDiv = document.getElementById('section-' + tabId);
            if (targetDiv) {
                targetDiv.classList.remove('hidden');
            }

            // Remove active classes from navigation items
            document.querySelectorAll('#main-navigation button').forEach(btn => {
                btn.className = btn.className.replace('bg-primary text-zinc-900 shadow-sm border border-primary/20', 'text-zinc-700 hover:text-zinc-900');
            });

            // Set active class on main menu buttons if applicable
            let mainNavBtn = document.getElementById('nav-' + tabId.split('-')[0]);
            if (mainNavBtn) {
                mainNavBtn.className = "w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream bg-primary text-zinc-900 shadow-sm border border-primary/20";
            }

            activeTab = tabId;
            lucide.createIcons();

            if (mobileSidebarOpen) {
                closeMobileSidebar();
            }
        }

        function toggleSubmenu(submenuId) {
            let submenu = document.getElementById(submenuId);
            let arrow = document.getElementById('arrow-' + submenuId.split('-')[1]);
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleMobileSidebar() {
            let sidebar = document.getElementById('main-sidebar');
            let overlay = document.getElementById('mobile-sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                mobileSidebarOpen = true;
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                mobileSidebarOpen = false;
            }
        }

        function closeMobileSidebar() {
            let sidebar = document.getElementById('main-sidebar');
            let overlay = document.getElementById('mobile-sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            mobileSidebarOpen = false;
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeMobileSidebar();
            }
        });

        // Simulating Roles & Permissions
        function changeRoleSim(role) {
            const roleInfo = {
                admin: { name: 'Rakryan Alangwater', desc: 'Super Admin' },
                kasir: { name: 'Lia Kasir', desc: 'Kasir POS' },
                gudang: { name: 'Karno Staf Gudang', desc: 'Staf Gudang' },
                distributor: { name: 'Budi Driver', desc: 'Sopir / Distribusi' }
            };
            
            document.getElementById('user-display-name').innerText = roleInfo[role].name;
            document.getElementById('user-display-role').innerText = roleInfo[role].desc;
            
            Swal.fire({
                title: 'Perubahan Role',
                text: `Sekarang masuk sebagai role ${roleInfo[role].desc}. Izin akses telah disesuaikan secara visual!`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }

        // RENDER FUNCTIONS
        function renderDashboard() {
            let tableBody = document.getElementById('dash-min-stock-table-body');
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

        function renderProducts() {
            let table = document.getElementById('master-produk-table-body');
            table.innerHTML = '';
            products.forEach(p => {
                let totalStock = Object.values(p.stock).reduce((a, b) => a + b, 0);
                table.innerHTML += `
                    <tr>
                        <td class="py-4 px-6 font-bold flex items-center gap-3">
                            <img src="${p.image}" class="w-10 h-10 object-cover rounded-lg border border-cream-dark">
                            <div>
                                <p class="text-sm font-bold text-zinc-900">${p.name}</p>
                                <p class="text-[10px] text-zinc-400">Brand: ${p.brand}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-zinc-600 font-mono">${p.sku}<p class="text-[10px] text-zinc-400">${p.barcode}</p></td>
                        <td class="py-4 px-6"><span class="px-2 py-0.5 bg-cream-dark text-zinc-700 rounded-full font-semibold text-[10px]">${p.category}</span></td>
                        <td class="py-4 px-6 text-zinc-600">${p.volume} / <span class="font-bold">${p.unit}</span></td>
                        <td class="py-4 px-6 font-semibold">Rp ${p.cost.toLocaleString('id-ID')}</td>
                        <td class="py-4 px-6 font-bold text-zinc-900">
                            Rp ${p.retailPrice.toLocaleString('id-ID')}
                            <p class="text-[10px] text-zinc-400 font-medium">Grosir: Rp ${p.wholesalePrice.toLocaleString('id-ID')}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">Aktif</span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button onclick="deleteProduct(${p.id})" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('master-prod-total-count').innerText = products.length;
        }

        // POS CATALOG & CART
        function renderPOSCatalog() {
            let grid = document.getElementById('pos-catalog-grid');
            grid.innerHTML = '';
            products.forEach(p => {
                if (p.active) {
                    let totalStock = Object.values(p.stock).reduce((a, b) => a + b, 0);
                    grid.innerHTML += `
                        <div onclick="addToPOSCart(${p.id})" class="bg-white border border-cream-dark p-3 rounded-2xl cursor-pointer hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all flex flex-col justify-between">
                            <img src="${p.image}" class="w-full h-24 object-cover rounded-xl mb-2">
                            <div class="space-y-1">
                                <span class="text-[9px] uppercase font-bold text-zinc-400">${p.category}</span>
                                <h4 class="font-bold text-xs leading-tight text-zinc-950 truncate">${p.name}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="font-black text-sm text-zinc-900">Rp ${p.retailPrice.toLocaleString('id-ID')}</span>
                                    <span class="text-[10px] font-bold ${totalStock <= 15 ? 'text-red-500' : 'text-zinc-500'}">Stok: ${totalStock}</span>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
        }

        function filterPOSCatalog() {
            let q = document.getElementById('pos-search-input').value.toLowerCase();
            let cards = document.querySelectorAll('#pos-catalog-grid > div');
            cards.forEach(card => {
                let name = card.querySelector('h4').innerText.toLowerCase();
                let category = card.querySelector('span').innerText.toLowerCase();
                if (name.includes(q) || category.includes(q)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function filterPOSCategory(e, cat) {
            document.querySelectorAll('.pos-cat-btn').forEach(btn => {
                btn.className = "pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all";
            });
            if (e && e.currentTarget) {
                e.currentTarget.className = "pos-cat-btn px-4 py-1.5 bg-zinc-950 text-white rounded-full text-xs font-bold transition-all";
            }
            
            let cards = document.querySelectorAll('#pos-catalog-grid > div');
            cards.forEach(card => {
                let category = card.querySelector('span').innerText;
                if (cat === '' || category === cat.toUpperCase()) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function populateSelects() {
            // Customer select in POS
            let select = document.getElementById('pos-customer-select');
            select.innerHTML = '';
            customers.forEach((c, idx) => {
                select.innerHTML += `<option value="${idx}">${c.name} (${c.type})</option>`;
            });

            // SKU filter in Kartu Stok
            let skuSelect = document.getElementById('kartu-stok-sku-filter');
            skuSelect.innerHTML = '<option value="">Pilih SKU Produk</option>';
            products.forEach(p => {
                skuSelect.innerHTML += `<option value="${p.sku}">${p.name} (${p.sku})</option>`;
            });

            // Add Product modal & Transfer modal Selects
            let tfProd = document.getElementById('tf-product');
            tfProd.innerHTML = '';
            products.forEach(p => {
                tfProd.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        }

        // CART LOGIC
        function addToPOSCart(prodId) {
            let product = products.find(p => p.id === prodId);
            let existing = posCart.find(item => item.product.id === prodId);

            if (existing) {
                existing.qty += 1;
            } else {
                posCart.push({ product: product, qty: 1 });
            }

            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function changeCartQty(index, amt) {
            posCart[index].qty += amt;
            if (posCart[index].qty <= 0) {
                posCart.splice(index, 1);
            }
            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function updatePOSCartPricing() {
            // Recalculates based on Level Harga (Retail, Agen, Distributor)
            recalculatePOSCartTotal();
        }

        function recalculatePOSCartTotal() {
            let subtotal = 0;
            let custIdx = document.getElementById('pos-customer-select').value;
            let customerType = customers[custIdx].type;

            posCart.forEach(item => {
                let price = item.product.retailPrice; // Default
                if (customerType === 'Agen') {
                    price = item.product.agencyPrice || item.product.retailPrice * 0.9;
                } else if (customerType === 'Distributor') {
                    price = item.product.wholesalePrice || item.product.retailPrice * 0.8;
                }
                subtotal += price * item.qty;
            });

            let discountPct = parseFloat(document.getElementById('pos-discount-input').value) || 0;
            let discountValue = (discountPct / 100) * subtotal;
            let finalTotal = subtotal - discountValue;

            document.getElementById('pos-cart-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('pos-cart-discount-value').innerText = '- Rp ' + discountValue.toLocaleString('id-ID');
            document.getElementById('pos-cart-total-display').innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');
            document.getElementById('payment-modal-total').innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');
        }

        function renderPOSCart() {
            let container = document.getElementById('pos-cart-items');
            container.innerHTML = '';

            if (posCart.length === 0) {
                container.innerHTML = `
                    <div class="h-full flex flex-col items-center justify-center text-zinc-400 py-12">
                        <i data-lucide="shopping-cart" class="w-8 h-8 mb-2 opacity-50"></i>
                        <p class="text-xs">Keranjang Belanja Kosong</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            let custIdx = document.getElementById('pos-customer-select').value;
            let customerType = customers[custIdx].type;

            posCart.forEach((item, idx) => {
                let price = item.product.retailPrice;
                if (customerType === 'Agen') price = item.product.agencyPrice;
                if (customerType === 'Distributor') price = item.product.wholesalePrice;

                container.innerHTML += `
                    <div class="bg-white border border-cream-dark p-3 rounded-xl flex items-center justify-between shadow-sm">
                        <div>
                            <h5 class="font-bold text-xs">${item.product.name}</h5>
                            <p class="text-[10px] text-zinc-500">Rp ${price.toLocaleString('id-ID')} / ${item.product.unit}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="changeCartQty(${idx}, -1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">-</button>
                            <span class="text-xs font-bold w-6 text-center">${item.qty}</span>
                            <button onclick="changeCartQty(${idx}, 1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">+</button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function clearPOSCart() {
            posCart = [];
            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function switchSettingsSubTab(event, tabId) {
            // Hide all panes by removing any active display and adding Tailwind hidden
            document.querySelectorAll('.settings-sub-pane').forEach(pane => {
                pane.style.display = '';
                pane.classList.add('hidden');
            });
            document.querySelectorAll('.settings-subtab-btn').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-zinc-900', 'shadow-sm');
                btn.classList.add('text-zinc-600');
            });

            if (event && event.currentTarget) {
                event.currentTarget.classList.add('bg-primary', 'text-zinc-900', 'shadow-sm');
                event.currentTarget.classList.remove('text-zinc-600');
            } else {
                const btnMap = { 'set-user': 'btn-set-user', 'set-struk': 'btn-set-struk' };
                let activeBtn = document.getElementById(btnMap[tabId] || ('btn-' + tabId));
                if (activeBtn) {
                    activeBtn.classList.add('bg-primary', 'text-zinc-900', 'shadow-sm');
                    activeBtn.classList.remove('text-zinc-600');
                }
            }

            let activePane = document.getElementById(tabId);
            if (activePane) {
                // remove hidden so Tailwind doesn't force display:none
                activePane.classList.remove('hidden');
                // set-user uses grid, set-struk wraps grid in a div
                activePane.style.display = (tabId === 'set-user') ? 'grid' : 'block';
            }
        }

        function simulateBarcodeScan() {
            // Simulate scanning the first product
            Swal.fire({
                title: 'Simulasi Scan Barcode',
                text: 'Memindai barcode "8991234560012" (Galon Elangwater 19L)',
                icon: 'info',
                timer: 1000,
                showConfirmButton: false
            });
            setTimeout(() => {
                addToPOSCart(1);
            }, 1000);
        }

        // HOLD & RESUME BILL
        function holdActiveBill() {
            if (posCart.length === 0) {
                Swal.fire('Keranjang Kosong', 'Tambahkan item ke keranjang sebelum menangguhkan transaksi.', 'warning');
                return;
            }
            let custName = customers[document.getElementById('pos-customer-select').value].name;
            holdBills.push({
                id: Date.now(),
                customer: custName,
                cart: [...posCart],
                date: new Date().toLocaleTimeString()
            });
            posCart = [];
            recalculatePOSCartTotal();
            renderPOSCart();
            document.getElementById('hold-bills-count').innerText = holdBills.length;
            Swal.fire('Bill Ditangguhkan', 'Transaksi berhasil disimpan sementara.', 'success');
        }

        function openHoldBillsModal() {
            if (holdBills.length === 0) {
                Swal.fire('Tidak ada Hold Bills', 'Belum ada struk transaksi yang ditangguhkan.', 'info');
                return;
            }

            let listHTML = holdBills.map((hb, idx) => `
                <div class="flex items-center justify-between p-3 border-b border-cream-dark text-xs">
                    <div>
                        <p class="font-bold">Customer: ${hb.customer}</p>
                        <p class="text-zinc-500">Jam: ${hb.date} (${hb.cart.length} item)</p>
                    </div>
                    <button onclick="resumeBill(${hb.id})" class="bg-primary hover:bg-primary-dark font-bold text-xs px-3 py-1.5 rounded-lg">Buka</button>
                </div>
            `).join('');

            Swal.fire({
                title: 'Daftar Hold Bills',
                html: `<div class="text-left max-h-60 overflow-y-auto">${listHTML}</div>`,
                showConfirmButton: false,
                showCloseButton: true
            });
        }

        function resumeBill(id) {
            let bill = holdBills.find(hb => hb.id === id);
            if (bill) {
                posCart = bill.cart;
                holdBills = holdBills.filter(hb => hb.id !== id);
                document.getElementById('hold-bills-count').innerText = holdBills.length;
                recalculatePOSCartTotal();
                renderPOSCart();
                Swal.close();
            }
        }

        // PAYMENT CHECKOUT
        function openPaymentModal() {
            if (posCart.length === 0) {
                Swal.fire('Keranjang Kosong', 'Silakan pilih produk terlebih dahulu.', 'warning');
                return;
            }
            document.getElementById('payment-modal').classList.remove('hidden');
            selectPaymentMethod('Tunai');
            calculateChange();
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        function selectPaymentMethod(method) {
            activePaymentMethod = method;
            document.querySelectorAll('.pay-method-btn').forEach(btn => {
                btn.className = "pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";
            });
            document.getElementById('pay-btn-' + method).className = "pay-method-btn py-3 border border-primary bg-primary-light text-zinc-900 rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";
            
            if (method === 'Tunai') {
                document.getElementById('cash-input-group').classList.remove('hidden');
            } else {
                document.getElementById('cash-input-group').classList.add('hidden');
            }
        }

        function presetCashAmount(amt) {
            document.getElementById('cash-received-input').value = amt;
            calculateChange();
        }

        function calculateChange() {
            let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
            let total = parseInt(totalDisplay) || 0;
            let received = parseInt(document.getElementById('cash-received-input').value) || 0;
            let change = received - total;

            if (change < 0) {
                document.getElementById('cash-change-display').innerText = 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
            } else {
                document.getElementById('cash-change-display').innerText = 'Rp ' + change.toLocaleString('id-ID');
            }
        }

        function processPOSCheckout() {
            let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
            let total = parseInt(totalDisplay) || 0;
            let received = parseInt(document.getElementById('cash-received-input').value) || 0;

            if (activePaymentMethod === 'Tunai' && received < total) {
                Swal.fire('Uang Kurang', 'Pembayaran tunai yang diterima kurang dari total belanja.', 'error');
                return;
            }

            // Deduct stock simulation
            posCart.forEach(item => {
                if (item.product.stock['Gudang Utama'] >= item.qty) {
                    item.product.stock['Gudang Utama'] -= item.qty;
                }
            });

            closePaymentModal();
            renderReceipt(total, received);
            clearPOSCart();
            renderProducts();
            renderStockTable();
            renderDashboard();
            
            // Add cash transaction
            cashFlow.unshift({
                journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                date: new Date().toISOString().slice(0, 10),
                type: 'Masuk',
                category: 'Penjualan POS',
                remark: 'Penjualan POS ' + activePaymentMethod,
                amount: total
            });
            renderKeuanganKas();
        }

        function renderReceipt(total, received) {
            document.getElementById('rec-no').innerText = 'TRX-' + Date.now();
            document.getElementById('rec-date').innerText = new Date().toLocaleString();
            
            // Dynamic receipt configurations
            let rTitle = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
            let rEmail = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
            let rAddress = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
            let rFooter = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';

            document.getElementById('rec-header-title').innerText = rTitle;
            document.getElementById('rec-header-email').innerText = rEmail;
            document.getElementById('rec-header-address').innerText = rAddress;
            document.getElementById('rec-footer-text').innerText = rFooter;
            
            let custIdx = document.getElementById('pos-customer-select').value;
            document.getElementById('rec-customer').innerText = customers[custIdx].name + ' (' + customers[custIdx].type + ')';

            let itemsHTML = '';
            posCart.forEach(item => {
                let price = item.product.retailPrice;
                if (customers[custIdx].type === 'Agen') price = item.product.agencyPrice;
                if (customers[custIdx].type === 'Distributor') price = item.product.wholesalePrice;
                itemsHTML += `
                    <div class="flex justify-between">
                        <span>${item.product.name} x${item.qty}</span>
                        <span>Rp ${(price * item.qty).toLocaleString('id-ID')}</span>
                    </div>
                `;
            });

            document.getElementById('rec-items').innerHTML = itemsHTML;
            document.getElementById('rec-subtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('rec-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('rec-paid').innerText = 'Rp ' + (activePaymentMethod === 'Tunai' ? received : total).toLocaleString('id-ID');
            
            let change = received - total;
            document.getElementById('rec-change').innerText = 'Rp ' + (change > 0 && activePaymentMethod === 'Tunai' ? change : 0).toLocaleString('id-ID');

            document.getElementById('receipt-modal').classList.remove('hidden');
        }

        function closeReceiptModal() {
            document.getElementById('receipt-modal').classList.add('hidden');
        }

        function updateLiveReceiptPreview() {
            let title = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
            let email = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
            let address = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
            let footer = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';
            let showLogo = document.getElementById('set-receipt-show-logo').checked;
            let paperSize = document.querySelector('input[name="paper-size"]:checked')?.value || '58mm';

            document.getElementById('preview-rec-title').innerText = title;
            document.getElementById('preview-rec-email').innerText = email;
            document.getElementById('preview-rec-address').innerText = address;
            document.getElementById('preview-rec-footer').innerText = footer;
            document.getElementById('preview-paper-size-badge').innerText = paperSize;
            document.getElementById('preview-logo-icon').style.display = showLogo ? 'block' : 'none';
        }

        function saveReceiptSettingsSim() {
            updateLiveReceiptPreview();
            Swal.fire('Berhasil', 'Pengaturan struk dan notifikasi berhasil disimpan.', 'success');
        }

        // OTHER SIMULATIONS
        function openAddProductModal() {
            document.getElementById('add-product-modal').classList.remove('hidden');
        }
        function closeAddProductModal() {
            document.getElementById('add-product-modal').classList.add('hidden');
        }
        function saveProduct(e) {
            e.preventDefault();
            let newProd = {
                id: products.length + 1,
                name: document.getElementById('new-prod-name').value,
                sku: document.getElementById('new-prod-sku').value,
                barcode: document.getElementById('new-prod-barcode').value,
                category: document.getElementById('new-prod-cat').value,
                brand: document.getElementById('new-prod-brand').value,
                volume: document.getElementById('new-prod-vol').value,
                unit: document.getElementById('new-prod-unit').value,
                cost: parseInt(document.getElementById('new-prod-modal').value),
                retailPrice: parseInt(document.getElementById('new-prod-retail').value),
                wholesalePrice: parseInt(document.getElementById('new-prod-wholesale').value),
                agencyPrice: Math.round(parseInt(document.getElementById('new-prod-retail').value) * 0.9),
                active: true,
                image: 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80',
                stock: { 'Gudang Utama': 100, 'Depo Elang Utara': 0 }
            };
            products.push(newProd);
            closeAddProductModal();
            renderProducts();
            renderPOSCatalog();
            populateSelects();
            renderStockTable();
            Swal.fire('Berhasil', 'Produk Baru berhasil disimpan ke Master Data!', 'success');
        }

        function deleteProduct(id) {
            products = products.filter(p => p.id !== id);
            renderProducts();
            renderPOSCatalog();
        }

        function renderWarehouses() {
            let container = document.getElementById('warehouse-grid');
            container.innerHTML = '';
            warehouses.forEach(w => {
                container.innerHTML += `
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-zinc-400 font-mono">${w.code}</span>
                            <i data-lucide="home" class="w-5 h-5 text-primary-dark"></i>
                        </div>
                        <h3 class="font-extrabold text-base">${w.name}</h3>
                        <p class="text-xs text-zinc-500">${w.address}</p>
                        <div class="border-t border-cream-dark pt-3 text-xs flex justify-between text-zinc-500 font-semibold">
                            <span>PIC: ${w.pic}</span>
                            <span class="text-green-600">Online</span>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function renderStockTable() {
            let table = document.getElementById('realtime-stock-table-body');
            table.innerHTML = '';
            products.forEach(p => {
                Object.keys(p.stock).forEach(gudang => {
                    let qty = p.stock[gudang];
                    let safetyLimit = p.category === 'Galon' ? 10 : 30;
                    let reorderPoint = safetyLimit * 1.5;
                    let shortage = qty <= safetyLimit ? '<span class="text-red-600 font-bold">Stok Kritis</span>' : (qty <= reorderPoint ? '<span class="text-yellow-600 font-semibold">Butuh Reorder</span>' : '<span class="text-green-600">Cukup</span>');

                    table.innerHTML += `
                        <tr class="hover:bg-cream/10">
                            <td class="py-3 px-4 font-bold text-zinc-900">${p.name}<p class="text-[10px] text-zinc-400">${p.sku}</p></td>
                            <td class="py-3 px-4 text-zinc-600">${gudang}</td>
                            <td class="py-3 px-4 font-black">${qty} ${p.unit}</td>
                            <td class="py-3 px-4 text-zinc-500">${safetyLimit} ${p.unit}</td>
                            <td class="py-3 px-4 text-zinc-500">${reorderPoint} ${p.unit}</td>
                            <td class="py-3 px-4">${shortage}</td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="adjustStockSim('${p.sku}', '${gudang}')" class="text-primary-dark hover:underline font-bold">Adjust</button>
                            </td>
                        </tr>
                    `;
                });
            });
        }

        function adjustStockSim(sku, warehouse) {
            Swal.fire({
                title: 'Stock Adjustment',
                text: `Masukkan jumlah stok fisik aktual untuk ${sku} di ${warehouse}`,
                input: 'number',
                inputAttributes: {
                    min: 0,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Sesuaikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    let p = products.find(prod => prod.sku === sku);
                    p.stock[warehouse] = parseInt(result.value);
                    renderStockTable();
                    renderDashboard();
                    Swal.fire('Berhasil', 'Stok berhasil disesuaikan di database!', 'success');
                }
            });
        }

        function renderTransfers() {
            let table = document.getElementById('transfer-stock-table-body');
            table.innerHTML = '';
            transfers.forEach(tf => {
                let statusBadge = tf.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${tf.code}</td>
                        <td class="py-3 px-4">${tf.from}</td>
                        <td class="py-3 px-4">${tf.to}</td>
                        <td class="py-3 px-4 font-semibold">${tf.item} (x${tf.qty})</td>
                        <td class="py-3 px-4 text-zinc-500">${tf.date}</td>
                        <td class="py-3 px-4"><span class="px-2.5 py-0.5 rounded text-[10px] font-bold ${statusBadge}">${tf.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            ${tf.status === 'Pending' ? `<button onclick="approveTransfer('${tf.code}')" class="bg-primary px-3 py-1 rounded font-bold text-[10px] text-zinc-900">Approve</button>` : '<span class="text-zinc-400">Selesai</span>'}
                        </td>
                    </tr>
                `;
            });
        }

        function openTransferModal() {
            document.getElementById('transfer-modal').classList.remove('hidden');
        }
        function closeTransferModal() {
            document.getElementById('transfer-modal').classList.add('hidden');
        }
        function saveTransfer(e) {
            e.preventDefault();
            let p = products.find(prod => prod.id == document.getElementById('tf-product').value);
            let qty = parseInt(document.getElementById('tf-qty').value);
            let from = document.getElementById('tf-source').value;
            let to = document.getElementById('tf-dest').value;

            if (p.stock[from] < qty) {
                Swal.fire('Stok Kurang', `Stok di ${from} tidak cukup untuk ditransfer.`, 'error');
                return;
            }

            transfers.unshift({
                code: 'TF-00' + (82 + transfers.length),
                from: from,
                to: to,
                item: p.name,
                qty: qty,
                date: new Date().toISOString().slice(0, 10),
                status: 'Pending'
            });

            closeTransferModal();
            renderTransfers();
            Swal.fire('Pemberitahuan', 'Permohonan transfer berhasil diajukan & menunggu persetujuan Admin!', 'info');
        }

        function approveTransfer(code) {
            let tf = transfers.find(t => t.code === code);
            let p = products.find(prod => prod.name === tf.item);
            
            if (p.stock[tf.from] >= tf.qty) {
                p.stock[tf.from] -= tf.qty;
                p.stock[tf.to] += tf.qty;
                tf.status = 'Approved';
                
                renderTransfers();
                renderStockTable();
                renderDashboard();
                Swal.fire('Disetujui', 'Transfer stok berhasil divalidasi & stok terupdate!', 'success');
            } else {
                Swal.fire('Gagal', 'Stok gudang asal sudah tidak mencukupi untuk transfer ini.', 'error');
            }
        }

        function renderOpnameTable() {
            let table = document.getElementById('opname-table-body');
            table.innerHTML = '';
            opnames.forEach(op => {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${op.code}</td>
                        <td class="py-3 px-4">${op.warehouse}</td>
                        <td class="py-3 px-4 font-semibold">${op.item}</td>
                        <td class="py-3 px-4 text-center font-semibold text-zinc-500">${op.bookStock}</td>
                        <td class="py-3 px-4 text-center font-bold text-zinc-950">${op.physicalStock}</td>
                        <td class="py-3 px-4 text-center font-bold ${op.diff === 0 ? 'text-green-600' : 'text-red-500'}">${op.diff}</td>
                        <td class="py-3 px-4 text-zinc-500">${op.remark}</td>
                        <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">${op.status}</span></td>
                    </tr>
                `;
            });
        }

        function openOpnameModal() {
            Swal.fire({
                title: 'Buat Opname Gudang',
                html: `
                    <select id="opname-wh" class="swal2-input">
                        <option>Gudang Utama</option>
                        <option>Depo Elang Utara</option>
                    </select>
                    <select id="opname-prod" class="swal2-input">
                        ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                    </select>
                    <input id="opname-phys" class="swal2-input" type="number" placeholder="Jumlah Fisik Aktual">
                    <input id="opname-desc" class="swal2-input" type="text" placeholder="Keterangan / Alasan Selisih">
                `,
                preConfirm: () => {
                    return {
                        wh: document.getElementById('opname-wh').value,
                        prodId: document.getElementById('opname-prod').value,
                        phys: parseInt(document.getElementById('opname-phys').value),
                        desc: document.getElementById('opname-desc').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let val = result.value;
                    let p = products.find(prod => prod.id == val.prodId);
                    let bookVal = p.stock[val.wh] || 0;
                    let diff = val.phys - bookVal;

                    opnames.unshift({
                        code: 'OP-00' + (6 + opnames.length),
                        warehouse: val.wh,
                        item: p.name,
                        bookStock: bookVal,
                        physicalStock: val.phys,
                        diff: diff,
                        remark: val.desc || 'Stock Opname Bulanan',
                        status: 'Approved'
                    });

                    // Update stock
                    p.stock[val.wh] = val.phys;

                    renderOpnameTable();
                    renderStockTable();
                    renderDashboard();
                    Swal.fire('Opname Berhasil', 'Stok buku telah disesuaikan dengan stok fisik!', 'success');
                }
            });
        }

        function renderIncomingStock() {
            let table = document.getElementById('incoming-stock-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">IN-2026-0044</td>
                    <td class="py-3 px-4">23 Juni 2026</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 text-green-700 font-bold">Pembelian Supplier</td>
                    <td class="py-3 px-4">Bahan Kemasan Galon Kosong (1.000 Pcs)</td>
                    <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">Telah Diterima</span></td>
                </tr>
            `;
        }

        function renderOutgoingStock() {
            let table = document.getElementById('outgoing-stock-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">OUT-2026-0099</td>
                    <td class="py-3 px-4">23 Juni 2026</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 text-blue-700 font-bold">DO Pelanggan</td>
                    <td class="py-3 px-4">Galon Elangwater 19L (150 Pcs)</td>
                    <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold text-[10px]">Sedang Dikirim</span></td>
                </tr>
            `;
        }

        function renderKartuStok() {
            let table = document.getElementById('kartu-stok-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 text-zinc-500">23 Jun 2026 10:48</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 font-bold">ELG-GAL-19L</td>
                    <td class="py-3 px-4">Mutasi Kirim ke Depo Utara (TF-0081)</td>
                    <td class="py-3 px-4 text-center">-</td>
                    <td class="py-3 px-4 text-center text-red-500 font-bold">100</td>
                    <td class="py-3 px-4 text-right font-bold">850</td>
                </tr>
                <tr>
                    <td class="py-3 px-4 text-zinc-500">23 Jun 2026 10:30</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 font-bold">ELG-GAL-19L</td>
                    <td class="py-3 px-4">Penjualan POS Kasir Shift Pagi</td>
                    <td class="py-3 px-4 text-center">-</td>
                    <td class="py-3 px-4 text-center text-red-500 font-bold">15</td>
                    <td class="py-3 px-4 text-right font-bold">950</td>
                </tr>
            `;
        }

        function filterKartuStok() {
            let sku = document.getElementById('kartu-stok-sku-filter').value;
            Swal.fire('Filter Berhasil', `Memfilter log pergerakan stok untuk SKU: ${sku || 'Semua'}`, 'info');
        }

        function renderCustomers() {
            let table = document.getElementById('customer-table-body');
            table.innerHTML = '';
            customers.forEach((c, idx) => {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-bold">${c.name}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded font-semibold text-[10px]">${c.type}</span></td>
                        <td class="py-3 px-4 font-mono">${c.phone}</td>
                        <td class="py-3 px-4 text-zinc-500">${c.address}</td>
                        <td class="py-3 px-4 font-semibold">Rp ${c.spend.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4 font-bold ${c.debt > 0 ? 'text-red-500' : 'text-green-600'}">Rp ${c.debt.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4 text-right">
                            <button onclick="Swal.fire('Riwayat Belanja', 'Riwayat pembelian customer ini akan ditarik dari database di backend.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Riwayat</button>
                        </td>
                    </tr>
                `;
            });
        }

        function openAddCustomerModal() {
            Swal.fire({
                title: 'Tambah Pelanggan Baru',
                html: `
                    <input id="c-name" class="swal2-input" placeholder="Nama Pelanggan / Toko">
                    <select id="c-type" class="swal2-input">
                        <option>Retail</option>
                        <option>Agen</option>
                        <option>Distributor</option>
                        <option>Toko</option>
                        <option>Kantor</option>
                    </select>
                    <input id="c-phone" class="swal2-input" placeholder="No. Telp">
                    <input id="c-address" class="swal2-input" placeholder="Alamat / Wilayah">
                `,
                preConfirm: () => {
                    return {
                        name: document.getElementById('c-name').value,
                        type: document.getElementById('c-type').value,
                        phone: document.getElementById('c-phone').value,
                        address: document.getElementById('c-address').value
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    customers.unshift({
                        name: res.value.name,
                        type: res.value.type,
                        phone: res.value.phone,
                        address: res.value.address,
                        spend: 0,
                        debt: 0
                    });
                    renderCustomers();
                    populateSelects();
                    Swal.fire('Berhasil', 'Pelanggan baru terdaftar!', 'success');
                }
            });
        }

        function renderSuppliers() {
            let table = document.getElementById('supplier-table-body');
            table.innerHTML = '';
            suppliers.forEach((s, idx) => {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-bold">${s.name}</td>
                        <td class="py-3 px-4 font-semibold text-zinc-600">${s.contact}</td>
                        <td class="py-3 px-4 font-mono">${s.phone}</td>
                        <td class="py-3 px-4 text-zinc-500">${s.address}</td>
                        <td class="py-3 px-4 font-semibold">Rp ${s.spend.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4 font-bold text-red-500">Rp ${s.debt.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4 text-right">
                            <button onclick="Swal.fire('Riwayat Transaksi', 'Menampilkan invoice pembelian dari supplier.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Transaksi</button>
                        </td>
                    </tr>
                `;
            });
        }

        function openAddSupplierModal() {
            Swal.fire({
                title: 'Tambah Supplier Baru',
                html: `
                    <input id="s-name" class="swal2-input" placeholder="Nama Perusahaan Supplier">
                    <input id="s-contact" class="swal2-input" placeholder="Nama Contact Person">
                    <input id="s-phone" class="swal2-input" placeholder="No. Telp / HP">
                    <input id="s-address" class="swal2-input" placeholder="Alamat Pabrik / Gudang">
                `,
                preConfirm: () => {
                    return {
                        name: document.getElementById('s-name').value,
                        contact: document.getElementById('s-contact').value,
                        phone: document.getElementById('s-phone').value,
                        address: document.getElementById('s-address').value
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    suppliers.unshift({
                        name: res.value.name,
                        contact: res.value.contact,
                        phone: res.value.phone,
                        address: res.value.address,
                        spend: 0,
                        debt: 0
                    });
                    renderSuppliers();
                    Swal.fire('Berhasil', 'Supplier baru berhasil dicatat!', 'success');
                }
            });
        }

        function renderPembelian() {
            let table = document.getElementById('po-table-body');
            table.innerHTML = '';
            purchasing.forEach((po, idx) => {
                let badgeClass = po.status === 'Received' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${po.poNo}</td>
                        <td class="py-3 px-4 font-semibold">${po.supplier}</td>
                        <td class="py-3 px-4 text-zinc-500">${po.date}</td>
                        <td class="py-3 px-4 text-zinc-600">${po.item}</td>
                        <td class="py-3 px-4 font-extrabold">Rp ${po.totalCost.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${badgeClass}">${po.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            ${po.status === 'Approved' ? `<button onclick="receiveGoodsSim('${po.poNo}')" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Receive Barang</button>` : '<span class="text-zinc-400">Received</span>'}
                        </td>
                    </tr>
                `;
            });
        }

        function openPOModal() {
            Swal.fire({
                title: 'Buat Pre-Order Pembelian',
                html: `
                    <select id="po-supp" class="swal2-input">
                        ${suppliers.map(s => `<option>${s.name}</option>`).join('')}
                    </select>
                    <input id="po-item" class="swal2-input" placeholder="Item / Deskripsi (e.g. 5.000 Pcs Tutup Galon)">
                    <input id="po-cost" class="swal2-input" type="number" placeholder="Estimasi Total Biaya (Rupiah)">
                `,
                preConfirm: () => {
                    return {
                        supplier: document.getElementById('po-supp').value,
                        item: document.getElementById('po-item').value,
                        cost: parseInt(document.getElementById('po-cost').value)
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    purchasing.unshift({
                        poNo: 'PO-2026-0' + (14 + purchasing.length),
                        supplier: res.value.supplier,
                        date: new Date().toISOString().slice(0, 10),
                        item: res.value.item,
                        totalCost: res.value.cost,
                        status: 'Approved'
                    });
                    renderPembelian();
                    Swal.fire('PO Diajukan', 'PO berhasil dibuat & menunggu barang datang dari supplier!', 'success');
                }
            });
        }

        function receiveGoodsSim(poNo) {
            let po = purchasing.find(p => p.poNo === poNo);
            po.status = 'Received';
            renderPembelian();
            renderIncomingStock();
            
            // Add to debts
            let sup = suppliers.find(s => s.name === po.supplier);
            if (sup) sup.debt += po.totalCost;
            renderSuppliers();
            renderKeuanganHutang();

            Swal.fire('Barang Diterima', 'Persediaan gudang ter-update dan hutang outstanding supplier dicatat!', 'success');
        }

        function renderDO() {
            let table = document.getElementById('do-table-body');
            table.innerHTML = '';
            deliverOrders.forEach((doItem, idx) => {
                let badgeClass = doItem.status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${doItem.doNo}</td>
                        <td class="py-3 px-4 font-semibold">${doItem.customer}</td>
                        <td class="py-3 px-4 text-zinc-600">${doItem.driver}</td>
                        <td class="py-3 px-4 text-zinc-500">${doItem.items}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${badgeClass}">${doItem.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            ${doItem.status === 'Sedang Dikirim' ? `<button onclick="updateDOStatus('${doItem.doNo}')" class="bg-primary text-[10px] font-bold px-2 py-1 rounded">Selesaikan</button>` : '<span class="text-zinc-400">Delivered</span>'}
                        </td>
                    </tr>
                `;
            });
        }

        function openDeliveryOrderModal() {
            Swal.fire({
                title: 'Buat Delivery Order (DO)',
                html: `
                    <select id="do-cust" class="swal2-input">
                        ${customers.map(c => `<option>${c.name}</option>`).join('')}
                    </select>
                    <select id="do-driver" class="swal2-input">
                        <option>Agus Delivery</option>
                        <option>Rian Delivery</option>
                    </select>
                    <input id="do-item" class="swal2-input" placeholder="Barang yang Dikirim (e.g. Galon 19L x50)">
                `,
                preConfirm: () => {
                    return {
                        customer: document.getElementById('do-cust').value,
                        driver: document.getElementById('do-driver').value,
                        items: document.getElementById('do-item').value
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    deliverOrders.unshift({
                        doNo: 'DO-2026-0' + (93 + deliverOrders.length),
                        customer: res.value.customer,
                        driver: res.value.driver,
                        items: res.value.items,
                        status: 'Sedang Dikirim'
                    });
                    renderDO();
                    renderBuktiKirim();
                    Swal.fire('DO Berhasil', 'DO telah dibuat dan siap dikirim oleh Driver!', 'success');
                }
            });
        }

        function updateDOStatus(doNo) {
            let doItem = deliverOrders.find(d => d.doNo === doNo);
            doItem.status = 'Selesai';
            renderDO();
            renderBuktiKirim();
            Swal.fire('Selesai', 'Status pengiriman berhasil diselesaikan!', 'success');
        }

        function renderBuktiKirim() {
            let table = document.getElementById('bukti-kirim-table-body');
            table.innerHTML = '';
            deliverOrders.forEach(d => {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${d.doNo}</td>
                        <td class="py-3 px-4 font-semibold">${d.customer}</td>
                        <td class="py-3 px-4">
                            ${d.status === 'Selesai' ? `<span class="text-green-600 font-bold flex items-center gap-1"><i data-lucide="image" class="w-4 h-4"></i> foto_depo_ok.jpg</span>` : '<span class="text-zinc-400">Belum Upload</span>'}
                        </td>
                        <td class="py-3 px-4">
                            ${d.status === 'Selesai' ? `<span class="text-green-600 font-bold flex items-center gap-1"><i data-lucide="edit-3" class="w-4 h-4"></i> digital_sign_ok</span>` : '<span class="text-zinc-400">Belum TTD</span>'}
                        </td>
                        <td class="py-3 px-4 text-zinc-500">${d.status === 'Selesai' ? '23 Juni 2026' : '-'}</td>
                        <td class="py-3 px-4 text-right">
                            ${d.status === 'Selesai' ? '<span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded font-bold">Verified</span>' : `<button onclick="uploadBuktiSim('${d.doNo}')" class="bg-primary text-[10px] font-bold px-2 py-1 rounded">Upload Bukti</button>`}
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        function uploadBuktiSim(doNo) {
            Swal.fire({
                title: 'Simulasi Upload Bukti Kirim',
                html: `
                    <p class="text-xs text-zinc-500 mb-3">Simulasikan upload foto bukti kirim dan tanda tangan digital customer</p>
                    <div class="border-2 border-dashed border-cream-dark p-6 rounded-lg text-center cursor-pointer mb-3">
                        <i data-lucide="camera" class="w-8 h-8 mx-auto text-zinc-400"></i>
                        <span class="text-[10px] font-bold text-zinc-500 block mt-2">PILIH FOTO OUTLET/DEPO</span>
                    </div>
                    <div class="border border-cream-dark p-4 rounded-lg bg-zinc-50">
                        <p class="text-[9px] text-zinc-400 mb-1">Canvas Tanda Tangan Customer</p>
                        <div class="h-16 bg-white border border-zinc-300 rounded flex items-center justify-center font-mono text-[10px] text-zinc-400">
                            [ Coretan Tanda Tangan ]
                        </div>
                    </div>
                `,
                confirmButtonText: 'Simpan Bukti Pengiriman'
            }).then(() => {
                updateDOStatus(doNo);
            });
            lucide.createIcons();
        }

        function renderKeuanganKas() {
            let table = document.getElementById('keu-kas-table-body');
            table.innerHTML = '';
            cashFlow.forEach(j => {
                let badgeClass = j.type === 'Masuk' ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${j.journalNo}</td>
                        <td class="py-3 px-4 text-zinc-500">${j.date}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-bold text-[10px] ${badgeClass}">${j.type}</span></td>
                        <td class="py-3 px-4 font-semibold">${j.category}</td>
                        <td class="py-3 px-4 text-zinc-600">${j.remark}</td>
                        <td class="py-3 px-4 text-right font-black ${j.type === 'Masuk' ? 'text-green-600' : 'text-red-500'}">
                            Rp ${j.amount.toLocaleString('id-ID')}
                        </td>
                    </tr>
                `;
            });
        }

        function openCashFlowModal() {
            Swal.fire({
                title: 'Catat Kas Arus Keuangan',
                html: `
                    <select id="cash-type" class="swal2-input">
                        <option value="Masuk">Kas Masuk (Pemasukan)</option>
                        <option value="Keluar">Kas Keluar (Pengeluaran)</option>
                    </select>
                    <input id="cash-cat" class="swal2-input" placeholder="Kategori Kas (e.g. Listrik, Operasional, POS)">
                    <input id="cash-desc" class="swal2-input" placeholder="Keterangan Rinci">
                    <input id="cash-amt" class="swal2-input" type="number" placeholder="Jumlah Rupiah">
                `,
                preConfirm: () => {
                    return {
                        type: document.getElementById('cash-type').value,
                        category: document.getElementById('cash-cat').value,
                        remark: document.getElementById('cash-desc').value,
                        amount: parseInt(document.getElementById('cash-amt').value)
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: res.value.type,
                        category: res.value.category,
                        remark: res.value.remark,
                        amount: res.value.amount
                    });
                    renderKeuanganKas();
                    Swal.fire('Tercatat', 'Arus kas berhasil dibukukan!', 'success');
                }
            });
        }

        function renderKeuanganTagihan() {
            let table = document.getElementById('keu-tagihan-table-body');
            table.innerHTML = '';
            customers.forEach((c, idx) => {
                if (c.debt > 0) {
                    table.innerHTML += `
                        <tr>
                            <td class="py-3 px-4 font-mono font-bold">INV-2026-003${idx}</td>
                            <td class="py-3 px-4 font-semibold">${c.name}</td>
                            <td class="py-3 px-4 font-black text-red-500">Rp ${c.debt.toLocaleString('id-ID')}</td>
                            <td class="py-3 px-4 text-zinc-500">30 Juni 2026</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold text-[10px]">Overdue</span></td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="payPiutangSim(${idx})" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Pelunasan</button>
                            </td>
                        </tr>
                    `;
                }
            });
        }

        function payPiutangSim(customerIdx) {
            let c = customers[customerIdx];
            Swal.fire({
                title: 'Konfirmasi Pembayaran Piutang',
                text: `Apakah customer ${c.name} melunasi tagihan sebesar Rp ${c.debt.toLocaleString('id-ID')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lunas'
            }).then(res => {
                if (res.isConfirmed) {
                    // add cash flow
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: 'Masuk',
                        category: 'Pelunasan Piutang',
                        remark: 'Pelunasan dari ' + c.name,
                        amount: c.debt
                    });
                    c.debt = 0;
                    renderKeuanganTagihan();
                    renderKeuanganKas();
                    renderCustomers();
                    Swal.fire('Lunas', 'Piutang customer berhasil dinolkan dan tercatat di kas masuk!', 'success');
                }
            });
        }

        function renderKeuanganHutang() {
            let table = document.getElementById('keu-hutang-table-body');
            table.innerHTML = '';
            suppliers.forEach((s, idx) => {
                if (s.debt > 0) {
                    table.innerHTML += `
                        <tr>
                            <td class="py-3 px-4 font-mono font-bold">PO-REF-00${idx}</td>
                            <td class="py-3 px-4 font-semibold">${s.name}</td>
                            <td class="py-3 px-4 font-black text-red-500">Rp ${s.debt.toLocaleString('id-ID')}</td>
                            <td class="py-3 px-4 text-zinc-500">28 Juni 2026</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold text-[10px]">Outstanding</span></td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="payHutangSim(${idx})" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Bayar Hutang</button>
                            </td>
                        </tr>
                    `;
                }
            });
        }

        function payHutangSim(supIdx) {
            let s = suppliers[supIdx];
            Swal.fire({
                title: 'Konfirmasi Pembayaran Hutang',
                text: `Apakah Anda ingin melunasi hutang ke ${s.name} sebesar Rp ${s.debt.toLocaleString('id-ID')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Bayar'
            }).then(res => {
                if (res.isConfirmed) {
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: 'Keluar',
                        category: 'Pelunasan Hutang',
                        remark: 'Pelunasan Hutang ke ' + s.name,
                        amount: s.debt
                    });
                    s.debt = 0;
                    renderKeuanganHutang();
                    renderKeuanganKas();
                    renderSuppliers();
                    Swal.fire('Lunas', 'Hutang supplier berhasil dilunasi!', 'success');
                }
            });
        }

        // LAPORAN SUBTAB
        function switchLaporanSubTab(paneId, defaultReport) {
            document.querySelectorAll('.laporan-sub-pane').forEach(p => p.classList.add('hidden'));
            document.getElementById(paneId).classList.remove('hidden');

            document.querySelectorAll('.laporan-subtab-btn').forEach(btn => {
                btn.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream";
            });
            event.target.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm";

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

            // GENERATE CORRESPONDING MOCK REPORT TABLES
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
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">22 Juni 2026</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center">880</td><td class="py-2 px-3 text-center">150</td><td class="py-2 px-3 text-center">80</td><td class="py-2 px-3 text-right font-bold">950</td></tr>
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
                                    <th class="py-2.5 px-3">Ref DO/TRX</th>
                                    <th class="py-2.5 px-3">Tujuan/Pelanggan</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Qty Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-mono">DO-2026-092</td><td class="py-2 px-3">Toko Makmur Sejahtera</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center font-bold text-red-500">150 Pcs</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'qty-produk-keluar') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Total Keluar</th>
                                    <th class="py-2.5 px-3 text-right">Rata-rata / Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center font-bold">1.820 Galon</td><td class="py-2 px-3 text-right">60 Galon</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'sisa-stok') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3">Gudang</th>
                                    <th class="py-2.5 px-3 text-center">Sisa Qty</th>
                                    <th class="py-2.5 px-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${products.map(p => `
                                    <tr class="border-b border-cream/50">
                                        <td class="py-2 px-3 font-mono">${p.sku}</td>
                                        <td class="py-2 px-3 font-bold">${p.name}</td>
                                        <td class="py-2 px-3">Gudang Utama</td>
                                        <td class="py-2 px-3 text-center font-extrabold">${p.stock['Gudang Utama']} ${p.unit}</td>
                                        <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Tersedia</span></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'sisa-stok-grup') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Total Item SKU</th>
                                    <th class="py-2.5 px-3 text-center">Total Qty Tersisa</th>
                                    <th class="py-2.5 px-3 text-right">Valuation HPP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Galon</td><td class="py-2 px-3 text-center">1</td><td class="py-2 px-3 text-center">852 Galon</td><td class="py-2 px-3 text-right font-bold">Rp 6.816.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Botol</td><td class="py-2 px-3 text-center">2</td><td class="py-2 px-3 text-center">255 Box</td><td class="py-2 px-3 text-right font-bold">Rp 6.980.000</td></tr>
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
            // Ensure dynamically injected tables are horizontally scrollable
            // and have a minimum width for consistent responsive behavior.
            try {
                container.querySelectorAll('table').forEach(t => {
                    if (!/min-w-\[/.test(t.className)) t.classList.add('min-w-[640px]');
                });
            } catch (e) {
                // silent fallback if DOM operations fail
                console.warn('loadReport: could not normalize table widths', e);
            }
            lucide.createIcons();
        }

        // NOTIFICATIONS
        function showNotificationCenter() {
            Swal.fire({
                title: 'Pemberitahuan Sistem 🔔',
                html: `
                    <div class="text-left space-y-2 text-xs">
                        <div class="p-2.5 bg-red-50 border-l-4 border-red-500 rounded">
                            <span class="font-bold">Stok Kritis:</span> Galon Elangwater 19L sisa 2 pcs di Depo Elang Utara.
                        </div>
                        <div class="p-2.5 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                            <span class="font-bold">Tagihan Overdue:</span> Toko Makmur Sejahtera (Rp 4.500.000) jatuh tempo.
                        </div>
                        <div class="p-2.5 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <span class="font-bold">Transfer Pending:</span> 1 mutasi antar gudang menunggu persetujuan.
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false
            });
        }

        // CHARTS INITIALIZATION
        let salesChartRef, reportSalesChartRef, reportPurchaseChartRef;

        function initCharts() {
            // Main Dashboard Sales Tren
            const ctx1 = document.getElementById('salesChart').getContext('2d');
            salesChartRef = new Chart(ctx1, {
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

            // Laporan Sales Tren
            const ctx2 = document.getElementById('reportSalesChart').getContext('2d');
            reportSalesChartRef = new Chart(ctx2, {
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

            // Laporan Purchases
            const ctx3 = document.getElementById('reportPurchaseChart').getContext('2d');
            reportPurchaseChartRef = new Chart(ctx3, {
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
    </script>
</body>
</html>
<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-10 md:hidden" onclick="closeMobileSidebar()"></div>

<!-- Sidebar Navigation -->
<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-cream-dark flex flex-col justify-between overflow-y-auto transform -translate-x-full transition-transform duration-300 md:static md:translate-x-0 md:w-64 md:h-full shrink-0">
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
        <p class="text-xs font-semibold text-zinc-600">Elang Water POS v1.0</p>
        <p class="text-[10px] text-zinc-400 mt-0.5">© 2026 PT Elang Air Persada</p>
    </div>
</aside>

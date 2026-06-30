<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-10 md:hidden" onclick="closeMobileSidebar()"></div>

<!-- Sidebar Navigation -->
<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-cream-dark flex flex-col justify-between overflow-y-auto transform -translate-x-full transition-transform duration-300 md:static md:translate-x-0 md:w-64 md:h-full shrink-0">
    <!-- Navigation Items -->
    <nav class="p-4 space-y-1.5" id="main-navigation">
        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 mb-2">Utama</p>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" id="nav-dashboard" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('dashboard') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="reports.view">
            <span class="flex items-center gap-3">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Dashboard</span>
            </span>
        </a>

        <!-- POS -->
        <a href="{{ route('pos') }}" id="nav-pos" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('pos') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="pos.access">
            <span class="flex items-center gap-3">
                <i data-lucide="shopping-cart" class="w-4 h-4 text-primary-dark"></i>
                <span class="font-bold">POS / Kasir</span>
            </span>
            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs bg-red-100 text-red-600 rounded font-bold">Live</span>
        </a>

        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 pt-4 mb-2">Manajemen Data</p>

        <!-- Master Data Menu -->
        <div>
            <button onclick="toggleSubmenu('submenu-master')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('master.*') ? 'bg-cream text-zinc-900 font-bold' : 'text-zinc-700' }}" data-permission="products.index">
                <span class="flex items-center gap-3">
                    <i data-lucide="database" class="w-4 h-4"></i>
                    <span>Master Data</span>
                </span>
                <i data-lucide="chevron-down" id="arrow-master" class="w-4 h-4 transition-transform duration-200" style="{{ request()->routeIs('master.*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </button>
            <div id="submenu-master" class="{{ request()->routeIs('master.*') ? '' : 'hidden' }} pl-8 pr-2 py-1 space-y-1">
                <a href="{{ route('master.produk') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('master.produk') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="products.index">Produk (SKU/Barcode)</a>
                <a href="{{ route('master.harga') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('master.harga') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="products.index">Skema Harga</a>
                <a href="{{ route('master.kategori') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('master.kategori') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="categories.index">Kategori</a>
                <a href="{{ route('master.brand') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('master.brand') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="brands.index">Brand</a>
                <a href="{{ route('master.satuan') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('master.satuan') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="units.index">Satuan</a>
            </div>
        </div>

        <!-- Inventori Menu -->
        <div>
            <button onclick="toggleSubmenu('submenu-inventori')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('inventori.*') ? 'bg-cream text-zinc-900 font-bold' : 'text-zinc-700' }}" data-permission="product-stocks.index">
                <span class="flex items-center gap-3">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span>Inventori / Stok</span>
                </span>
                <i data-lucide="chevron-down" id="arrow-inventori" class="w-4 h-4 transition-transform duration-200" style="{{ request()->routeIs('inventori.*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </button>
            <div id="submenu-inventori" class="{{ request()->routeIs('inventori.*') ? '' : 'hidden' }} pl-8 pr-2 py-1 space-y-1">
                <a href="{{ route('inventori.gudang') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.gudang') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="warehouses.index">Multi Gudang</a>
                <a href="{{ route('inventori.stok') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.stok') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="product-stocks.index">Stok Real Time</a>
                <a href="{{ route('inventori.masuk') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.masuk') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="purchases.receive">Barang Masuk</a>
                <a href="{{ route('inventori.keluar') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.keluar') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="sales.index">Barang Keluar</a>
                <a href="{{ route('inventori.transfer') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.transfer') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="transfers.index">Transfer Gudang</a>
                <a href="{{ route('inventori.opname') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.opname') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="stock-mutations.index">Stock Opname</a>
                <a href="{{ route('inventori.kartu-stok') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('inventori.kartu-stok') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="product-stocks.index">Kartu Stok</a>
            </div>
        </div>

        <!-- Pelanggan Menu -->
        <a href="{{ route('pelanggan') }}" id="nav-pelanggan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('pelanggan') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="customers.index">
            <span class="flex items-center gap-3">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Pelanggan</span>
            </span>
        </a>

        <!-- Supplier Menu -->
        <a href="{{ route('supplier') }}" id="nav-supplier" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('supplier') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="suppliers.index">
            <span class="flex items-center gap-3">
                <i data-lucide="truck" class="w-4 h-4"></i>
                <span>Supplier</span>
            </span>
        </a>

        <!-- Pembelian Menu -->
        <div>
            <button onclick="toggleSubmenu('submenu-pembelian')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('pembelian.*') ? 'bg-cream text-zinc-900 font-bold' : 'text-zinc-700' }}" data-permission="purchases.index">
                <span class="flex items-center gap-3">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    <span>Pembelian (PO)</span>
                </span>
                <i data-lucide="chevron-down" id="arrow-pembelian" class="w-4 h-4 transition-transform duration-200" style="{{ request()->routeIs('pembelian.*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </button>
            <div id="submenu-pembelian" class="{{ request()->routeIs('pembelian.*') ? '' : 'hidden' }} pl-8 pr-2 py-1 space-y-1">
                <a href="{{ route('pembelian.po') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('pembelian.po') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="purchases.create">Pre-Order & Receive</a>
                <a href="{{ route('pembelian.retur') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('pembelian.retur') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="purchases.delete">Retur Pembelian</a>
            </div>
        </div>

        <!-- Distribusi Menu -->
        <div>
            <button onclick="toggleSubmenu('submenu-distribusi')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('distribusi.*') ? 'bg-cream text-zinc-900 font-bold' : 'text-zinc-700' }}" data-permission="sales.index">
                <span class="flex items-center gap-3">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <span>Distribusi & DO</span>
                </span>
                <i data-lucide="chevron-down" id="arrow-distribusi" class="w-4 h-4 transition-transform duration-200" style="{{ request()->routeIs('distribusi.*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </button>
            <div id="submenu-distribusi" class="{{ request()->routeIs('distribusi.*') ? '' : 'hidden' }} pl-8 pr-2 py-1 space-y-1">
                <a href="{{ route('distribusi.do') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('distribusi.do') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="sales.create">Delivery Order</a>
                <a href="{{ route('distribusi.bukti') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('distribusi.bukti') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="sales.index">Bukti Kirim</a>
            </div>
        </div>

        <!-- Keuangan Menu -->
        <div>
            <button onclick="toggleSubmenu('submenu-keuangan')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('keuangan.*') ? 'bg-cream text-zinc-900 font-bold' : 'text-zinc-700' }}" data-permission="cash-transactions.index">
                <span class="flex items-center gap-3">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span>Keuangan / Kas</span>
                </span>
                <i data-lucide="chevron-down" id="arrow-keuangan" class="w-4 h-4 transition-transform duration-200" style="{{ request()->routeIs('keuangan.*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </button>
            <div id="submenu-keuangan" class="{{ request()->routeIs('keuangan.*') ? '' : 'hidden' }} pl-8 pr-2 py-1 space-y-1">
                <a href="{{ route('keuangan.kas') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('keuangan.kas') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="cash-transactions.index">Kas Masuk & Keluar</a>
                <a href="{{ route('keuangan.tagihan') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('keuangan.tagihan') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="cash-transactions.index">Pembayaran Tagihan</a>
                <a href="{{ route('keuangan.hutang') }}" class="block px-2.5 py-1 text-xs font-medium rounded-lg {{ request()->routeIs('keuangan.hutang') ? 'text-primary-dark font-bold bg-primary/10' : 'text-zinc-600 hover:text-zinc-900 hover:bg-cream/40' }}" data-permission="cash-transactions.index">Pembayaran Hutang</a>
            </div>
        </div>

        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-3 pt-4 mb-2">Analisa & Konfigurasi</p>

        <!-- Laporan -->
        <a href="{{ route('laporan') }}" id="nav-laporan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('laporan') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="reports.view">
            <span class="flex items-center gap-3">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                <span>Laporan Analitis</span>
            </span>
        </a>

        <!-- Sistem -->
        <a href="{{ route('sistem') }}" id="nav-sistem" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream hover:text-zinc-900 active:scale-95 {{ request()->routeIs('sistem') ? 'bg-primary text-zinc-900 shadow-sm border border-primary/20' : 'text-zinc-700' }}" data-permission="settings.view" data-role="superadmin">
            <span class="flex items-center gap-3">
                <i data-lucide="settings" class="w-4 h-4"></i>
                <span>Pengaturan Sistem</span>
            </span>
        </a>
    </nav>

    <!-- Bottom Brand Info -->
    <div class="p-4 border-t border-cream-dark bg-cream/50 text-center">
        <p class="text-xs font-semibold text-zinc-600">Elang Water POS v1.0</p>
        <p class="text-[10px] text-zinc-400 mt-0.5">© 2026 PT Elang Air Persada</p>
    </div>
</aside>

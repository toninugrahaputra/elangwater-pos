<!-- SECTION 2: MASTER DATA - PRODUK -->
<div id="section-master-produk" class="space-y-6 hidden" data-permission="products.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Data Produk & SKU</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola barang dagangan, barcode, satuan, dan skema harga dasar.</p>
        </div>
        <button onclick="openAddProductModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2 shadow-sm transition-all hover:scale-105 active:scale-95" data-permission="products.create">
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
<div id="section-master-harga" class="space-y-6 hidden" data-permission="products.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Skema Level Harga</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Atur skema penentuan harga bertingkat untuk Retail, Agen, and Distributor.</p>
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
            <button onclick="Swal.fire('Berhasil', 'Konfigurasi Level Skema Harga Berhasil Diperbarui!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-6 py-2.5 rounded-xl text-xs transition-colors" data-permission="products.edit">
                Simpan Perubahan Skema
            </button>
        </div>
    </div>
</div>

<!-- SECTION 2.3: MASTER KATEGORI -->
<div id="section-master-kategori" class="space-y-6 hidden" data-permission="categories.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Kategori Produk</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Klasifikasikan produk Anda untuk memudahkan pencarian dan filter kasir.</p>
        </div>
        <button onclick="addNewCategory()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="categories.create">
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
<div id="section-master-brand" class="space-y-6 hidden" data-permission="brands.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Brand / Merek</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola brand produk air yang didistribusikan.</p>
        </div>
        <button onclick="addNewBrand()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="brands.create">
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
<div id="section-master-satuan" class="space-y-6 hidden" data-permission="units.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Satuan Ukuran</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola satuan kemasan/volume (Pcs, Box, Galon, Kardus, Liter, ml).</p>
        </div>
        <button onclick="addNewUnit()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="units.create">
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

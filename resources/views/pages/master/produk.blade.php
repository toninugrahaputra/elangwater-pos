@extends('layouts.app')

@section('content')
<!-- SECTION 2: MASTER DATA - PRODUK -->
<div id="section-master-produk" class="space-y-6" data-permission="products.index">
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
@endsection

@push('scripts')
<script>
    // Product Page Specific Scripts
    function openAddProductModal() {
        const modal = document.getElementById('add-product-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeAddProductModal() {
        const modal = document.getElementById('add-product-modal');
        if (modal) modal.classList.add('hidden');
    }

    function renderProducts() {
        let table = document.getElementById('master-produk-table-body');
        if (!table) return;
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

    function deleteProduct(id) {
        products = products.filter(p => p.id !== id);
        renderProducts();
        populateSelects();
    }

    function filterProducts() {
        let q = document.getElementById('prod-search-input').value.toLowerCase();
        let cat = document.getElementById('prod-filter-category').value;
        let rows = document.querySelectorAll('#master-produk-table-body tr');

        rows.forEach(row => {
            let info = row.cells[0].innerText.toLowerCase();
            let sku = row.cells[1].innerText.toLowerCase();
            let category = row.cells[2].innerText;

            let matchesSearch = info.includes(q) || sku.includes(q);
            let matchesCategory = cat === '' || category === cat;

            if (matchesSearch && matchesCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function pageInit() {
        renderProducts();
    }
</script>
@endpush

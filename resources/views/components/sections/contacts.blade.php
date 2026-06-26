<!-- SECTION 4: PELANGGAN -->
<div id="section-pelanggan" class="space-y-6 hidden" data-permission="customers.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Pelanggan</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola data pelanggan Retail, Agen, Distributor, Toko, dan Kantor.</p>
        </div>
        <button onclick="openAddCustomerModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="customers.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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
<div id="section-supplier" class="space-y-6 hidden" data-permission="suppliers.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Supplier / Vendor</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Daftar pabrik kemasan, distributor galon kosong, atau vendor operasional.</p>
        </div>
        <button onclick="openAddSupplierModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="suppliers.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Supplier
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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

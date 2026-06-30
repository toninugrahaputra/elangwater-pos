@extends('layouts.app')

@section('content')
<!-- SECTION 3.7: KARTU STOK -->
<div id="section-inv-kartustok" class="space-y-6" data-permission="product-stocks.index">
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
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">Tanggal & Jam</th>
                        <th class="py-3 px-4">Gudang</th>
                        <th class="py-3 px-4">SKU / Nama Produk</th>
                        <th class="py-3 px-4">Keterangan Aktivitas</th>
                        <th class="py-3 px-4 text-center">Masuk (+)</th>
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
@endsection

@push('scripts')
<script>
    function filterKartuStok() {
        let sku = document.getElementById('kartu-stok-sku-filter').value;
        let wh = document.getElementById('kartu-stok-gudang-filter').value;
        Swal.fire('Filter Berhasil', `Memfilter log pergerakan stok untuk SKU: ${sku || 'Semua'} di ${wh || 'Semua Gudang'}`, 'info');
    }

    function pageInit() {
        // Kartu stok select initialization
        let skuSelect = document.getElementById('kartu-stok-sku-filter');
        if (skuSelect) {
            skuSelect.innerHTML = '<option value="">Pilih SKU Produk</option>';
            products.forEach(p => {
                skuSelect.innerHTML += `<option value="${p.sku}">${p.name} (${p.sku})</option>`;
            });
        }
    }
</script>
@endpush

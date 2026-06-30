@extends('layouts.app')

@section('content')
<!-- SECTION 3.2: STOK REAL TIME -->
<div id="section-inv-stok" class="space-y-6" data-permission="product-stocks.index">
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
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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
@endsection

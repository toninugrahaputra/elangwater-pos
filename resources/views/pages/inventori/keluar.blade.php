@extends('layouts.app')

@section('content')
<!-- SECTION 3.4: INVENTORI - BARANG KELUAR -->
<div id="section-inv-keluar" class="space-y-6" data-permission="stock-mutations.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Barang Keluar</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Catatan barang keluar karena transaksi Penjualan POS maupun Mutasi Gudang.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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
@endsection

@extends('layouts.app')

@section('content')
<!-- SECTION 3.5: INVENTORI - TRANSFER GUDANG -->
<div id="section-inv-transfer" class="space-y-6" data-permission="transfers.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Transfer & Mutasi Antar Gudang</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kirim persediaan dari satu gudang ke gudang cabang/depo lainnya.</p>
        </div>
        <button onclick="openTransferModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="transfers.create">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Buat Transfer Baru
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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
@endsection

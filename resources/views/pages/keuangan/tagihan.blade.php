@extends('layouts.app')

@section('content')
<!-- SECTION 9.2: KEUANGAN - PEMBAYARAN TAGIHAN -->
<div id="section-keu-tagihan" class="space-y-6" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Tagihan (Piutang)</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi dan pelunasan piutang outlet/distributor air.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
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
@endsection

@push('scripts')
<script>
    function renderKeuanganTagihan() {
        let table = document.getElementById('keu-tagihan-table-body');
        if (!table) return;
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
                c.debt = 0;
                renderKeuanganTagihan();
                Swal.fire('Lunas', 'Piutang customer berhasil dinolkan dan tercatat di kas masuk!', 'success');
            }
        });
    }

    function pageInit() {
        renderKeuanganTagihan();
    }
</script>
@endpush

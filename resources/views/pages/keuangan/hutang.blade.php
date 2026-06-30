@extends('layouts.app')

@section('content')
<!-- SECTION 9.3: KEUANGAN - PEMBAYARAN HUTANG -->
<div id="section-keu-hutang" class="space-y-6" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pembayaran Hutang ke Supplier</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Konfirmasi transfer pelunasan belanja stok bahan baku kepada supplier.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. PO Referensi</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Total Hutang</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status Hutang</th>
                        <th class="py-3 px-4 text-right">Aksi Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="keu-hutang-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renderKeuanganHutang() {
        let table = document.getElementById('keu-hutang-table-body');
        if (!table) return;
        table.innerHTML = '';
        suppliers.forEach((s, idx) => {
            if (s.debt > 0) {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">PO-REF-00${idx}</td>
                        <td class="py-3 px-4 font-semibold">${s.name}</td>
                        <td class="py-3 px-4 font-black text-red-500">Rp ${s.debt.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4 text-zinc-500">28 Juni 2026</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold text-[10px]">Outstanding</span></td>
                        <td class="py-3 px-4 text-right">
                            <button onclick="payHutangSim(${idx})" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Bayar Hutang</button>
                        </td>
                    </tr>
                `;
            }
        });
    }

    function payHutangSim(supIdx) {
        let s = suppliers[supIdx];
        Swal.fire({
            title: 'Konfirmasi Pembayaran Hutang',
            text: `Apakah Anda ingin melunasi hutang ke ${s.name} sebesar Rp ${s.debt.toLocaleString('id-ID')}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar'
        }).then(res => {
            if (res.isConfirmed) {
                s.debt = 0;
                renderKeuanganHutang();
                Swal.fire('Lunas', 'Hutang supplier berhasil dilunasi!', 'success');
            }
        });
    }

    function pageInit() {
        renderKeuanganHutang();
    }
</script>
@endpush

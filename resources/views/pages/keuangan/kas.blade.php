@extends('layouts.app')

@section('content')
<!-- SECTION 9: KEUANGAN - KAS MASUK KELUAR -->
<div id="section-keu-kas" class="space-y-6" data-permission="cash-transactions.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Kas & Jurnal Keuangan</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Log arus uang tunai and bank (Pemasukan, Pengeluaran Operasional).</p>
        </div>
        <button onclick="openCashFlowModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="cash-transactions.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Catat Kas Masuk/Keluar
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. Jurnal</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Jenis</th>
                        <th class="py-3 px-4">Kategori Jurnal</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="keu-kas-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cashFlow = [
        { journalNo: 'JRN-2026-045', date: '2026-06-23', type: 'Masuk', category: 'Penjualan POS', remark: 'Penjualan POS Cash Shift Pagi', amount: 3500000 },
        { journalNo: 'JRN-2026-046', date: '2026-06-23', type: 'Keluar', category: 'Operasional', remark: 'Beli Bensin Delivery Truck', amount: 250000 }
    ];

    function renderKeuanganKas() {
        let table = document.getElementById('keu-kas-table-body');
        if (!table) return;
        table.innerHTML = '';
        cashFlow.forEach(j => {
            let badgeClass = j.type === 'Masuk' ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50';
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${j.journalNo}</td>
                    <td class="py-3 px-4 text-zinc-500">${j.date}</td>
                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-bold text-[10px] ${badgeClass}">${j.type}</span></td>
                    <td class="py-3 px-4 font-semibold">${j.category}</td>
                    <td class="py-3 px-4 text-zinc-600">${j.remark}</td>
                    <td class="py-3 px-4 text-right font-black ${j.type === 'Masuk' ? 'text-green-600' : 'text-red-500'}">
                        Rp ${j.amount.toLocaleString('id-ID')}
                    </td>
                </tr>
            `;
        });
    }

    function openCashFlowModal() {
        Swal.fire({
            title: 'Catat Kas Arus Keuangan',
            html: `
                <select id="cash-type" class="swal2-input">
                    <option value="Masuk">Kas Masuk (Pemasukan)</option>
                    <option value="Keluar">Kas Keluar (Pengeluaran)</option>
                </select>
                <input id="cash-cat" class="swal2-input" placeholder="Kategori Kas (e.g. Listrik, Operasional, POS)">
                <input id="cash-desc" class="swal2-input" placeholder="Keterangan Rinci">
                <input id="cash-amt" class="swal2-input" type="number" placeholder="Jumlah Rupiah">
            `,
            preConfirm: () => {
                return {
                    type: document.getElementById('cash-type').value,
                    category: document.getElementById('cash-cat').value,
                    remark: document.getElementById('cash-desc').value,
                    amount: parseInt(document.getElementById('cash-amt').value)
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                cashFlow.unshift({
                    journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                    date: new Date().toISOString().slice(0, 10),
                    type: res.value.type,
                    category: res.value.category,
                    remark: res.value.remark,
                    amount: res.value.amount
                });
                renderKeuanganKas();
                Swal.fire('Tercatat', 'Arus kas berhasil dibukukan!', 'success');
            }
        });
    }

    function pageInit() {
        renderKeuanganKas();
    }
</script>
@endpush

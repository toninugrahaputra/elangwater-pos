@extends('layouts.app')

@section('content')
<!-- SECTION 6.2: RETUR PEMBELIAN -->
<div id="section-po-retur" class="space-y-6" data-permission="purchases.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Retur Pembelian</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola pengembalian barang rusak (bocor, penyok) ke Supplier.</p>
        </div>
        <button onclick="openReturPembelianModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="purchases.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat Retur Pembelian
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. Retur</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Detail Barang</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="po-retur-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let returs = [
        { code: 'RT-001', supplier: 'PT Kemasan Plastik Indonesia', date: '2026-06-22', item: 'Botol Kosong 600ml (50 Pcs)', remark: 'Botol bocor/cacat pabrik', status: 'Approved' }
    ];

    function renderReturs() {
        let table = document.getElementById('po-retur-table-body');
        if (!table) return;
        table.innerHTML = '';
        returs.forEach(r => {
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${r.code}</td>
                    <td class="py-3 px-4 font-semibold">${r.supplier}</td>
                    <td class="py-3 px-4 text-zinc-500">${r.date}</td>
                    <td class="py-3 px-4 text-zinc-600">${r.item}</td>
                    <td class="py-3 px-4 text-zinc-500">${r.remark}</td>
                    <td class="py-3 px-4 text-right"><span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800">${r.status}</span></td>
                </tr>
            `;
        });
    }

    function openReturPembelianModal() {
        Swal.fire({
            title: 'Buat Retur Pembelian',
            html: `
                <select id="retur-supp" class="swal2-input">
                    ${suppliers.map(s => `<option>${s.name}</option>`).join('')}
                </select>
                <input id="retur-item" class="swal2-input" placeholder="Barang yang Diretur (e.g. 50 Pcs Botol Kosong)">
                <input id="retur-remark" class="swal2-input" placeholder="Keterangan Kerusakan">
            `,
            preConfirm: () => {
                return {
                    supplier: document.getElementById('retur-supp').value,
                    item: document.getElementById('retur-item').value,
                    remark: document.getElementById('retur-remark').value
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                returs.unshift({
                    code: 'RT-00' + (1 + returs.length),
                    supplier: res.value.supplier,
                    date: new Date().toISOString().slice(0, 10),
                    item: res.value.item,
                    remark: res.value.remark,
                    status: 'Approved'
                });
                renderReturs();
                Swal.fire('Retur Diajukan', 'Pengajuan retur berhasil dicatat!', 'success');
            }
        });
    }

    function pageInit() {
        renderReturs();
    }
</script>
@endpush

@extends('layouts.app')

@section('content')
<!-- SECTION 6: PEMBELIAN (Pre-Order / PO) -->
<div id="section-po-buat" class="space-y-6" data-permission="purchases.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pre-Order Pembelian & Receive Barang</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola PO barang ke supplier, persetujuan admin, dan pencatatan penerimaan gudang.</p>
        </div>
        <button onclick="openPOModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="purchases.create">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i> Buat Pre-Order
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. PO</th>
                        <th class="py-3 px-4">Supplier</th>
                        <th class="py-3 px-4">Tanggal PO</th>
                        <th class="py-3 px-4">Item & Qty</th>
                        <th class="py-3 px-4">Total Biaya</th>
                        <th class="py-3 px-4">Status PO</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="po-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let purchasing = [
        { poNo: 'PO-2026-012', supplier: 'PT Kemasan Plastik Indonesia', date: '2026-06-21', item: 'Botol Kosong 600ml (10.000 Pcs)', totalCost: 15000000, status: 'Received' },
        { poNo: 'PO-2026-013', supplier: 'CV Sumber Mata Air Pegunungan', date: '2026-06-23', item: 'Pasokan Air Tangki 10.000L (2 Tangki)', totalCost: 4000000, status: 'Approved' }
    ];

    function renderPembelian() {
        let table = document.getElementById('po-table-body');
        if (!table) return;
        table.innerHTML = '';
        purchasing.forEach((po, idx) => {
            let badgeClass = po.status === 'Received' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${po.poNo}</td>
                    <td class="py-3 px-4 font-semibold">${po.supplier}</td>
                    <td class="py-3 px-4 text-zinc-500">${po.date}</td>
                    <td class="py-3 px-4 text-zinc-600">${po.item}</td>
                    <td class="py-3 px-4 font-extrabold">Rp ${po.totalCost.toLocaleString('id-ID')}</td>
                    <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${badgeClass}">${po.status}</span></td>
                    <td class="py-3 px-4 text-right">
                        ${po.status === 'Approved' ? `<button onclick="receiveGoodsSim('${po.poNo}')" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Receive Barang</button>` : '<span class="text-zinc-400">Received</span>'}
                    </td>
                </tr>
            `;
        });
    }

    function openPOModal() {
        Swal.fire({
            title: 'Buat Pre-Order Pembelian',
            html: `
                <select id="po-supp" class="swal2-input">
                    ${suppliers.map(s => `<option>${s.name}</option>`).join('')}
                </select>
                <input id="po-item" class="swal2-input" placeholder="Item / Deskripsi (e.g. 5.000 Pcs Tutup Galon)">
                <input id="po-cost" class="swal2-input" type="number" placeholder="Estimasi Total Biaya (Rupiah)">
            `,
            preConfirm: () => {
                return {
                    supplier: document.getElementById('po-supp').value,
                    item: document.getElementById('po-item').value,
                    cost: parseInt(document.getElementById('po-cost').value)
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                purchasing.unshift({
                    poNo: 'PO-2026-0' + (14 + purchasing.length),
                    supplier: res.value.supplier,
                    date: new Date().toISOString().slice(0, 10),
                    item: res.value.item,
                    totalCost: res.value.cost,
                    status: 'Approved'
                });
                renderPembelian();
                Swal.fire('PO Diajukan', 'PO berhasil dibuat & menunggu barang datang dari supplier!', 'success');
            }
        });
    }

    function receiveGoodsSim(poNo) {
        let po = purchasing.find(p => p.poNo === poNo);
        po.status = 'Received';
        renderPembelian();

        // Add to debts
        let sup = suppliers.find(s => s.name === po.supplier);
        if (sup) sup.debt += po.totalCost;

        Swal.fire('Barang Diterima', 'Persediaan gudang ter-update dan hutang outstanding supplier dicatat!', 'success');
    }

    function pageInit() {
        renderPembelian();
    }
</script>
@endpush

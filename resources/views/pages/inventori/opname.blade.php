@extends('layouts.app')

@section('content')
<!-- SECTION 3.6: STOCK OPNAME -->
<div id="section-inv-opname" class="space-y-6" data-permission="stock-mutations.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Stock Opname</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Penyesuaian stok berkala antara stok fisik di gudang dengan catatan di sistem.</p>
        </div>
        <button onclick="openOpnameModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="stock-mutations.create">
            <i data-lucide="clipboard-list" class="w-4 h-4"></i> Buat Stock Opname
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">No. Opname</th>
                        <th class="py-3 px-4">Gudang</th>
                        <th class="py-3 px-4">Item</th>
                        <th class="py-3 px-4 text-center">Stok Buku</th>
                        <th class="py-3 px-4 text-center">Stok Fisik</th>
                        <th class="py-3 px-4 text-center">Selisih</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Status Approval</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="opname-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let opnames = [
        { code: 'OP-005', warehouse: 'Gudang Utama', item: 'Gelas Elangwater 240ml', bookStock: 15, physicalStock: 15, diff: 0, remark: 'Stok Sesuai', status: 'Approved' }
    ];

    function renderOpnameTable() {
        let table = document.getElementById('opname-table-body');
        if (!table) return;
        table.innerHTML = '';
        opnames.forEach(op => {
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${op.code}</td>
                    <td class="py-3 px-4">${op.warehouse}</td>
                    <td class="py-3 px-4 font-semibold">${op.item}</td>
                    <td class="py-3 px-4 text-center font-semibold text-zinc-500">${op.bookStock}</td>
                    <td class="py-3 px-4 text-center font-bold text-zinc-950">${op.physicalStock}</td>
                    <td class="py-3 px-4 text-center font-bold ${op.diff === 0 ? 'text-green-600' : 'text-red-500'}">${op.diff}</td>
                    <td class="py-3 px-4 text-zinc-500">${op.remark}</td>
                    <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">${op.status}</span></td>
                </tr>
            `;
        });
    }

    function openOpnameModal() {
        Swal.fire({
            title: 'Buat Opname Gudang',
            html: `
                <select id="opname-wh" class="swal2-input">
                    <option>Gudang Utama</option>
                    <option>Depo Elang Utara</option>
                </select>
                <select id="opname-prod" class="swal2-input">
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
                <input id="opname-phys" class="swal2-input" type="number" placeholder="Jumlah Fisik Aktual">
                <input id="opname-desc" class="swal2-input" type="text" placeholder="Keterangan / Alasan Selisih">
            `,
            preConfirm: () => {
                return {
                    wh: document.getElementById('opname-wh').value,
                    prodId: document.getElementById('opname-prod').value,
                    phys: parseInt(document.getElementById('opname-phys').value),
                    desc: document.getElementById('opname-desc').value
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let val = result.value;
                let p = products.find(prod => prod.id == val.prodId);
                let bookVal = p.stock[val.wh] || 0;
                let diff = val.phys - bookVal;

                opnames.unshift({
                    code: 'OP-00' + (6 + opnames.length),
                    warehouse: val.wh,
                    item: p.name,
                    bookStock: bookVal,
                    physicalStock: val.phys,
                    diff: diff,
                    remark: val.desc || 'Stock Opname Bulanan',
                    status: 'Approved'
                });

                // Update stock
                p.stock[val.wh] = val.phys;

                renderOpnameTable();
                Swal.fire('Opname Berhasil', 'Stok buku telah disesuaikan dengan stok fisik!', 'success');
            }
        });
    }

    function pageInit() {
        renderOpnameTable();
    }
</script>
@endpush

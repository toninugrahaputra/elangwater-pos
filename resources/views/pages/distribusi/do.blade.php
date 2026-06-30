@extends('layouts.app')

@section('content')
<!-- SECTION 8: DISTRIBUSI & DO -->
<div id="section-dist-do" class="space-y-6" data-permission="sales.create">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Delivery Order (DO)</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Buat DO pengiriman, tunjuk driver, dan perbarui status logistik kiriman air.</p>
        </div>
        <button onclick="openDeliveryOrderModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="sales.create">
            <i data-lucide="plus" class="w-5 h-5"></i> Buat DO Baru
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-8 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-4 px-5">No. DO</th>
                        <th class="py-4 px-5">Customer</th>
                        <th class="py-4 px-5">Driver</th>
                        <th class="py-4 px-5">Item Pengiriman</th>
                        <th class="py-4 px-5">Status Pengiriman</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="do-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deliverOrders = [
        { doNo: 'DO-2026-092', customer: 'Toko Makmur Sejahtera', driver: 'Agus Delivery', items: 'Galon Elangwater 19L (150 Pcs)', status: 'Sedang Dikirim' },
        { doNo: 'DO-2026-091', customer: 'Budi Agen Air Lestari', driver: 'Rian Delivery', items: 'Botol Elangwater 600ml (20 Box)', status: 'Selesai' }
    ];

    function renderDO() {
        let table = document.getElementById('do-table-body');
        if (!table) return;
        table.innerHTML = '';
        deliverOrders.forEach((doItem, idx) => {
            let badgeClass = doItem.status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800';
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${doItem.doNo}</td>
                    <td class="py-3 px-4 font-semibold">${doItem.customer}</td>
                    <td class="py-3 px-4 text-zinc-600">${doItem.driver}</td>
                    <td class="py-3 px-4 text-zinc-500">${doItem.items}</td>
                    <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${badgeClass}">${doItem.status}</span></td>
                    <td class="py-3 px-4 text-right">
                        ${doItem.status === 'Sedang Dikirim' ? `<button onclick="updateDOStatus('${doItem.doNo}')" class="bg-primary text-[10px] font-bold px-2 py-1 rounded">Selesaikan</button>` : '<span class="text-zinc-400">Delivered</span>'}
                    </td>
                </tr>
            `;
        });
    }

    function openDeliveryOrderModal() {
        Swal.fire({
            title: 'Buat Delivery Order (DO)',
            html: `
                <select id="do-cust" class="swal2-input">
                    ${customers.map(c => `<option>${c.name}</option>`).join('')}
                </select>
                <select id="do-driver" class="swal2-input">
                    <option>Agus Delivery</option>
                    <option>Rian Delivery</option>
                </select>
                <input id="do-item" class="swal2-input" placeholder="Barang yang Dikirim (e.g. Galon 19L x50)">
            `,
            preConfirm: () => {
                return {
                    customer: document.getElementById('do-cust').value,
                    driver: document.getElementById('do-driver').value,
                    items: document.getElementById('do-item').value
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                deliverOrders.unshift({
                    doNo: 'DO-2026-0' + (93 + deliverOrders.length),
                    customer: res.value.customer,
                    driver: res.value.driver,
                    items: res.value.items,
                    status: 'Sedang Dikirim'
                });
                renderDO();
                Swal.fire('DO Berhasil', 'DO telah dibuat & siap dikirim oleh Driver!', 'success');
            }
        });
    }

    function updateDOStatus(doNo) {
        let doItem = deliverOrders.find(d => d.doNo === doNo);
        if (doItem) {
            doItem.status = 'Selesai';
            renderDO();
            Swal.fire('Selesai', 'Status pengiriman berhasil diselesaikan!', 'success');
        }
    }

    function pageInit() {
        renderDO();
    }
</script>
@endpush

@extends('layouts.app')

@section('content')
<!-- SECTION 4: PELANGGAN -->
<div id="section-pelanggan" class="space-y-6" data-permission="customers.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Pelanggan</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola data pelanggan Retail, Agen, Distributor, Toko, dan Kantor.</p>
        </div>
        <button onclick="openAddCustomerModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="customers.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">Nama Pelanggan</th>
                        <th class="py-3 px-4">Kategori Pelanggan</th>
                        <th class="py-3 px-4">No. Telp</th>
                        <th class="py-3 px-4">Alamat / Wilayah</th>
                        <th class="py-3 px-4">Total Belanja</th>
                        <th class="py-3 px-4">Tagihan Berjalan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="customer-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renderCustomers() {
        let table = document.getElementById('customer-table-body');
        if (!table) return;
        table.innerHTML = '';
        customers.forEach((c, idx) => {
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-bold">${c.name}</td>
                    <td class="py-3 px-4"><span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded font-semibold text-[10px]">${c.type}</span></td>
                    <td class="py-3 px-4 font-mono">${c.phone}</td>
                    <td class="py-3 px-4 text-zinc-500">${c.address}</td>
                    <td class="py-3 px-4 font-semibold">Rp ${c.spend.toLocaleString('id-ID')}</td>
                    <td class="py-3 px-4 font-bold ${c.debt > 0 ? 'text-red-500' : 'text-green-600'}">Rp ${c.debt.toLocaleString('id-ID')}</td>
                    <td class="py-3 px-4 text-right">
                        <button onclick="Swal.fire('Riwayat Belanja', 'Riwayat pembelian customer ini akan ditarik dari database di backend.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Riwayat</button>
                    </td>
                </tr>
            `;
        });
    }

    function openAddCustomerModal() {
        Swal.fire({
            title: 'Tambah Pelanggan Baru',
            html: `
                <input id="c-name" class="swal2-input" placeholder="Nama Pelanggan / Toko">
                <select id="c-type" class="swal2-input">
                    <option>Retail</option>
                    <option>Agen</option>
                    <option>Distributor</option>
                    <option>Toko</option>
                    <option>Kantor</option>
                </select>
                <input id="c-phone" class="swal2-input" placeholder="No. Telp">
                <input id="c-address" class="swal2-input" placeholder="Alamat / Wilayah">
            `,
            preConfirm: () => {
                return {
                    name: document.getElementById('c-name').value,
                    type: document.getElementById('c-type').value,
                    phone: document.getElementById('c-phone').value,
                    address: document.getElementById('c-address').value
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                customers.unshift({
                    name: res.value.name,
                    type: res.value.type,
                    phone: res.value.phone,
                    address: res.value.address,
                    spend: 0,
                    debt: 0
                });
                renderCustomers();
                Swal.fire('Berhasil', 'Pelanggan baru terdaftar!', 'success');
            }
        });
    }

    function pageInit() {
        renderCustomers();
    }
</script>
@endpush

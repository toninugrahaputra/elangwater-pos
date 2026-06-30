@extends('layouts.app')

@section('content')
<!-- SECTION 5: SUPPLIER -->
<div id="section-supplier" class="space-y-6" data-permission="suppliers.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Manajemen Supplier / Vendor</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Daftar pabrik kemasan, distributor galon kosong, atau vendor operasional.</p>
        </div>
        <button onclick="openAddSupplierModal()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="suppliers.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Supplier
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-3 px-4">Nama Supplier</th>
                        <th class="py-3 px-4">Narahubung</th>
                        <th class="py-3 px-4">No. Telp</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Total Transaksi</th>
                        <th class="py-3 px-4">Hutang Outstanding</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="supplier-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renderSuppliers() {
        let table = document.getElementById('supplier-table-body');
        if (!table) return;
        table.innerHTML = '';
        suppliers.forEach((s, idx) => {
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-bold">${s.name}</td>
                    <td class="py-3 px-4 font-semibold text-zinc-600">${s.contact}</td>
                    <td class="py-3 px-4 font-mono">${s.phone}</td>
                    <td class="py-3 px-4 text-zinc-500">${s.address}</td>
                    <td class="py-3 px-4 font-semibold">Rp ${s.spend.toLocaleString('id-ID')}</td>
                    <td class="py-3 px-4 font-bold text-red-500">Rp ${s.debt.toLocaleString('id-ID')}</td>
                    <td class="py-3 px-4 text-right">
                        <button onclick="Swal.fire('Riwayat Transaksi', 'Menampilkan invoice pembelian dari supplier.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Transaksi</button>
                    </td>
                </tr>
            `;
        });
    }

    function openAddSupplierModal() {
        Swal.fire({
            title: 'Tambah Supplier Baru',
            html: `
                <input id="s-name" class="swal2-input" placeholder="Nama Perusahaan Supplier">
                <input id="s-contact" class="swal2-input" placeholder="Nama Contact Person">
                <input id="s-phone" class="swal2-input" placeholder="No. Telp / HP">
                <input id="s-address" class="swal2-input" placeholder="Alamat Pabrik / Gudang">
            `,
            preConfirm: () => {
                return {
                    name: document.getElementById('s-name').value,
                    contact: document.getElementById('s-contact').value,
                    phone: document.getElementById('s-phone').value,
                    address: document.getElementById('s-address').value
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                suppliers.unshift({
                    name: res.value.name,
                    contact: res.value.contact,
                    phone: res.value.phone,
                    address: res.value.address,
                    spend: 0,
                    debt: 0
                });
                renderSuppliers();
                Swal.fire('Berhasil', 'Supplier baru berhasil dicatat!', 'success');
            }
        });
    }

    function pageInit() {
        renderSuppliers();
    }
</script>
@endpush

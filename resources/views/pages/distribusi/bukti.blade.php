@extends('layouts.app')

@section('content')
<!-- SECTION 8.2: BUKTI KIRIM -->
<div id="section-dist-bukti" class="space-y-6" data-permission="sales.index">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Bukti Kirim Delivery</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Upload dokumentasi foto pengantaran depo/outlet dan tandatangan digital customer.</p>
        </div>
    </div>
    <div class="bg-white border border-cream-dark rounded-2xl p-8 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/50">
                        <th class="py-4 px-5">No. DO</th>
                        <th class="py-4 px-5">Penerima</th>
                        <th class="py-4 px-5">Foto Dokumentasi</th>
                        <th class="py-4 px-5">Tanda Tangan Digital</th>
                        <th class="py-4 px-5">Tanggal Upload</th>
                        <th class="py-4 px-5 text-right">Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="bukti-kirim-table-body">
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

    function renderBuktiKirim() {
        let table = document.getElementById('bukti-kirim-table-body');
        if (!table) return;
        table.innerHTML = '';
        deliverOrders.forEach(d => {
            table.innerHTML += `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">${d.doNo}</td>
                    <td class="py-3 px-4 font-semibold">${d.customer}</td>
                    <td class="py-3 px-4">
                        ${d.status === 'Selesai' ? `<span class="text-green-600 font-bold flex items-center gap-1"><i data-lucide="image" class="w-4 h-4"></i> foto_depo_ok.jpg</span>` : '<span class="text-zinc-400">Belum Upload</span>'}
                    </td>
                    <td class="py-3 px-4">
                        ${d.status === 'Selesai' ? `<span class="text-green-600 font-bold flex items-center gap-1"><i data-lucide="edit-3" class="w-4 h-4"></i> digital_sign_ok</span>` : '<span class="text-zinc-400">Belum TTD</span>'}
                    </td>
                    <td class="py-3 px-4 text-zinc-500">${d.status === 'Selesai' ? '23 Juni 2026' : '-'}</td>
                    <td class="py-3 px-4 text-right">
                        ${d.status === 'Selesai' ? '<span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded font-bold">Verified</span>' : `<button onclick="uploadBuktiSim('${d.doNo}')" class="bg-primary text-[10px] font-bold px-2 py-1 rounded">Upload Bukti</button>`}
                    </td>
                </tr>
            `;
        });
        lucide.createIcons();
    }

    function uploadBuktiSim(doNo) {
        Swal.fire({
            title: 'Simulasi Upload Bukti Kirim',
            html: `
                <p class="text-xs text-zinc-500 mb-3">Simulasikan upload foto bukti kirim dan tanda tangan digital customer</p>
                <div class="border-2 border-dashed border-cream-dark p-6 rounded-lg text-center cursor-pointer mb-3">
                    <i data-lucide="camera" class="w-8 h-8 mx-auto text-zinc-400"></i>
                    <span class="text-[10px] font-bold text-zinc-500 block mt-2">PILIH FOTO OUTLET/DEPO</span>
                </div>
                <div class="border border-cream-dark p-4 rounded-lg bg-zinc-50">
                    <p class="text-[9px] text-zinc-400 mb-1">Canvas Tanda Tangan Customer</p>
                    <div class="h-16 bg-white border border-zinc-300 rounded flex items-center justify-center font-mono text-[10px] text-zinc-400">
                        [ Coretan Tanda Tangan ]
                    </div>
                </div>
            `,
            confirmButtonText: 'Simpan Bukti Pengiriman'
        }).then(() => {
            let doItem = deliverOrders.find(d => d.doNo === doNo);
            if (doItem) {
                doItem.status = 'Selesai';
                renderBuktiKirim();
                Swal.fire('Selesai', 'Bukti kirim berhasil diupload!', 'success');
            }
        });
    }

    function pageInit() {
        renderBuktiKirim();
    }
</script>
@endpush

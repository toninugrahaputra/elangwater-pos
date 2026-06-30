@extends('layouts.app')

@section('content')
<!-- SECTION 2.4: MASTER BRAND -->
<div id="section-master-brand" class="space-y-6" data-permission="brands.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Brand / Merek</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola brand produk air yang didistribusikan.</p>
        </div>
        <button onclick="addNewBrand()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-4 py-2 rounded-xl text-sm flex items-center gap-2" data-permission="brands.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Brand
        </button>
    </div>
    <div class="bg-white border border-cream-dark rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead>
                    <tr class="border-b border-cream-dark text-xs text-zinc-500 uppercase font-bold bg-cream/40">
                        <th class="py-3 px-4">Nama Brand</th>
                        <th class="py-3 px-4">Perusahaan Produsen</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-cream-dark" id="brand-table-body">
                    <!-- filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addNewBrand() {
        const modal = document.getElementById('add-brand-modal');
        if (modal) modal.classList.remove('hidden');
    }
</script>
@endpush

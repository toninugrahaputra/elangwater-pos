@extends('layouts.app')

@section('content')
<!-- SECTION 3: INVENTORI - GUDANG -->
<div id="section-inv-gudang" class="space-y-6" data-permission="warehouses.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Multi Gudang / Cabang Depo</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Pantau dan kelola multi gudang fisik penyimpanan air minum Anda.</p>
        </div>
        <button onclick="addNewWarehouse()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-5 py-3 rounded-2xl flex items-center gap-3" data-permission="warehouses.create">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Gudang Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="warehouse-grid">
        <!-- Loaded dynamically -->
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addNewWarehouse() {
        const modal = document.getElementById('add-warehouse-modal');
        if (modal) modal.classList.remove('hidden');
    }
</script>
@endpush

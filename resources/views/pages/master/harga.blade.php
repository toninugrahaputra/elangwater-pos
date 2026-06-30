@extends('layouts.app')

@section('content')
<!-- SECTION 2.2: MASTER HARGA (Skema Harga) -->
<div id="section-master-harga" class="space-y-6" data-permission="products.index">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Skema Level Harga</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Atur skema penentuan harga bertingkat untuk Retail, Agen, and Distributor.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-cream-dark space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Retail Pricing Rule -->
            <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold bg-green-100 text-green-800 px-2.5 py-1 rounded">Level 1: Retail</span>
                    <i data-lucide="user" class="w-5 h-5 text-green-700"></i>
                </div>
                <h3 class="font-bold text-sm">Pelanggan Umum & Eceran</h3>
                <p class="text-xs text-zinc-500">Harga standar penjualan kasir tanpa minimal pembelian. Margin rata-rata 25% - 30%.</p>
                <div class="pt-2">
                    <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                    <input type="number" value="30" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                </div>
            </div>

            <!-- Agen Pricing Rule -->
            <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold bg-blue-100 text-blue-800 px-2.5 py-1 rounded">Level 2: Agen</span>
                    <i data-lucide="store" class="w-5 h-5 text-blue-700"></i>
                </div>
                <h3 class="font-bold text-sm">Agen Resmi & Toko Kecil</h3>
                <p class="text-xs text-zinc-500">Diberikan pada agen yang terdaftar dengan minimal repeat order bulanan. Margin rata-rata 15% - 20%.</p>
                <div class="pt-2">
                    <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                    <input type="number" value="20" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                </div>
            </div>

            <!-- Distributor Pricing Rule -->
            <div class="border border-cream-dark p-5 rounded-xl bg-cream/30 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold bg-purple-100 text-purple-800 px-2.5 py-1 rounded">Level 3: Distributor</span>
                    <i data-lucide="truck" class="w-5 h-5 text-purple-700"></i>
                </div>
                <h3 class="font-bold text-sm">Grosir & Distributor Wilayah</h3>
                <p class="text-xs text-zinc-500">Harga terendah khusus pengiriman partai besar / kontainer ke depo. Margin rata-rata 5% - 10%.</p>
                <div class="pt-2">
                    <label class="text-[10px] font-bold text-zinc-400 block mb-1">Markup Default (%)</label>
                    <input type="number" value="8" class="bg-white border border-cream-dark rounded px-3 py-1.5 text-xs w-full font-bold focus:outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-cream-dark">
            <button onclick="Swal.fire('Berhasil', 'Konfigurasi Level Skema Harga Berhasil Diperbarui!', 'success')" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-6 py-2.5 rounded-xl text-xs transition-colors" data-permission="products.edit">
                Simpan Perubahan Skema
            </button>
        </div>
    </div>
</div>
@endsection

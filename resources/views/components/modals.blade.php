<!-- MODAL 1: CHECKOUT POS PAYMENT -->
<div id="payment-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <!-- Modal Header -->
        <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
            <span class="font-bold text-base flex items-center gap-2">
                <i data-lucide="check-square" class="w-5 h-5"></i> Selesaikan Transaksi Penjualan
            </span>
            <button onclick="closePaymentModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6 space-y-4">
            <div class="text-center bg-cream/50 p-4 rounded-xl border border-cream-dark">
                <span class="text-xs text-zinc-500 font-bold block uppercase">Total Tagihan Pembayaran</span>
                <h3 class="text-3xl font-black text-zinc-950 mt-1" id="payment-modal-total">Rp 0</h3>
            </div>

            <!-- Payment Method Select -->
            <div>
                <label class="text-xs font-bold text-zinc-500 block mb-1">Metode Pembayaran</label>
                <div class="grid grid-cols-4 gap-2">
                    <button onclick="selectPaymentMethod('Tunai')" id="pay-btn-Tunai" class="pay-method-btn py-3 border border-primary bg-primary-light text-zinc-900 rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                        <i data-lucide="banknote" class="w-5 h-5"></i> Tunai / Cash
                    </button>
                    <button onclick="selectPaymentMethod('Transfer')" id="pay-btn-Transfer" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                        <i data-lucide="send" class="w-5 h-5"></i> Bank Transfer
                    </button>
                    <button onclick="selectPaymentMethod('QRIS')" id="pay-btn-QRIS" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                        <i data-lucide="qr-code" class="w-5 h-5"></i> QRIS GPN
                    </button>
                    <button onclick="selectPaymentMethod('E-Wallet')" id="pay-btn-E-Wallet" class="pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all">
                        <i data-lucide="smartphone" class="w-5 h-5"></i> E-Wallet
                    </button>
                </div>
            </div>

            <!-- Cash input (Visible when Tunai is active) -->
            <div id="cash-input-group" class="space-y-3">
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="presetCashAmount(10000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">10.000</button>
                    <button onclick="presetCashAmount(50000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">50.000</button>
                    <button onclick="presetCashAmount(100000)" class="py-2 bg-cream hover:bg-cream-dark rounded-lg text-xs font-bold">100.000</button>
                </div>
                <div>
                    <label class="text-xs font-bold text-zinc-500 block mb-1">Nominal Uang Diterima</label>
                    <input type="number" id="cash-received-input" onkeyup="calculateChange()" class="bg-cream border border-cream-dark text-lg font-black rounded-xl px-4 py-2.5 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right" placeholder="0">
                </div>
                <div class="flex justify-between items-center text-xs font-semibold text-zinc-500 bg-red-50/50 p-2.5 rounded-lg border border-red-100/50">
                    <span>Kembalian Uang Tunai</span>
                    <span class="font-extrabold text-red-600 text-sm" id="cash-change-display">Rp 0</span>
                </div>
            </div>

            <button onclick="processPOSCheckout()" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 text-sm font-black py-3.5 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 border border-primary-dark/20">
                <i data-lucide="printer" class="w-4 h-4"></i> PROSES TRANSAKSI & CETAK STRUK
            </button>
        </div>
    </div>
</div>

<!-- MODAL 2: PRINT STRUK PREVIEW (Simulated receipt) -->
<div id="receipt-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-sm max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 space-y-4">
            <!-- Struk Paper Mockup -->
            <div class="border border-zinc-300 p-4 bg-zinc-50 rounded-lg text-zinc-800 text-[11px] font-mono space-y-2">
                <div class="text-center border-b border-dashed border-zinc-400 pb-2">
                    <p id="rec-header-title" class="font-bold text-xs uppercase">DEPOT AIR ELANGWATER</p>
                    <p id="rec-header-email" class="text-[9px] text-zinc-500">info@elangwater.com</p>
                    <p id="rec-header-address" class="text-[9px] text-zinc-500">Jl. H. Abdurrahman No. 12, Denpasar</p>
                    <p>HP: 0812-3456-7890</p>
                </div>
                <div class="space-y-1">
                    <p>No: <span id="rec-no">TRX-20260623-01</span></p>
                    <p>Tgl: <span id="rec-date">23/06/2026 10:55</span></p>
                    <p>Ksr: <span id="rec-cashier">Lia Kasir</span></p>
                    <p>Cust: <span id="rec-customer">Retail / Pelanggan Umum</span></p>
                </div>
                <div class="border-t border-b border-dashed border-zinc-400 py-1 space-y-1" id="rec-items">
                    <!-- loaded dynamically -->
                </div>
                <div class="text-right space-y-0.5">
                    <p>Subtotal: <span id="rec-subtotal">Rp 0</span></p>
                    <p>Diskon: <span id="rec-discount">Rp 0</span></p>
                    <p class="font-bold">Total: <span id="rec-total">Rp 0</span></p>
                    <p>Bayar: <span id="rec-paid">Rp 0</span></p>
                    <p>Kembali: <span id="rec-change">Rp 0</span></p>
                </div>
                <div class="text-center border-t border-dashed border-zinc-400 pt-2 text-[10px]">
                    <p class="font-bold">TERIMA KASIH</p>
                    <p id="rec-footer-text">Air Bersih Sehat Keluarga Anda</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <button onclick="closeReceiptModal()" class="bg-cream-dark hover:bg-zinc-200 text-zinc-800 text-xs font-bold py-2.5 rounded-xl transition-all">Tutup</button>
                <button onclick="window.print();" class="bg-primary hover:bg-primary-dark text-zinc-900 text-xs font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i data-lucide="printer" class="w-4 h-4"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 3: ADD NEW PRODUCT -->
<div id="add-product-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
            <span class="font-bold text-base flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Produk Baru
            </span>
            <button onclick="closeAddProductModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <form id="new-product-form" onsubmit="saveProduct(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Nama Produk</label>
                    <input type="text" id="new-prod-name" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">SKU</label>
                    <input type="text" id="new-prod-sku" required placeholder="ELG-XXX-XXX" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Barcode</label>
                    <input type="text" id="new-prod-barcode" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Kategori</label>
                    <select id="new-prod-cat" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                        <option>Galon</option>
                        <option>Botol</option>
                        <option>Gelas</option>
                    </select>
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Brand</label>
                    <input type="text" id="new-prod-brand" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Volume (Liter / ml / kardus)</label>
                    <input type="text" id="new-prod-vol" required placeholder="19L atau 600ml" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Satuan</label>
                    <input type="text" id="new-prod-unit" required placeholder="Galon, Box, Pcs" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Harga Modal</label>
                    <input type="number" id="new-prod-modal" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Harga Jual Retail</label>
                    <input type="number" id="new-prod-retail" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Harga Jual Grosir</label>
                    <input type="number" id="new-prod-wholesale" required class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white text-right">
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 font-bold py-2.5 rounded-xl transition-all">Simpan Produk Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 4: SIMULATE WAREHOUSE TRANSFER -->
<div id="transfer-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl border border-cream-dark w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="bg-primary p-4 text-zinc-900 flex items-center justify-between">
            <span class="font-bold text-base flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i> Permohonan Transfer Gudang
            </span>
            <button onclick="closeTransferModal()" class="p-1 rounded-lg hover:bg-primary-dark transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <form id="transfer-form" onsubmit="saveTransfer(event)" class="space-y-3 text-xs">
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Gudang Pengirim (Asal)</label>
                    <select id="tf-source" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        <option>Gudang Utama</option>
                        <option>Depo Elang Utara</option>
                    </select>
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Gudang Penerima (Tujuan)</label>
                    <select id="tf-dest" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        <option>Depo Elang Utara</option>
                        <option>Gudang Utama</option>
                    </select>
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Pilih Produk</label>
                    <select id="tf-product" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        <!-- populated by JS -->
                    </select>
                </div>
                <div>
                    <label class="font-bold text-zinc-500 block mb-1">Jumlah Qty Transfer</label>
                    <input type="number" id="tf-qty" required min="1" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-zinc-900 font-bold py-2.5 rounded-xl transition-all">Kirim Permohonan Transfer</button>
            </form>
        </div>
    </div>
</div>

<!-- SECTION 7: POS / KASIR LIVE VIEW -->
<div id="section-pos" class="lg:h-full flex flex-col gap-6 min-h-0 hidden">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between shrink-0">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">POS Kasir Kas-Air</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Transaksi cepat, cari produk, hold bill, dan cetak struk penjualan.</p>
        </div>
        <div class="flex items-center gap-2">
            <!-- Hold & Resume Bill Button -->
            <button onclick="openHoldBillsModal()" class="bg-white border border-cream-dark text-zinc-700 font-bold px-3 py-2 rounded-xl text-xs flex items-center gap-2 hover:bg-cream-dark">
                <i data-lucide="archive" class="w-4 h-4"></i>
                Hold Bills (<span id="hold-bills-count">0</span>)
            </button>
        </div>
    </div>

    <!-- Main POS Workstation Grid -->
    <div class="lg:flex-1 lg:min-h-0 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Products Catalog (2 Columns width on lg) -->
        <div class="lg:col-span-2 flex flex-col gap-4 bg-white border border-cream-dark p-4 rounded-2xl lg:min-h-0">
            <!-- Catalog controls -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between shrink-0">
                <!-- Search -->
                <div class="relative flex-1 min-w-0">
                    <i data-lucide="search" class="w-4 h-4 text-zinc-400 absolute left-3 top-3"></i>
                    <input type="text" id="pos-search-input" onkeyup="filterPOSCatalog()" placeholder="Ketik nama produk atau scan barcode..." class="bg-cream border border-cream-dark text-xs rounded-xl pl-9 pr-4 py-2.5 w-full min-w-0 focus:outline-none focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                </div>
                <!-- Barcode scan simulation button -->
                <button onclick="simulateBarcodeScan()" class="bg-primary-light text-primary-dark border border-primary font-semibold px-3 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1 hover:bg-primary transition-colors whitespace-nowrap">
                    <i data-lucide="qr-code" class="w-4 h-4"></i> Scan
                </button>
            </div>

            <!-- Category Filter Bubbles -->
            <div class="flex gap-2 overflow-x-auto shrink-0 pb-2 border-b border-cream-dark" id="pos-category-filters">
                <button onclick="filterPOSCategory(event, '')" class="pos-cat-btn px-4 py-1.5 bg-zinc-950 text-white rounded-full text-xs font-bold transition-all">Semua</button>
                <button onclick="filterPOSCategory(event, 'Galon')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Galon</button>
                <button onclick="filterPOSCategory(event, 'Botol')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Botol</button>
                <button onclick="filterPOSCategory(event, 'Gelas')" class="pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all">Gelas</button>
            </div>

            <!-- Catalog Grid -->
            <div class="lg:flex-1 lg:overflow-y-auto lg:min-h-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 p-1" id="pos-catalog-grid">
                <!-- dynamically populated with premium product cards -->
            </div>
        </div>

        <!-- Right: Active Cart & Billing Checkout (1 Column) -->
        <div class="bg-white border border-cream-dark rounded-2xl flex flex-col justify-between overflow-hidden shadow-sm">
            <!-- Cart Header & Customer Selector -->
            <div class="p-4 border-b border-cream-dark shrink-0 space-y-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <span class="font-bold text-sm flex items-center gap-1.5">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-primary-dark"></i> Detail Belanja
                    </span>
                    <button onclick="clearPOSCart()" class="text-xs text-red-500 hover:underline">Hapus Semua</button>
                </div>
                
                <!-- Customer Selection -->
                <div>
                    <label class="text-[10px] font-bold text-zinc-400 block mb-1">Customer / Level Harga</label>
                    <select id="pos-customer-select" onchange="updatePOSCartPricing()" class="bg-cream border border-cream-dark text-xs rounded-xl px-3 py-2 w-full font-bold focus:outline-none">
                        <!-- populated dynamically -->
                    </select>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="lg:flex-1 lg:overflow-y-auto lg:min-h-0 p-4 space-y-3 bg-cream/10" id="pos-cart-items">
                <!-- cart items list loaded here -->
            </div>

            <!-- Pricing Summary, Discounts, Hold Bill & Checkout -->
            <div class="p-4 border-t border-cream-dark bg-white shrink-0 space-y-3">
                <!-- Diskon Item / Transaksi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div class="bg-cream/40 p-2 rounded-xl border border-cream-dark">
                        <span class="text-[9px] font-bold text-zinc-400 block uppercase">Diskon Transaksi</span>
                        <div class="flex items-center gap-1 mt-1">
                            <span class="text-xs font-bold text-zinc-600">%</span>
                            <input type="number" id="pos-discount-input" onkeyup="recalculatePOSCartTotal()" value="0" min="0" max="100" class="bg-transparent border-none p-0 text-xs font-bold w-full focus:outline-none">
                        </div>
                    </div>
                    <div class="bg-cream/40 p-2 rounded-xl border border-cream-dark flex flex-col justify-center">
                        <span class="text-[9px] font-bold text-zinc-400 block uppercase">Metode Default</span>
                        <span class="text-xs font-bold text-zinc-800 mt-1">Tunai / Cash</span>
                    </div>
                </div>

                <!-- Final Total -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs text-zinc-500">
                        <span>Subtotal</span>
                        <span id="pos-cart-subtotal">Rp 0</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-zinc-500">
                        <span>Diskon Transaksi</span>
                        <span id="pos-cart-discount-value" class="text-red-500">- Rp 0</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-dashed border-cream-dark pt-2">
                        <span class="font-extrabold text-sm">TOTAL AKHIR</span>
                        <span class="font-black text-lg text-zinc-900" id="pos-cart-total-display">Rp 0</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="grid grid-cols-1 gap-2 pt-1 sm:grid-cols-3">
                    <!-- Hold bill -->
                    <button onclick="holdActiveBill()" class="bg-cream-dark hover:bg-zinc-200 text-zinc-800 text-xs font-bold py-3 rounded-xl transition-all active:scale-95 flex flex-col items-center justify-center gap-1">
                        <i data-lucide="archive" class="w-4 h-4"></i>
                        <span>Hold Bill</span>
                    </button>
                    <!-- Checkout / Pembayaran -->
                    <button onclick="openPaymentModal()" class="sm:col-span-2 bg-primary hover:bg-primary-dark text-zinc-900 text-sm font-black py-3 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 border border-primary-dark/20">
                        <i data-lucide="credit-card" class="w-5 h-5 text-zinc-950"></i>
                        <span>BAYAR SEKARANG</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

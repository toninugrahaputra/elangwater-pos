<!-- SECTION 7: POS / KASIR LIVE VIEW -->
<div id="section-pos" class="lg:h-full flex flex-col gap-6 min-h-0 hidden" data-permission="pos.access">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between shrink-0">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">POS Kasir Kas-Air</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Transaksi cepat, cari produk, hold bill, dan cetak struk penjualan.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Hold & Resume Bill Button -->
            <button onclick="openHoldBillsModal()" class="bg-white border border-cream-dark text-zinc-700 font-bold px-4 py-3 rounded-xl flex items-center gap-2 hover:bg-cream-dark transition-colors">
                <i data-lucide="archive" class="w-4 h-4"></i>
                Hold Bills (<span id="hold-bills-count">0</span>)
            </button>
        </div>
    </div>

    <!-- Main POS Workstation Grid -->
    <div class="lg:flex-1 lg:min-h-0 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Products Catalog (2 Columns width on lg) -->
        <div class="lg:col-span-2 flex flex-col gap-6 bg-white border border-cream-dark p-6 rounded-2xl shadow hover:shadow-lg transition-shadow lg:min-h-0">
            <!-- Catalog controls -->
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between shrink-0">
                <!-- Search -->
                <div class="relative flex-1 min-w-0">
                    <i data-lucide="search" class="w-5 h-5 text-zinc-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <input type="text" id="pos-search-input" onkeyup="filterPOSCatalog()" placeholder="Ketik nama produk atau scan barcode..." class="bg-cream border border-cream-dark text-base rounded-3xl pl-10 pr-4 py-3.5 w-full min-w-0 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                </div>
                <!-- Barcode scan simulation button -->
                <button onclick="simulateBarcodeScan()" class="bg-primary-light text-primary-dark border border-primary font-semibold px-5 py-3.5 rounded-3xl flex items-center justify-center gap-2 hover:bg-primary transition-colors whitespace-nowrap">
                    <i data-lucide="qr-code" class="w-5 h-5"></i> Scan
                </button>
            </div>

            <!-- Category Filter Bubbles -->
            <div class="flex gap-3 overflow-x-auto shrink-0 pb-3 border-b border-cream-dark" id="pos-category-filters">
                <button onclick="filterPOSCategory(event, '')" class="pos-cat-btn px-5 py-2 rounded-full font-semibold transition-all bg-zinc-950 text-white hover:bg-zinc-200">Semua</button>
                <button onclick="filterPOSCategory(event, 'Galon')" class="pos-cat-btn px-5 py-2 rounded-full font-semibold transition-all bg-cream-dark hover:bg-zinc-200">Galon</button>
                <button onclick="filterPOSCategory(event, 'Botol')" class="pos-cat-btn px-5 py-2 rounded-full font-semibold transition-all bg-cream-dark hover:bg-zinc-200">Botol</button>
                <button onclick="filterPOSCategory(event, 'Gelas')" class="pos-cat-btn px-5 py-2 rounded-full font-semibold transition-all bg-cream-dark hover:bg-zinc-200">Gelas</button>
            </div>

            <!-- Catalog Grid -->
            <div class="lg:flex-1 lg:overflow-y-auto lg:min-h-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-2" id="pos-catalog-grid">
                <!-- dynamically populated with premium product cards -->
            </div>
        </div>

        <!-- Right: Active Cart & Billing Checkout (1 Column) -->
        <div class="bg-white border border-cream-dark rounded-2xl flex flex-col justify-between overflow-hidden shadow hover:shadow-lg transition-shadow">
            <!-- Cart Header & Customer Selector -->
            <div class="p-6 border-b border-cream-dark shrink-0 space-y-5">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <span class="font-bold text-sm flex items-center gap-2">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-primary-dark"></i> Detail Belanja
                    </span>
                    <button onclick="clearPOSCart()" class="text-sm text-red-500 hover:underline transition-colors">Hapus Semua</button>
                </div>

                <!-- Customer Selection -->
                <div>
                    <label class="text-[10px] font-bold text-zinc-400 block mb-2">Customer / Level Harga</label>
                    <select id="pos-customer-select" onchange="updatePOSCartPricing()" class="bg-cream border border-cream-dark text-base rounded-3xl px-4 py-3 w-full font-bold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white">
                        <!-- populated dynamically -->
                    </select>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="lg:flex-1 lg:overflow-y-auto lg:min-h-0 p-6 space-y-4 bg-cream/10" id="pos-cart-items">
                <!-- cart items list loaded here -->
            </div>

            <!-- Pricing Summary, Discounts, Hold Bill & Checkout -->
            <div class="p-6 border-t border-cream-dark bg-white shrink-0 space-y-5">
                <!-- Diskon Item / Transaksi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-cream/40 p-4 rounded-3xl border border-cream-dark">
                        <span class="text-[10px] font-bold text-zinc-400 block uppercase mb-2">Diskon Transaksi</span>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs font-bold text-zinc-600">%</span>
                            <input type="number" id="pos-discount-input" onkeyup="recalculatePOSCartTotal()" value="0" min="0" max="100" class="bg-transparent border-none p-0 text-base font-bold w-full focus:outline-none">
                        </div>
                    </div>
                    <div class="bg-cream/40 p-4 rounded-3xl border border-cream-dark flex flex-col justify-center items-start">
                        <span class="text-[10px] font-bold text-zinc-400 block uppercase mb-2">Metode Default</span>
                        <span class="text-base font-bold text-zinc-800 mt-2">Tunai / Cash</span>
                    </div>
                </div>

                <!-- Final Total -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-base text-zinc-500">
                        <span>Subtotal</span>
                        <span id="pos-cart-subtotal">Rp 0</span>
                    </div>
                    <div class="flex items-center justify-between text-base text-zinc-500">
                        <span>Diskon Transaksi</span>
                        <span id="pos-cart-discount-value" class="text-red-500">- Rp 0</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-dashed border-cream-dark pt-4">
                        <span class="font-extrabold text-lg">TOTAL AKHIR</span>
                        <span class="font-black text-xl text-zinc-900" id="pos-cart-total-display">Rp 0</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="grid grid-cols-1 gap-3 pt-4 sm:grid-cols-3">
                    <!-- Hold bill -->
                    <button onclick="holdActiveBill()" class="bg-cream-dark hover:bg-zinc-200 text-zinc-800 font-bold py-3.5 rounded-3xl transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i data-lucide="archive" class="w-4 h-4"></i>
                        <span>Hold Bill</span>
                    </button>
                    <!-- Checkout / Pembayaran -->
                    <button onclick="openPaymentModal()" class="sm:col-span-2 bg-primary hover:bg-primary-dark text-zinc-900 font-black text-base py-4 rounded-3xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-3 border border-primary-dark/20" data-permission="pos.checkout">
                        <i data-lucide="credit-card" class="w-5 h-5 text-zinc-950"></i>
                        <span>BAYAR SEKARANG</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elangwater POS & ERP</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />

    <!-- CSS & JS Assets (Tailwind v4 via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome & Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- ChartJS for Laporan & Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 for Interactive UI Popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #FCFAF6;
        }
        ::-webkit-scrollbar-thumb {
            background: #E2AD3B;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #F8C24E;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        main,
        section,
        div {
            min-width: 0;
        }

        table {
            border-collapse: collapse;
        }

        canvas {
            max-width: 100%;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="h-screen bg-cream text-zinc-800 flex flex-col overflow-hidden">

    <!-- Top Navbar -->
    <x-navbar />

    <!-- Main Workspace Container -->
    <div class="flex flex-1 min-h-0 overflow-hidden relative">
        <!-- Sidebar Navigation -->
        <x-sidebar />

        <!-- Main Workspace Area -->
        <main class="flex-1 min-w-0 bg-cream p-4 md:p-6 overflow-y-auto h-full" id="workspace-content">
            <x-sections.dashboard />
            <x-sections.master />
            <x-sections.inventori />
            <x-sections.contacts />
            <x-sections.pembelian />
            <x-sections.pos />
            <x-sections.distribusi />
            <x-sections.keuangan />
            <x-sections.laporan />
            <x-sections.sistem />
        </main>
    </div>

    <!-- Modals -->
    <x-modals />

    <!-- JAVASCRIPT STATE ENGINE -->
    <script>
        // Init state database
        let products = [
            { id: 1, name: 'Galon Elangwater 19L', sku: 'ELG-GAL-19L', barcode: '8991234560012', category: 'Galon', brand: 'Elangwater', volume: '19L', unit: 'Galon', cost: 8000, retailPrice: 15000, wholesalePrice: 12000, agencyPrice: 13500, active: true, image: 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 850, 'Depo Elang Utara': 2 } },
            { id: 2, name: 'Botol Elangwater 600ml', sku: 'ELG-BOT-600M', barcode: '8991234560029', category: 'Botol', brand: 'Elangwater', volume: '600ml', unit: 'Box', cost: 28000, retailPrice: 38000, wholesalePrice: 33000, agencyPrice: 35000, active: true, image: 'https://images.unsplash.com/photo-1608885898957-a599fb18de37?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 120, 'Depo Elang Utara': 40 } },
            { id: 3, name: 'Botol Elangwater 1500ml', sku: 'ELG-BOT-1500M', barcode: '8991234560036', category: 'Botol', brand: 'Elangwater', volume: '1500ml', unit: 'Box', cost: 30000, retailPrice: 42000, wholesalePrice: 36000, agencyPrice: 38500, active: true, image: 'https://images.unsplash.com/photo-1548839130-3bf604e40290?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 90, 'Depo Elang Utara': 5 } },
            { id: 4, name: 'Gelas Elangwater 240ml', sku: 'ELG-CUP-240M', barcode: '8991234560043', category: 'Gelas', brand: 'Elangwater', volume: '240ml', unit: 'Box', cost: 18000, retailPrice: 24000, wholesalePrice: 20000, agencyPrice: 22000, active: true, image: 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=300&q=80', stock: { 'Gudang Utama': 15, 'Depo Elang Utara': 12 } }
        ];

        let warehouses = [
            { name: 'Gudang Utama', code: 'GD-UTAMA', pic: 'Slamet', address: 'Kawasan Industri Cikarang Blok B-12', isMulti: true },
            { name: 'Depo Elang Utara', code: 'GD-UTARA', pic: 'Dedi', address: 'Jl. Danau Sunter Barat No. 8', isMulti: true }
        ];

        let customers = [
            { name: 'Toko Makmur Sejahtera', type: 'Distributor', phone: '081299887711', address: 'Jakarta Utara', spend: 48900000, debt: 4500000 },
            { name: 'Budi Agen Air Lestari', type: 'Agen', phone: '085711223344', address: 'Bekasi Barat', spend: 15200000, debt: 2100000 },
            { name: 'Pelanggan Umum', type: 'Retail', phone: '-', address: 'Outlet Kasir', spend: 12450000, debt: 0 }
        ];

        let suppliers = [
            { name: 'PT Kemasan Plastik Indonesia', contact: 'Rita', phone: '021-8990123', address: 'Tangerang', spend: 12500000, debt: 2200000 },
            { name: 'CV Sumber Mata Air Pegunungan', contact: 'Anto', phone: '0811990088', address: 'Bogor', spend: 32000000, debt: 2000000 }
        ];

        let transfers = [
            { code: 'TF-0081', from: 'Gudang Utama', to: 'Depo Elang Utara', item: 'Galon Elangwater 19L', qty: 100, date: '2026-06-22', status: 'Pending' },
            { code: 'TF-0080', from: 'Depo Elang Utara', to: 'Gudang Utama', item: 'Botol Elangwater 600ml', qty: 50, date: '2026-06-20', status: 'Approved' }
        ];

        let opnames = [
            { code: 'OP-005', warehouse: 'Gudang Utama', item: 'Gelas Elangwater 240ml', bookStock: 15, physicalStock: 15, diff: 0, remark: 'Stok Sesuai', status: 'Approved' }
        ];

        let purchasing = [
            { poNo: 'PO-2026-012', supplier: 'PT Kemasan Plastik Indonesia', date: '2026-06-21', item: 'Botol Kosong 600ml (10.000 Pcs)', totalCost: 15000000, status: 'Received' },
            { poNo: 'PO-2026-013', supplier: 'CV Sumber Mata Air Pegunungan', date: '2026-06-23', item: 'Pasokan Air Tangki 10.000L (2 Tangki)', totalCost: 4000000, status: 'Approved' }
        ];

        let deliverOrders = [
            { doNo: 'DO-2026-092', customer: 'Toko Makmur Sejahtera', driver: 'Agus Delivery', items: 'Galon Elangwater 19L (150 Pcs)', status: 'Sedang Dikirim' },
            { doNo: 'DO-2026-091', customer: 'Budi Agen Air Lestari', driver: 'Rian Delivery', items: 'Botol Elangwater 600ml (20 Box)', status: 'Selesai' }
        ];

        let cashFlow = [
            { journalNo: 'JRN-2026-045', date: '2026-06-23', type: 'Masuk', category: 'Penjualan POS', remark: 'Penjualan POS Cash Shift Pagi', amount: 3500000 },
            { journalNo: 'JRN-2026-046', date: '2026-06-23', type: 'Keluar', category: 'Operasional', remark: 'Beli Bensin Delivery Truck', amount: 250000 }
        ];

        // POS Cart State
        let posCart = [];
        let activePaymentMethod = 'Tunai';

        // Hold bills state
        let holdBills = [];

        // Active workspace tab
        let activeTab = 'dashboard';
        let mobileSidebarOpen = false;

        window.onload = function() {
            lucide.createIcons();
            renderDashboard();
            renderProducts();
            renderPOSCatalog();
            populateSelects();
            renderWarehouses();
            renderStockTable();
            renderSuppliers();
            renderCustomers();
            renderTransfers();
            renderOpnameTable();
            renderIncomingStock();
            renderOutgoingStock();
            renderKartuStok();
            renderPembelian();
            renderDO();
            renderBuktiKirim();
            renderKeuanganKas();
            renderKeuanganTagihan();
            renderKeuanganHutang();
            initCharts();
            // Load default reports
            loadReport('penjualan', 'penjualan-harian');
            loadReport('inventori', 'stok-tanggal');
            loadReport('pembelian', 'pembelian-supplier');
            loadReport('pelanggan', 'top-customer');
            loadReport('keuangan', 'arus-kas');
            // Init settings pane visibility (uses style.display, not hidden class)
            const setUserPane = document.getElementById('set-user');
            if (setUserPane) setUserPane.style.display = 'grid';
            const setStrukPane = document.getElementById('set-struk');
            if (setStrukPane) setStrukPane.style.display = 'none';
        };

        // Navigation
        function switchTab(tabId) {
            document.querySelectorAll('#workspace-content [id^="section-"]').forEach(div => div.classList.add('hidden'));

            // Handle sub-sections switching correctly
            let targetDiv = document.getElementById('section-' + tabId);
            if (targetDiv) {
                targetDiv.classList.remove('hidden');
            }

            // Remove active classes from navigation items
            document.querySelectorAll('#main-navigation button').forEach(btn => {
                btn.className = btn.className.replace('bg-primary text-zinc-900 shadow-sm border border-primary/20', 'text-zinc-700 hover:text-zinc-900');
            });

            // Set active class on main menu buttons if applicable
            let mainNavBtn = document.getElementById('nav-' + tabId.split('-')[0]);
            if (mainNavBtn) {
                mainNavBtn.className = "w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream bg-primary text-zinc-900 shadow-sm border border-primary/20";
            }

            activeTab = tabId;
            lucide.createIcons();

            if (mobileSidebarOpen) {
                closeMobileSidebar();
            }
        }

        function toggleSubmenu(submenuId) {
            let submenu = document.getElementById(submenuId);
            let arrow = document.getElementById('arrow-' + submenuId.split('-')[1]);
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleMobileSidebar() {
            let sidebar = document.getElementById('main-sidebar');
            let overlay = document.getElementById('mobile-sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                mobileSidebarOpen = true;
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                mobileSidebarOpen = false;
            }
        }

        function closeMobileSidebar() {
            let sidebar = document.getElementById('main-sidebar');
            let overlay = document.getElementById('mobile-sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            mobileSidebarOpen = false;
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeMobileSidebar();
            }
        });

        // Simulating Roles & Permissions
        function changeRoleSim(role) {
            const roleInfo = {
                admin: { name: 'Rakryan Alangwater', desc: 'Super Admin' },
                kasir: { name: 'Lia Kasir', desc: 'Kasir POS' },
                gudang: { name: 'Karno Staf Gudang', desc: 'Staf Gudang' },
                distributor: { name: 'Budi Driver', desc: 'Sopir / Distribusi' }
            };

            document.getElementById('user-display-name').innerText = roleInfo[role].name;
            document.getElementById('user-display-role').innerText = roleInfo[role].desc;

            Swal.fire({
                title: 'Perubahan Role',
                text: `Sekarang masuk sebagai role ${roleInfo[role].desc}. Izin akses telah disesuaikan secara visual!`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }

        // RENDER FUNCTIONS
        function renderDashboard() {
            let tableBody = document.getElementById('dash-min-stock-table-body');
            tableBody.innerHTML = '';

            let lowStockItems = [];
            products.forEach(p => {
                Object.keys(p.stock).forEach(gudang => {
                    let qty = p.stock[gudang];
                    // simulate safety stock limit
                    let safetyLimit = p.category === 'Galon' ? 10 : 30;
                    let reorderPoint = safetyLimit * 1.5;

                    if (qty <= reorderPoint) {
                        lowStockItems.push({
                            name: p.name,
                            sku: p.sku,
                            gudang: gudang,
                            qty: qty,
                            safety: safetyLimit,
                            rop: reorderPoint,
                            status: qty <= safetyLimit ? 'KRITIS' : 'Reorder Point'
                        });
                    }
                });
            });

            lowStockItems.forEach(item => {
                let badgeClass = item.status === 'KRITIS' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-800';
                tableBody.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-bold">${item.name}<p class="text-[10px] text-zinc-400 font-medium">${item.sku}</p></td>
                        <td class="py-3 px-4 text-zinc-500">${item.gudang}</td>
                        <td class="py-3 px-4 font-extrabold text-sm">${item.qty} Pcs</td>
                        <td class="py-3 px-4 text-zinc-500">${item.safety} Pcs</td>
                        <td class="py-3 px-4 text-zinc-500">${item.rop} Pcs</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold ${badgeClass}">${item.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            <button onclick="orderStockSim('${item.name}')" class="bg-primary hover:bg-primary-dark font-bold text-[10px] px-2 py-1 rounded">Reorder</button>
                        </td>
                    </tr>
                `;
            });
        }

        function orderStockSim(name) {
            Swal.fire({
                title: 'Buat PO Otomatis?',
                text: `Ingin membuat Pre-Order otomatis untuk ${name}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Buat PO',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Berhasil', 'Pre-Order berhasil dibuat dan masuk di modul Pembelian!', 'success');
                }
            });
        }

        function renderProducts() {
            let table = document.getElementById('master-produk-table-body');
            table.innerHTML = '';
            products.forEach(p => {
                let totalStock = Object.values(p.stock).reduce((a, b) => a + b, 0);
                table.innerHTML += `
                    <tr>
                        <td class="py-4 px-6 font-bold flex items-center gap-3">
                            <img src="${p.image}" class="w-10 h-10 object-cover rounded-lg border border-cream-dark">
                            <div>
                                <p class="text-sm font-bold text-zinc-900">${p.name}</p>
                                <p class="text-[10px] text-zinc-400">Brand: ${p.brand}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-zinc-600 font-mono">${p.sku}<p class="text-[10px] text-zinc-400">${p.barcode}</p></td>
                        <td class="py-4 px-6"><span class="px-2 py-0.5 bg-cream-dark text-zinc-700 rounded-full font-semibold text-[10px]">${p.category}</span></td>
                        <td class="py-4 px-6 text-zinc-600">${p.volume} / <span class="font-bold">${p.unit}</span></td>
                        <td class="py-4 px-6 font-semibold">Rp ${p.cost.toLocaleString('id-ID')}</td>
                        <td class="py-4 px-6 font-bold text-zinc-900">
                            Rp ${p.retailPrice.toLocaleString('id-ID')}
                            <p class="text-[10px] text-zinc-400 font-medium">Grosir: Rp ${p.wholesalePrice.toLocaleString('id-ID')}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">Aktif</span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button onclick="deleteProduct(${p.id})" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('master-prod-total-count').innerText = products.length;
        }

        // POS CATALOG & CART
        function renderPOSCatalog() {
            let grid = document.getElementById('pos-catalog-grid');
            grid.innerHTML = '';
            products.forEach(p => {
                if (p.active) {
                    let totalStock = Object.values(p.stock).reduce((a, b) => a + b, 0);
                    let iconName = 'package';
                    if (p.category.toLowerCase() === 'galon') iconName = 'droplet';
                    else if (p.category.toLowerCase() === 'botol') iconName = 'glass-water';
                    else if (p.category.toLowerCase() === 'gelas') iconName = 'cup-soda';

                    grid.innerHTML += `
                        <div onclick="addToPOSCart(${p.id})" class="bg-white border border-cream-dark p-3 rounded-2xl cursor-pointer hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all flex flex-col justify-between h-full">
                            <div class="w-full aspect-square bg-white border border-cream-dark/30 rounded-xl mb-2 relative overflow-hidden flex items-center justify-center shrink-0">
                                <img src="${p.image}" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');" class="w-full h-full object-contain p-2">
                                <div class="hidden absolute inset-0 bg-primary-light/30 flex flex-col items-center justify-center text-primary-dark/80">
                                    <i data-lucide="${iconName}" class="w-8 h-8 fill-primary/10"></i>
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col justify-between min-h-0">
                                <div class="space-y-0.5">
                                    <span class="text-[9px] uppercase font-bold text-zinc-400 block">${p.category}</span>
                                    <h4 class="font-bold text-xs leading-tight text-zinc-950 truncate" title="${p.name}">${p.name}</h4>
                                </div>
                                <div class="flex items-end justify-between mt-2 pt-2 border-t border-cream-dark/50">
                                    <span class="font-black text-sm text-zinc-900">Rp ${p.retailPrice.toLocaleString('id-ID')}</span>
                                    <span class="text-[10px] font-bold ${totalStock <= 15 ? 'text-red-500 bg-red-50 px-1.5 py-0.5 rounded' : 'text-zinc-500'}">Stok: ${totalStock}</span>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            lucide.createIcons();
        }

        function filterPOSCatalog() {
            let q = document.getElementById('pos-search-input').value.toLowerCase();
            let cards = document.querySelectorAll('#pos-catalog-grid > div');
            cards.forEach(card => {
                let name = card.querySelector('h4').innerText.toLowerCase();
                let category = card.querySelector('span').innerText.toLowerCase();
                if (name.includes(q) || category.includes(q)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function filterPOSCategory(e, cat) {
            document.querySelectorAll('.pos-cat-btn').forEach(btn => {
                btn.className = "pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all";
            });
            if (e && e.currentTarget) {
                e.currentTarget.className = "pos-cat-btn px-4 py-1.5 bg-zinc-950 text-white rounded-full text-xs font-bold transition-all";
            }

            let cards = document.querySelectorAll('#pos-catalog-grid > div');
            cards.forEach(card => {
                let category = card.querySelector('span').innerText;
                if (cat === '' || category === cat.toUpperCase()) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function populateSelects() {
            // Customer select in POS
            let select = document.getElementById('pos-customer-select');
            select.innerHTML = '';
            customers.forEach((c, idx) => {
                select.innerHTML += `<option value="${idx}">${c.name} (${c.type})</option>`;
            });

            // SKU filter in Kartu Stok
            let skuSelect = document.getElementById('kartu-stok-sku-filter');
            skuSelect.innerHTML = '<option value="">Pilih SKU Produk</option>';
            products.forEach(p => {
                skuSelect.innerHTML += `<option value="${p.sku}">${p.name} (${p.sku})</option>`;
            });

            // Add Product modal & Transfer modal Selects
            let tfProd = document.getElementById('tf-product');
            tfProd.innerHTML = '';
            products.forEach(p => {
                tfProd.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        }

        // CART LOGIC
        function addToPOSCart(prodId) {
            let product = products.find(p => p.id === prodId);
            let existing = posCart.find(item => item.product.id === prodId);

            if (existing) {
                existing.qty += 1;
            } else {
                posCart.push({ product: product, qty: 1 });
            }

            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function changeCartQty(index, amt) {
            posCart[index].qty += amt;
            if (posCart[index].qty <= 0) {
                posCart.splice(index, 1);
            }
            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function updatePOSCartPricing() {
            // Recalculates based on Level Harga (Retail, Agen, Distributor)
            recalculatePOSCartTotal();
        }

        function recalculatePOSCartTotal() {
            let subtotal = 0;
            let custIdx = document.getElementById('pos-customer-select').value;
            let customerType = customers[custIdx].type;

            posCart.forEach(item => {
                let price = item.product.retailPrice; // Default
                if (customerType === 'Agen') {
                    price = item.product.agencyPrice || item.product.retailPrice * 0.9;
                } else if (customerType === 'Distributor') {
                    price = item.product.wholesalePrice || item.product.retailPrice * 0.8;
                }
                subtotal += price * item.qty;
            });

            let discountPct = parseFloat(document.getElementById('pos-discount-input').value) || 0;
            let discountValue = (discountPct / 100) * subtotal;
            let finalTotal = subtotal - discountValue;

            document.getElementById('pos-cart-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('pos-cart-discount-value').innerText = '- Rp ' + discountValue.toLocaleString('id-ID');
            document.getElementById('pos-cart-total-display').innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');
            document.getElementById('payment-modal-total').innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');
        }

        function renderPOSCart() {
            let container = document.getElementById('pos-cart-items');
            container.innerHTML = '';

            if (posCart.length === 0) {
                container.innerHTML = `
                    <div class="h-full flex flex-col items-center justify-center text-zinc-400 py-12">
                        <i data-lucide="shopping-cart" class="w-8 h-8 mb-2 opacity-50"></i>
                        <p class="text-xs">Keranjang Belanja Kosong</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            let custIdx = document.getElementById('pos-customer-select').value;
            let customerType = customers[custIdx].type;

            posCart.forEach((item, idx) => {
                let price = item.product.retailPrice;
                if (customerType === 'Agen') price = item.product.agencyPrice;
                if (customerType === 'Distributor') price = item.product.wholesalePrice;

                container.innerHTML += `
                    <div class="bg-white border border-cream-dark p-3 rounded-xl flex items-center justify-between shadow-sm">
                        <div>
                            <h5 class="font-bold text-xs">${item.product.name}</h5>
                            <p class="text-[10px] text-zinc-500">Rp ${price.toLocaleString('id-ID')} / ${item.product.unit}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="changeCartQty(${idx}, -1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">-</button>
                            <span class="text-xs font-bold w-6 text-center">${item.qty}</span>
                            <button onclick="changeCartQty(${idx}, 1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">+</button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function clearPOSCart() {
            posCart = [];
            recalculatePOSCartTotal();
            renderPOSCart();
        }

        function switchSettingsSubTab(event, tabId) {
            // Hide all panes by removing any active display and adding Tailwind hidden
            document.querySelectorAll('.settings-sub-pane').forEach(pane => {
                pane.style.display = '';
                pane.classList.add('hidden');
            });
            document.querySelectorAll('.settings-subtab-btn').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-zinc-900', 'shadow-sm');
                btn.classList.add('text-zinc-600');
            });

            if (event && event.currentTarget) {
                event.currentTarget.classList.add('bg-primary', 'text-zinc-900', 'shadow-sm');
                event.currentTarget.classList.remove('text-zinc-600');
            } else {
                const btnMap = { 'set-user': 'btn-set-user', 'set-struk': 'btn-set-struk' };
                let activeBtn = document.getElementById(btnMap[tabId] || ('btn-' + tabId));
                if (activeBtn) {
                    activeBtn.classList.add('bg-primary', 'text-zinc-900', 'shadow-sm');
                    activeBtn.classList.remove('text-zinc-600');
                }
            }

            let activePane = document.getElementById(tabId);
            if (activePane) {
                // remove hidden so Tailwind doesn't force display:none
                activePane.classList.remove('hidden');
                // set-user uses grid, set-struk wraps grid in a div
                activePane.style.display = (tabId === 'set-user') ? 'grid' : 'block';
            }
        }

        function simulateBarcodeScan() {
            // Simulate scanning the first product
            Swal.fire({
                title: 'Simulasi Scan Barcode',
                text: 'Memindai barcode "8991234560012" (Galon Elangwater 19L)',
                icon: 'info',
                timer: 1000,
                showConfirmButton: false
            });
            setTimeout(() => {
                addToPOSCart(1);
            }, 1000);
        }

        // HOLD & RESUME BILL
        function holdActiveBill() {
            if (posCart.length === 0) {
                Swal.fire('Keranjang Kosong', 'Tambahkan item ke keranjang sebelum menangguhkan transaksi.', 'warning');
                return;
            }
            let custName = customers[document.getElementById('pos-customer-select').value].name;
            holdBills.push({
                id: Date.now(),
                customer: custName,
                cart: [...posCart],
                date: new Date().toLocaleTimeString()
            });
            posCart = [];
            recalculatePOSCartTotal();
            renderPOSCart();
            document.getElementById('hold-bills-count').innerText = holdBills.length;
            Swal.fire('Bill Ditangguhkan', 'Transaksi berhasil disimpan sementara.', 'success');
        }

        function openHoldBillsModal() {
            if (holdBills.length === 0) {
                Swal.fire('Tidak ada Hold Bills', 'Belum ada struk transaksi yang ditangguhkan.', 'info');
                return;
            }

            let listHTML = holdBills.map((hb, idx) => `
                <div class="flex items-center justify-between p-3 border-b border-cream-dark text-xs">
                    <div>
                        <p class="font-bold">Customer: ${hb.customer}</p>
                        <p class="text-zinc-500">Jam: ${hb.date} (${hb.cart.length} item)</p>
                    </div>
                    <button onclick="resumeBill(${hb.id})" class="bg-primary hover:bg-primary-dark font-bold text-xs px-3 py-1.5 rounded-lg">Buka</button>
                </div>
            `).join('');

            Swal.fire({
                title: 'Daftar Hold Bills',
                html: `<div class="text-left max-h-60 overflow-y-auto">${listHTML}</div>`,
                showConfirmButton: false,
                showCloseButton: true
            });
        }

        function resumeBill(id) {
            let bill = holdBills.find(hb => hb.id === id);
            if (bill) {
                posCart = bill.cart;
                holdBills = holdBills.filter(hb => hb.id !== id);
                document.getElementById('hold-bills-count').innerText = holdBills.length;
                recalculatePOSCartTotal();
                renderPOSCart();
                Swal.close();
            }
        }

        // PAYMENT CHECKOUT
        function openPaymentModal() {
            if (posCart.length === 0) {
                Swal.fire('Keranjang Kosong', 'Silakan pilih produk terlebih dahulu.', 'warning');
                return;
            }
            document.getElementById('payment-modal').classList.remove('hidden');
            selectPaymentMethod('Tunai');
            calculateChange();
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        function selectPaymentMethod(method) {
            activePaymentMethod = method;
            document.querySelectorAll('.pay-method-btn').forEach(btn => {
                btn.className = "pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";
            });
            document.getElementById('pay-btn-' + method).className = "pay-method-btn py-3 border border-primary bg-primary-light text-zinc-900 rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";

            if (method === 'Tunai') {
                document.getElementById('cash-input-group').classList.remove('hidden');
            } else {
                document.getElementById('cash-input-group').classList.add('hidden');
            }
        }

        function presetCashAmount(amt) {
            document.getElementById('cash-received-input').value = amt;
            calculateChange();
        }

        function calculateChange() {
            let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
            let total = parseInt(totalDisplay) || 0;
            let received = parseInt(document.getElementById('cash-received-input').value) || 0;
            let change = received - total;

            if (change < 0) {
                document.getElementById('cash-change-display').innerText = 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
            } else {
                document.getElementById('cash-change-display').innerText = 'Rp ' + change.toLocaleString('id-ID');
            }
        }

        function processPOSCheckout() {
            let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
            let total = parseInt(totalDisplay) || 0;
            let received = parseInt(document.getElementById('cash-received-input').value) || 0;

            if (activePaymentMethod === 'Tunai' && received < total) {
                Swal.fire('Uang Kurang', 'Pembayaran tunai yang diterima kurang dari total belanja.', 'error');
                return;
            }

            // Deduct stock simulation
            posCart.forEach(item => {
                if (item.product.stock['Gudang Utama'] >= item.qty) {
                    item.product.stock['Gudang Utama'] -= item.qty;
                }
            });

            closePaymentModal();
            renderReceipt(total, received);
            clearPOSCart();
            renderProducts();
            renderStockTable();
            renderDashboard();

            // Add cash transaction
            cashFlow.unshift({
                journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                date: new Date().toISOString().slice(0, 10),
                type: 'Masuk',
                category: 'Penjualan POS',
                remark: 'Penjualan POS ' + activePaymentMethod,
                amount: total
            });
            renderKeuanganKas();
        }

        function renderReceipt(total, received) {
            document.getElementById('rec-no').innerText = 'TRX-' + Date.now();
            document.getElementById('rec-date').innerText = new Date().toLocaleString();

            // Dynamic receipt configurations
            let rTitle = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
            let rEmail = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
            let rAddress = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
            let rFooter = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';

            document.getElementById('rec-header-title').innerText = rTitle;
            document.getElementById('rec-header-email').innerText = rEmail;
            document.getElementById('rec-header-address').innerText = rAddress;
            document.getElementById('rec-footer-text').innerText = rFooter;

            let custIdx = document.getElementById('pos-customer-select').value;
            document.getElementById('rec-customer').innerText = customers[custIdx].name + ' (' + customers[custIdx].type + ')';

            let itemsHTML = '';
            posCart.forEach(item => {
                let price = item.product.retailPrice;
                if (customers[custIdx].type === 'Agen') price = item.product.agencyPrice;
                if (customers[custIdx].type === 'Distributor') price = item.product.wholesalePrice;
                itemsHTML += `
                    <div class="flex justify-between">
                        <span>${item.product.name} x${item.qty}</span>
                        <span>Rp ${(price * item.qty).toLocaleString('id-ID')}</span>
                    </div>
                `;
            });

            document.getElementById('rec-items').innerHTML = itemsHTML;
            document.getElementById('rec-subtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('rec-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('rec-paid').innerText = 'Rp ' + (activePaymentMethod === 'Tunai' ? received : total).toLocaleString('id-ID');

            let change = received - total;
            document.getElementById('rec-change').innerText = 'Rp ' + (change > 0 && activePaymentMethod === 'Tunai' ? change : 0).toLocaleString('id-ID');

            document.getElementById('receipt-modal').classList.remove('hidden');
        }

        function closeReceiptModal() {
            document.getElementById('receipt-modal').classList.add('hidden');
        }

        function updateLiveReceiptPreview() {
            let title = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
            let email = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
            let address = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
            let footer = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';
            let showLogo = document.getElementById('set-receipt-show-logo').checked;
            let paperSize = document.querySelector('input[name="paper-size"]:checked')?.value || '58mm';

            document.getElementById('preview-rec-title').innerText = title;
            document.getElementById('preview-rec-email').innerText = email;
            document.getElementById('preview-rec-address').innerText = address;
            document.getElementById('preview-rec-footer').innerText = footer;
            document.getElementById('preview-paper-size-badge').innerText = paperSize;
            document.getElementById('preview-logo-icon').style.display = showLogo ? 'block' : 'none';
        }

        function saveReceiptSettingsSim() {
            updateLiveReceiptPreview();
            Swal.fire('Berhasil', 'Pengaturan struk dan notifikasi berhasil disimpan.', 'success');
        }

        // OTHER SIMULATIONS
        function openAddProductModal() {
            document.getElementById('add-product-modal').classList.remove('hidden');
        }
        function closeAddProductModal() {
            document.getElementById('add-product-modal').classList.add('hidden');
        }
        function saveProduct(e) {
            e.preventDefault();
            let newProd = {
                id: products.length + 1,
                name: document.getElementById('new-prod-name').value,
                sku: document.getElementById('new-prod-sku').value,
                barcode: document.getElementById('new-prod-barcode').value,
                category: document.getElementById('new-prod-cat').value,
                brand: document.getElementById('new-prod-brand').value,
                volume: document.getElementById('new-prod-vol').value,
                unit: document.getElementById('new-prod-unit').value,
                cost: parseInt(document.getElementById('new-prod-modal').value),
                retailPrice: parseInt(document.getElementById('new-prod-retail').value),
                wholesalePrice: parseInt(document.getElementById('new-prod-wholesale').value),
                agencyPrice: Math.round(parseInt(document.getElementById('new-prod-retail').value) * 0.9),
                active: true,
                image: 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80',
                stock: { 'Gudang Utama': 100, 'Depo Elang Utara': 0 }
            };
            products.push(newProd);
            closeAddProductModal();
            renderProducts();
            renderPOSCatalog();
            populateSelects();
            renderStockTable();
            Swal.fire('Berhasil', 'Produk Baru berhasil disimpan ke Master Data!', 'success');
        }

        function deleteProduct(id) {
            products = products.filter(p => p.id !== id);
            renderProducts();
            renderPOSCatalog();
        }

        function renderWarehouses() {
            let container = document.getElementById('warehouse-grid');
            container.innerHTML = '';
            warehouses.forEach(w => {
                container.innerHTML += `
                    <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-zinc-400 font-mono">${w.code}</span>
                            <i data-lucide="home" class="w-5 h-5 text-primary-dark"></i>
                        </div>
                        <h3 class="font-extrabold text-base">${w.name}</h3>
                        <p class="text-xs text-zinc-500">${w.address}</p>
                        <div class="border-t border-cream-dark pt-3 text-xs flex justify-between text-zinc-500 font-semibold">
                            <span>PIC: ${w.pic}</span>
                            <span class="text-green-600">Online</span>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function renderStockTable() {
            let table = document.getElementById('realtime-stock-table-body');
            table.innerHTML = '';
            products.forEach(p => {
                Object.keys(p.stock).forEach(gudang => {
                    let qty = p.stock[gudang];
                    let safetyLimit = p.category === 'Galon' ? 10 : 30;
                    let reorderPoint = safetyLimit * 1.5;
                    let shortage = qty <= safetyLimit ? '<span class="text-red-600 font-bold">Stok Kritis</span>' : (qty <= reorderPoint ? '<span class="text-yellow-600 font-semibold">Butuh Reorder</span>' : '<span class="text-green-600">Cukup</span>');

                    table.innerHTML += `
                        <tr class="hover:bg-cream/10">
                            <td class="py-3 px-4 font-bold text-zinc-900">${p.name}<p class="text-[10px] text-zinc-400">${p.sku}</p></td>
                            <td class="py-3 px-4 text-zinc-600">${gudang}</td>
                            <td class="py-3 px-4 font-black">${qty} ${p.unit}</td>
                            <td class="py-3 px-4 text-zinc-500">${safetyLimit} ${p.unit}</td>
                            <td class="py-3 px-4 text-zinc-500">${reorderPoint} ${p.unit}</td>
                            <td class="py-3 px-4">${shortage}</td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="adjustStockSim('${p.sku}', '${gudang}')" class="text-primary-dark hover:underline font-bold">Adjust</button>
                            </td>
                        </tr>
                    `;
                });
            });
        }

        function adjustStockSim(sku, warehouse) {
            Swal.fire({
                title: 'Stock Adjustment',
                text: `Masukkan jumlah stok fisik aktual untuk ${sku} di ${warehouse}`,
                input: 'number',
                inputAttributes: {
                    min: 0,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Sesuaikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    let p = products.find(prod => prod.sku === sku);
                    p.stock[warehouse] = parseInt(result.value);
                    renderStockTable();
                    renderDashboard();
                    Swal.fire('Berhasil', 'Stok berhasil disesuaikan di database!', 'success');
                }
            });
        }

        function renderTransfers() {
            let table = document.getElementById('transfer-stock-table-body');
            table.innerHTML = '';
            transfers.forEach(tf => {
                let statusBadge = tf.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${tf.code}</td>
                        <td class="py-3 px-4">${tf.from}</td>
                        <td class="py-3 px-4">${tf.to}</td>
                        <td class="py-3 px-4 font-semibold">${tf.item} (x${tf.qty})</td>
                        <td class="py-3 px-4 text-zinc-500">${tf.date}</td>
                        <td class="py-3 px-4"><span class="px-2.5 py-0.5 rounded text-[10px] font-bold ${statusBadge}">${tf.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            ${tf.status === 'Pending' ? `<button onclick="approveTransfer('${tf.code}')" class="bg-primary px-3 py-1 rounded font-bold text-[10px] text-zinc-900">Approve</button>` : '<span class="text-zinc-400">Selesai</span>'}
                        </td>
                    </tr>
                `;
            });
        }

        function openTransferModal() {
            document.getElementById('transfer-modal').classList.remove('hidden');
        }
        function closeTransferModal() {
            document.getElementById('transfer-modal').classList.add('hidden');
        }
        function saveTransfer(e) {
            e.preventDefault();
            let p = products.find(prod => prod.id == document.getElementById('tf-product').value);
            let qty = parseInt(document.getElementById('tf-qty').value);
            let from = document.getElementById('tf-source').value;
            let to = document.getElementById('tf-dest').value;

            if (p.stock[from] < qty) {
                Swal.fire('Stok Kurang', `Stok di ${from} tidak cukup untuk ditransfer.`, 'error');
                return;
            }

            transfers.unshift({
                code: 'TF-00' + (82 + transfers.length),
                from: from,
                to: to,
                item: p.name,
                qty: qty,
                date: new Date().toISOString().slice(0, 10),
                status: 'Pending'
            });

            closeTransferModal();
            renderTransfers();
            Swal.fire('Pemberitahuan', 'Permohonan transfer berhasil diajukan & menunggu persetujuan Admin!', 'info');
        }

        function approveTransfer(code) {
            let tf = transfers.find(t => t.code === code);
            let p = products.find(prod => prod.name === tf.item);

            if (p.stock[tf.from] >= tf.qty) {
                p.stock[tf.from] -= tf.qty;
                p.stock[tf.to] += tf.qty;
                tf.status = 'Approved';

                renderTransfers();
                renderStockTable();
                renderDashboard();
                Swal.fire('Disetujui', 'Transfer stok berhasil divalidasi & stok terupdate!', 'success');
            } else {
                Swal.fire('Gagal', 'Stok gudang asal sudah tidak mencukupi untuk transfer ini.', 'error');
            }
        }

        function renderOpnameTable() {
            let table = document.getElementById('opname-table-body');
            table.innerHTML = '';
            opnames.forEach(op => {
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${op.code}</td>
                        <td class="py-3 px-4">${op.warehouse}</td>
                        <td class="py-3 px-4 font-semibold">${op.item}</td>
                        <td class="py-3 px-4 text-center font-semibold text-zinc-500">${op.bookStock}</td>
                        <td class="py-3 px-4 text-center font-bold text-zinc-950">${op.physicalStock}</td>
                        <td class="py-3 px-4 text-center font-bold ${op.diff === 0 ? 'text-green-600' : 'text-red-500'}">${op.diff}</td>
                        <td class="py-3 px-4 text-zinc-500">${op.remark}</td>
                        <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">${op.status}</span></td>
                    </tr>
                `;
            });
        }

        function openOpnameModal() {
            Swal.fire({
                title: 'Buat Opname Gudang',
                html: `
                    <select id="opname-wh" class="swal2-input">
                        <option>Gudang Utama</option>
                        <option>Depo Elang Utara</option>
                    </select>
                    <select id="opname-prod" class="swal2-input">
                        ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                    </select>
                    <input id="opname-phys" class="swal2-input" type="number" placeholder="Jumlah Fisik Aktual">
                    <input id="opname-desc" class="swal2-input" type="text" placeholder="Keterangan / Alasan Selisih">
                `,
                preConfirm: () => {
                    return {
                        wh: document.getElementById('opname-wh').value,
                        prodId: document.getElementById('opname-prod').value,
                        phys: parseInt(document.getElementById('opname-phys').value),
                        desc: document.getElementById('opname-desc').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let val = result.value;
                    let p = products.find(prod => prod.id == val.prodId);
                    let bookVal = p.stock[val.wh] || 0;
                    let diff = val.phys - bookVal;

                    opnames.unshift({
                        code: 'OP-00' + (6 + opnames.length),
                        warehouse: val.wh,
                        item: p.name,
                        bookStock: bookVal,
                        physicalStock: val.phys,
                        diff: diff,
                        remark: val.desc || 'Stock Opname Bulanan',
                        status: 'Approved'
                    });

                    // Update stock
                    p.stock[val.wh] = val.phys;

                    renderOpnameTable();
                    renderStockTable();
                    renderDashboard();
                    Swal.fire('Opname Berhasil', 'Stok buku telah disesuaikan dengan stok fisik!', 'success');
                }
            });
        }

        function renderIncomingStock() {
            let table = document.getElementById('incoming-stock-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">IN-2026-0044</td>
                    <td class="py-3 px-4">23 Juni 2026</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 text-green-700 font-bold">Pembelian Supplier</td>
                    <td class="py-3 px-4">Bahan Kemasan Galon Kosong (1.000 Pcs)</td>
                    <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">Telah Diterima</span></td>
                </tr>
            `;
        }

        function renderOutgoingStock() {
            let table = document.getElementById('outgoing-stock-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 font-mono font-bold">OUT-2026-0099</td>
                    <td class="py-3 px-4">23 Juni 2026</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 text-blue-700 font-bold">DO Pelanggan</td>
                    <td class="py-3 px-4">Galon Elangwater 19L (150 Pcs)</td>
                    <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold text-[10px]">Sedang Dikirim</span></td>
                </tr>
            `;
        }

        function renderKartuStok() {
            let table = document.getElementById('kartu-stok-table-body');
            table.innerHTML = `
                <tr>
                    <td class="py-3 px-4 text-zinc-500">23 Jun 2026 10:48</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 font-bold">ELG-GAL-19L</td>
                    <td class="py-3 px-4">Mutasi Kirim ke Depo Utara (TF-0081)</td>
                    <td class="py-3 px-4 text-center">-</td>
                    <td class="py-3 px-4 text-center text-red-500 font-bold">100</td>
                    <td class="py-3 px-4 text-right font-bold">850</td>
                </tr>
                <tr>
                    <td class="py-3 px-4 text-zinc-500">23 Jun 2026 10:30</td>
                    <td class="py-3 px-4">Gudang Utama</td>
                    <td class="py-3 px-4 font-bold">ELG-GAL-19L</td>
                    <td class="py-3 px-4">Penjualan POS Kasir Shift Pagi</td>
                    <td class="py-3 px-4 text-center">-</td>
                    <td class="py-3 px-4 text-center text-red-500 font-bold">15</td>
                    <td class="py-3 px-4 text-right font-bold">950</td>
                </tr>
            `;
        }

        function filterKartuStok() {
            let sku = document.getElementById('kartu-stok-sku-filter').value;
            Swal.fire('Filter Berhasil', `Memfilter log pergerakan stok untuk SKU: ${sku || 'Semua'}`, 'info');
        }

        function renderCustomers() {
            let table = document.getElementById('customer-table-body');
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
                    populateSelects();
                    Swal.fire('Berhasil', 'Pelanggan baru terdaftar!', 'success');
                }
            });
        }

        function renderSuppliers() {
            let table = document.getElementById('supplier-table-body');
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

        function renderPembelian() {
            let table = document.getElementById('po-table-body');
            table.innerHTML = '';
            purchasing.forEach((po, idx) => {
                let badgeClass = po.status === 'Received' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${po.poNo}</td>
                        <td class="py-3 px-4 font-semibold">${po.supplier}</td>
                        <td class="py-3 px-4 text-zinc-500">${po.date}</td>
                        <td class="py-3 px-4 text-zinc-600">${po.item}</td>
                        <td class="py-3 px-4 font-extrabold">Rp ${po.totalCost.toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${badgeClass}">${po.status}</span></td>
                        <td class="py-3 px-4 text-right">
                            ${po.status === 'Approved' ? `<button onclick="receiveGoodsSim('${po.poNo}')" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Receive Barang</button>` : '<span class="text-zinc-400">Received</span>'}
                        </td>
                    </tr>
                `;
            });
        }

        function openPOModal() {
            Swal.fire({
                title: 'Buat Pre-Order Pembelian',
                html: `
                    <select id="po-supp" class="swal2-input">
                        ${suppliers.map(s => `<option>${s.name}</option>`).join('')}
                    </select>
                    <input id="po-item" class="swal2-input" placeholder="Item / Deskripsi (e.g. 5.000 Pcs Tutup Galon)">
                    <input id="po-cost" class="swal2-input" type="number" placeholder="Estimasi Total Biaya (Rupiah)">
                `,
                preConfirm: () => {
                    return {
                        supplier: document.getElementById('po-supp').value,
                        item: document.getElementById('po-item').value,
                        cost: parseInt(document.getElementById('po-cost').value)
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    purchasing.unshift({
                        poNo: 'PO-2026-0' + (14 + purchasing.length),
                        supplier: res.value.supplier,
                        date: new Date().toISOString().slice(0, 10),
                        item: res.value.item,
                        totalCost: res.value.cost,
                        status: 'Approved'
                    });
                    renderPembelian();
                    Swal.fire('PO Diajukan', 'PO berhasil dibuat & menunggu barang datang dari supplier!', 'success');
                }
            });
        }

        function receiveGoodsSim(poNo) {
            let po = purchasing.find(p => p.poNo === poNo);
            po.status = 'Received';
            renderPembelian();
            renderIncomingStock();

            // Add to debts
            let sup = suppliers.find(s => s.name === po.supplier);
            if (sup) sup.debt += po.totalCost;
            renderSuppliers();
            renderKeuanganHutang();

            Swal.fire('Barang Diterima', 'Persediaan gudang ter-update dan hutang outstanding supplier dicatat!', 'success');
        }

        function renderDO() {
            let table = document.getElementById('do-table-body');
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
                    renderBuktiKirim();
                    Swal.fire('DO Berhasil', 'DO telah dibuat dan siap dikirim oleh Driver!', 'success');
                }
            });
        }

        function updateDOStatus(doNo) {
            let doItem = deliverOrders.find(d => d.doNo === doNo);
            doItem.status = 'Selesai';
            renderDO();
            renderBuktiKirim();
            Swal.fire('Selesai', 'Status pengiriman berhasil diselesaikan!', 'success');
        }

        function renderBuktiKirim() {
            let table = document.getElementById('bukti-kirim-table-body');
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
                updateDOStatus(doNo);
            });
            lucide.createIcons();
        }

        function renderKeuanganKas() {
            let table = document.getElementById('keu-kas-table-body');
            table.innerHTML = '';
            cashFlow.forEach(j => {
                let badgeClass = j.type === 'Masuk' ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50';
                table.innerHTML += `
                    <tr>
                        <td class="py-3 px-4 font-mono font-bold">${j.journalNo}</td>
                        <td class="py-3 px-4 text-zinc-500">${j.date}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-bold text-[10px] ${badgeClass}">${j.type}</span></td>
                        <td class="py-3 px-4 font-semibold">${j.category}</td>
                        <td class="py-3 px-4 text-zinc-600">${j.remark}</td>
                        <td class="py-3 px-4 text-right font-black ${j.type === 'Masuk' ? 'text-green-600' : 'text-red-500'}">
                            Rp ${j.amount.toLocaleString('id-ID')}
                        </td>
                    </tr>
                `;
            });
        }

        function openCashFlowModal() {
            Swal.fire({
                title: 'Catat Kas Arus Keuangan',
                html: `
                    <select id="cash-type" class="swal2-input">
                        <option value="Masuk">Kas Masuk (Pemasukan)</option>
                        <option value="Keluar">Kas Keluar (Pengeluaran)</option>
                    </select>
                    <input id="cash-cat" class="swal2-input" placeholder="Kategori Kas (e.g. Listrik, Operasional, POS)">
                    <input id="cash-desc" class="swal2-input" placeholder="Keterangan Rinci">
                    <input id="cash-amt" class="swal2-input" type="number" placeholder="Jumlah Rupiah">
                `,
                preConfirm: () => {
                    return {
                        type: document.getElementById('cash-type').value,
                        category: document.getElementById('cash-cat').value,
                        remark: document.getElementById('cash-desc').value,
                        amount: parseInt(document.getElementById('cash-amt').value)
                    }
                }
            }).then(res => {
                if (res.isConfirmed) {
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: res.value.type,
                        category: res.value.category,
                        remark: res.value.remark,
                        amount: res.value.amount
                    });
                    renderKeuanganKas();
                    Swal.fire('Tercatat', 'Arus kas berhasil dibukukan!', 'success');
                }
            });
        }

        function renderKeuanganTagihan() {
            let table = document.getElementById('keu-tagihan-table-body');
            table.innerHTML = '';
            customers.forEach((c, idx) => {
                if (c.debt > 0) {
                    table.innerHTML += `
                        <tr>
                            <td class="py-3 px-4 font-mono font-bold">INV-2026-003${idx}</td>
                            <td class="py-3 px-4 font-semibold">${c.name}</td>
                            <td class="py-3 px-4 font-black text-red-500">Rp ${c.debt.toLocaleString('id-ID')}</td>
                            <td class="py-3 px-4 text-zinc-500">30 Juni 2026</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold text-[10px]">Overdue</span></td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="payPiutangSim(${idx})" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Pelunasan</button>
                            </td>
                        </tr>
                    `;
                }
            });
        }

        function payPiutangSim(customerIdx) {
            let c = customers[customerIdx];
            Swal.fire({
                title: 'Konfirmasi Pembayaran Piutang',
                text: `Apakah customer ${c.name} melunasi tagihan sebesar Rp ${c.debt.toLocaleString('id-ID')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lunas'
            }).then(res => {
                if (res.isConfirmed) {
                    // add cash flow
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: 'Masuk',
                        category: 'Pelunasan Piutang',
                        remark: 'Pelunasan dari ' + c.name,
                        amount: c.debt
                    });
                    c.debt = 0;
                    renderKeuanganTagihan();
                    renderKeuanganKas();
                    renderCustomers();
                    Swal.fire('Lunas', 'Piutang customer berhasil dinolkan dan tercatat di kas masuk!', 'success');
                }
            });
        }

        function renderKeuanganHutang() {
            let table = document.getElementById('keu-hutang-table-body');
            table.innerHTML = '';
            suppliers.forEach((s, idx) => {
                if (s.debt > 0) {
                    table.innerHTML += `
                        <tr>
                            <td class="py-3 px-4 font-mono font-bold">PO-REF-00${idx}</td>
                            <td class="py-3 px-4 font-semibold">${s.name}</td>
                            <td class="py-3 px-4 font-black text-red-500">Rp ${s.debt.toLocaleString('id-ID')}</td>
                            <td class="py-3 px-4 text-zinc-500">28 Juni 2026</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold text-[10px]">Outstanding</span></td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="payHutangSim(${idx})" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Bayar Hutang</button>
                            </td>
                        </tr>
                    `;
                }
            });
        }

        function payHutangSim(supIdx) {
            let s = suppliers[supIdx];
            Swal.fire({
                title: 'Konfirmasi Pembayaran Hutang',
                text: `Apakah Anda ingin melunasi hutang ke ${s.name} sebesar Rp ${s.debt.toLocaleString('id-ID')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Bayar'
            }).then(res => {
                if (res.isConfirmed) {
                    cashFlow.unshift({
                        journalNo: 'JRN-2026-0' + (47 + cashFlow.length),
                        date: new Date().toISOString().slice(0, 10),
                        type: 'Keluar',
                        category: 'Pelunasan Hutang',
                        remark: 'Pelunasan Hutang ke ' + s.name,
                        amount: s.debt
                    });
                    s.debt = 0;
                    renderKeuanganHutang();
                    renderKeuanganKas();
                    renderSuppliers();
                    Swal.fire('Lunas', 'Hutang supplier berhasil dilunasi!', 'success');
                }
            });
        }

        // LAPORAN SUBTAB
        function switchLaporanSubTab(paneId, defaultReport) {
            document.querySelectorAll('.laporan-sub-pane').forEach(p => p.classList.add('hidden'));
            document.getElementById(paneId).classList.remove('hidden');

            document.querySelectorAll('.laporan-subtab-btn').forEach(btn => {
                btn.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream";
            });
            event.target.className = "laporan-subtab-btn flex-1 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm";

            let category = paneId.replace('laporan-', '');
            let selectId = '';
            if (category === 'penjualan') selectId = 'sel-rep-sales';
            else if (category === 'inventori') selectId = 'sel-rep-inv';
            else if (category === 'pembelian') selectId = 'sel-rep-buy';
            else if (category === 'pelanggan') selectId = 'sel-rep-cust';
            else if (category === 'keuangan') selectId = 'sel-rep-fin';

            if (selectId) {
                let sel = document.getElementById(selectId);
                sel.value = defaultReport;
                loadReport(category, defaultReport);
            }
        }

        // DYNAMIC REPORT GENERATOR
        function loadReport(category, reportType) {
            let containerId = 'table-rep-' + (category === 'penjualan' ? 'sales' : (category === 'inventori' ? 'inv' : (category === 'pembelian' ? 'buy' : (category === 'pelanggan' ? 'cust' : 'fin')))) + '-container';
            let container = document.getElementById(containerId);
            if (!container) return;

            let html = '';

            // GENERATE CORRESPONDING MOCK REPORT TABLES
            if (category === 'penjualan') {
                if (reportType === 'penjualan-harian') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3 text-center">Jumlah Transaksi</th>
                                    <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Diskon</th>
                                    <th class="py-2.5 px-3 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">23 Juni 2026</td><td class="py-2 px-3 text-center">42</td><td class="py-2 px-3 text-center">210 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 120.000</td><td class="py-2 px-3 text-right font-bold">Rp 12.450.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">22 Juni 2026</td><td class="py-2 px-3 text-center">38</td><td class="py-2 px-3 text-center">180 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 85.000</td><td class="py-2 px-3 text-right font-bold">Rp 9.850.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-semibold">21 Juni 2026</td><td class="py-2 px-3 text-center">50</td><td class="py-2 px-3 text-center">245 Pcs</td><td class="py-2 px-3 text-right text-red-500">Rp 150.000</td><td class="py-2 px-3 text-right font-bold">Rp 14.200.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-bulanan') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Bulan</th>
                                    <th class="py-2.5 px-3 text-center">Total Transaksi</th>
                                    <th class="py-2.5 px-3">Paling Laku</th>
                                    <th class="py-2.5 px-3 text-right">Rata-Rata Harian</th>
                                    <th class="py-2.5 px-3 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">Juni 2026</td><td class="py-2.5 px-3 text-center">980</td><td class="py-2.5 px-3">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-right">Rp 2.500.000</td><td class="py-2.5 px-3 text-right font-bold">Rp 75.400.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">Mei 2026</td><td class="py-2.5 px-3 text-center">910</td><td class="py-2.5 px-3">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-right">Rp 2.190.000</td><td class="py-2.5 px-3 text-right font-bold">Rp 68.000.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-tahunan') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tahun</th>
                                    <th class="py-2.5 px-3 text-center">Total Penjualan</th>
                                    <th class="py-2.5 px-3 text-center">Pertumbuhan</th>
                                    <th class="py-2.5 px-3 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">2026 (YTD)</td><td class="py-2.5 px-3 text-center">5.420 Transaksi</td><td class="py-2.5 px-3 text-center text-green-600 font-bold">+18%</td><td class="py-2.5 px-3 text-right font-bold">Rp 412.000.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-semibold">2025</td><td class="py-2.5 px-3 text-center">10.890 Transaksi</td><td class="py-2.5 px-3 text-center text-green-600 font-bold">+24%</td><td class="py-2.5 px-3 text-right font-bold">Rp 820.500.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-sku') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${products.map(p => `
                                    <tr class="border-b border-cream/50">
                                        <td class="py-2 px-3 font-mono">${p.sku}</td>
                                        <td class="py-2 px-3 font-bold">${p.name}</td>
                                        <td class="py-2 px-3">${p.category}</td>
                                        <td class="py-2 px-3 text-center">1.280 Pcs</td>
                                        <td class="py-2 px-3 text-right font-bold">Rp ${(p.retailPrice * 1280).toLocaleString('id-ID')}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-kategori') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Jumlah SKU</th>
                                    <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Galon</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">1.820 Galon</td><td class="py-2.5 px-3 text-right font-bold">Rp 27.300.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Botol</td><td class="py-2.5 px-3 text-center">2</td><td class="py-2.5 px-3 text-center">1.670 Box</td><td class="py-2.5 px-3 text-right font-bold">Rp 65.140.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Gelas</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">80 Box</td><td class="py-2.5 px-3 text-right font-bold">Rp 1.920.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-brand') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Brand</th>
                                    <th class="py-2.5 px-3 text-center">Qty Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Elangwater</td><td class="py-2.5 px-3 text-center">3.570 Unit</td><td class="py-2.5 px-3 text-right font-bold">Rp 94.360.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'penjualan-customer') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Nama Customer</th>
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Total Transaksi</th>
                                    <th class="py-2.5 px-3 text-right">Nilai Belanja</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${customers.map(c => `
                                    <tr class="border-b border-cream/50">
                                        <td class="py-2.5 px-3 font-bold">${c.name}</td>
                                        <td class="py-2.5 px-3">${c.type}</td>
                                        <td class="py-2.5 px-3 text-center">${c.spend > 0 ? 12 : 0} kali</td>
                                        <td class="py-2.5 px-3 text-right font-bold">Rp ${c.spend.toLocaleString('id-ID')}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'produk-terlaris') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3 text-center">Rank</th>
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Total Qty Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#1</td><td class="py-2.5 px-3 font-mono">ELG-GAL-19L</td><td class="py-2.5 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2.5 px-3 text-center font-bold">1.820 Galon</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Fast Moving</span></td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#2</td><td class="py-2.5 px-3 font-mono">ELG-BOT-600M</td><td class="py-2.5 px-3 font-bold">Botol Elangwater 600ml</td><td class="py-2.5 px-3 text-center font-bold">1.250 Box</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Fast Moving</span></td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'produk-kurang-laku') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3 text-center">Rank</th>
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Stok Mengendap</th>
                                    <th class="py-2.5 px-3 text-right">Terjual 30 Hari Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-red-500">#1</td><td class="py-2.5 px-3 font-mono">ELG-CUP-240M</td><td class="py-2.5 px-3 font-bold">Gelas Elangwater 240ml</td><td class="py-2.5 px-3 text-center font-semibold text-red-500">27 Box</td><td class="py-2.5 px-3 text-right font-bold text-zinc-500">80 Box</td></tr>
                            </tbody>
                        </table>
                    `;
                }
            } else if (category === 'inventori') {
                if (reportType === 'stok-tanggal') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Stok Awal</th>
                                    <th class="py-2.5 px-3 text-center">Stok Masuk</th>
                                    <th class="py-2.5 px-3 text-center">Stok Keluar</th>
                                    <th class="py-2.5 px-3 text-right">Stok Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center">950</td><td class="py-2 px-3 text-center">0</td><td class="py-2 px-3 text-center">98</td><td class="py-2 px-3 text-right font-bold">852</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">22 Juni 2026</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center">880</td><td class="py-2 px-3 text-center">150</td><td class="py-2 px-3 text-center">80</td><td class="py-2 px-3 text-right font-bold">950</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'stok-masuk') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Ref Penerimaan</th>
                                    <th class="py-2.5 px-3">Supplier/Asal</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Qty Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-mono font-bold">IN-2026-0044</td><td class="py-2 px-3">PT Kemasan Plastik Indonesia</td><td class="py-2 px-3 font-bold">Botol Kosong 600ml</td><td class="py-2 px-3 text-center font-bold text-green-600">10.000 Pcs</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'stok-keluar') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Ref DO/TRX</th>
                                    <th class="py-2.5 px-3">Tujuan/Pelanggan</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Qty Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-mono">DO-2026-092</td><td class="py-2 px-3">Toko Makmur Sejahtera</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center font-bold text-red-500">150 Pcs</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'qty-produk-keluar') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Total Keluar</th>
                                    <th class="py-2.5 px-3 text-right">Rata-rata / Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-center font-bold">1.820 Galon</td><td class="py-2 px-3 text-right">60 Galon</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'sisa-stok') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3">Gudang</th>
                                    <th class="py-2.5 px-3 text-center">Sisa Qty</th>
                                    <th class="py-2.5 px-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${products.map(p => `
                                    <tr class="border-b border-cream/50">
                                        <td class="py-2 px-3 font-mono">${p.sku}</td>
                                        <td class="py-2 px-3 font-bold">${p.name}</td>
                                        <td class="py-2 px-3">Gudang Utama</td>
                                        <td class="py-2 px-3 text-center font-extrabold">${p.stock['Gudang Utama']} ${p.unit}</td>
                                        <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[9px] font-bold">Tersedia</span></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'sisa-stok-grup') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Total Item SKU</th>
                                    <th class="py-2.5 px-3 text-center">Total Qty Tersisa</th>
                                    <th class="py-2.5 px-3 text-right">Valuation HPP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Galon</td><td class="py-2 px-3 text-center">1</td><td class="py-2 px-3 text-center">852 Galon</td><td class="py-2 px-3 text-right font-bold">Rp 6.816.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Botol</td><td class="py-2 px-3 text-center">2</td><td class="py-2 px-3 text-center">255 Box</td><td class="py-2 px-3 text-right font-bold">Rp 6.980.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'usia-stok') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3">Tanggal Masuk Pertama</th>
                                    <th class="py-2.5 px-3 text-center">Usia Stok (Hari)</th>
                                    <th class="py-2.5 px-3 text-right">Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3">15 Juni 2026</td><td class="py-2 px-3 text-center font-bold text-green-600">8 Hari</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-green-50 text-green-800 rounded font-semibold text-[10px]">Rotasi Normal</span></td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-CUP-240M</td><td class="py-2 px-3 font-bold">Gelas Elangwater 240ml</td><td class="py-2 px-3">10 Mei 2026</td><td class="py-2 px-3 text-center font-bold text-red-500">44 Hari</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded font-bold text-[10px]">Cuci Gudang / Diskon</span></td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'pergerakan-stok') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Waktu</th>
                                    <th class="py-2.5 px-3">SKU / Produk</th>
                                    <th class="py-2.5 px-3">Gudang</th>
                                    <th class="py-2.5 px-3">Aktivitas</th>
                                    <th class="py-2.5 px-3 text-center">Qty Selisih</th>
                                    <th class="py-2.5 px-3 text-right">Saldo Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Jun 10:48</td><td class="py-2 px-3 font-bold">ELG-GAL-19L</td><td class="py-2 px-3">Gudang Utama</td><td class="py-2 px-3">Mutasi Transfer Gudang</td><td class="py-2 px-3 text-center text-red-500 font-bold">-100</td><td class="py-2 px-3 text-right font-bold">850</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'value-pergerakan') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Bulan</th>
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-right">Value Masuk (HPP)</th>
                                    <th class="py-2.5 px-3 text-right">Value Keluar (HPP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">Juni 2026</td><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-right text-green-600 font-bold">Rp 12.000.000</td><td class="py-2 px-3 text-right text-red-500 font-bold">Rp 9.600.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'peringatan-stok') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-center">Stok Aktual</th>
                                    <th class="py-2.5 px-3 text-center">Safety Stock</th>
                                    <th class="py-2.5 px-3 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L (Depo Utara)</td><td class="py-2 px-3 text-center text-red-500 font-bold">2 Pcs</td><td class="py-2.5 px-3 text-center">10 Pcs</td><td class="py-2 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-[9px] font-black uppercase">REORDER POINT</span></td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'fifo-compare') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Batch ID</th>
                                    <th class="py-2.5 px-3">Tanggal Masuk</th>
                                    <th class="py-2.5 px-3 text-right">Harga Beli Batch</th>
                                    <th class="py-2.5 px-3 text-right">Sisa Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">BATCH-0881</td><td class="py-2 px-3">15 Juni 2026</td><td class="py-2 px-3 text-right">Rp 8.000</td><td class="py-2 px-3 text-right font-bold">850 Pcs</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'perubahan-harga') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-right">Harga Lama</th>
                                    <th class="py-2.5 px-3 text-right">Harga Baru</th>
                                    <th class="py-2.5 px-3 text-right">Diubah Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">20 Juni 2026</td><td class="py-2 px-3 font-mono">ELG-GAL-19L</td><td class="py-2 px-3 font-bold">Galon Elangwater 19L</td><td class="py-2 px-3 text-right">Rp 14.500</td><td class="py-2 px-3 text-right text-green-700 font-bold">Rp 15.000</td><td class="py-2 px-3 text-right">admin.elang</td></tr>
                            </tbody>
                        </table>
                    `;
                }
            } else if (category === 'pembelian') {
                if (reportType === 'pembelian-supplier') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Supplier</th>
                                    <th class="py-2.5 px-3 text-center">Total PO Selesai</th>
                                    <th class="py-2.5 px-3 text-center">Total Qty Bahan</th>
                                    <th class="py-2.5 px-3 text-right">Total Belanja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">PT Kemasan Plastik Indonesia</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">10.000 Pcs</td><td class="py-2.5 px-3 text-right font-extrabold">Rp 15.000.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">CV Sumber Mata Air Pegunungan</td><td class="py-2.5 px-3 text-center">1</td><td class="py-2.5 px-3 text-center">10.000L</td><td class="py-2.5 px-3 text-right font-extrabold">Rp 4.000.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'pembelian-produk') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">SKU</th>
                                    <th class="py-2.5 px-3">Nama Produk</th>
                                    <th class="py-2.5 px-3">Supplier Utama</th>
                                    <th class="py-2.5 px-3 text-center">Total Qty Dibeli</th>
                                    <th class="py-2.5 px-3 text-right">Total Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-mono">ELG-BOT-600M</td><td class="py-2 px-3 font-bold">Botol Elangwater 600ml</td><td class="py-2 px-3">PT Kemasan Plastik Indonesia</td><td class="py-2 px-3 text-center font-bold">10.000 Pcs</td><td class="py-2 px-3 text-right font-bold">Rp 15.000.000</td></tr>
                            </tbody>
                        </table>
                    `;
                }
            } else if (category === 'pelanggan') {
                if (reportType === 'top-customer') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3 text-center">Rank</th>
                                    <th class="py-2.5 px-3">Nama Customer</th>
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-center">Total Kunjungan/Order</th>
                                    <th class="py-2.5 px-3 text-right">Akumulasi Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#1</td><td class="py-2.5 px-3 font-bold">Toko Makmur Sejahtera</td><td class="py-2.5 px-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded font-bold">Distributor</span></td><td class="py-2.5 px-3 text-center">45 kali</td><td class="py-2.5 px-3 text-right font-bold text-green-700">Rp 48.900.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 text-center font-bold text-green-600">#2</td><td class="py-2.5 px-3 font-bold">Budi Agen Air Lestari</td><td class="py-2.5 px-3"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded font-bold">Agen</span></td><td class="py-2.5 px-3 text-center">28 kali</td><td class="py-2.5 px-3 text-right font-bold text-green-700">Rp 15.200.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'customer-aktif') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Nama Customer</th>
                                    <th class="py-2.5 px-3 font-mono">No. Telp</th>
                                    <th class="py-2.5 px-3">Terakhir Belanja</th>
                                    <th class="py-2.5 px-3 text-right font-bold">Status Keaktifan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Toko Makmur Sejahtera</td><td class="py-2.5 px-3 font-mono">081299887711</td><td class="py-2.5 px-3">23 Juni 2026</td><td class="py-2.5 px-3 text-right"><span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded font-bold">AKTIF</span></td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Budi Agen Air Lestari</td><td class="py-2.5 px-3 font-mono">085711223344</td><td class="py-2.5 px-3">22 Juni 2026</td><td class="py-2.5 px-3 text-right"><span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded font-bold">AKTIF</span></td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'customer-tidak-aktif') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Nama Customer</th>
                                    <th class="py-2.5 px-3">Terakhir Transaksi</th>
                                    <th class="py-2.5 px-3 text-center">Hari Tidak Aktif</th>
                                    <th class="py-2.5 px-3 text-right">Rekomendasi Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2.5 px-3 font-bold">Depo Air Tirta (Toko)</td><td class="py-2.5 px-3 text-zinc-500">12 Maret 2026</td><td class="py-2.5 px-3 text-center font-bold text-red-500">103 Hari</td><td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded font-bold text-[9px]">Hubungi Driver/Sales</span></td></tr>
                            </tbody>
                        </table>
                    `;
                }
            } else if (category === 'keuangan') {
                if (reportType === 'arus-kas') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Kategori Kas</th>
                                    <th class="py-2.5 px-3">Keterangan</th>
                                    <th class="py-2.5 px-3 text-right">Kas Masuk</th>
                                    <th class="py-2.5 px-3 text-right">Kas Keluar</th>
                                    <th class="py-2.5 px-3 text-right">Saldo Berjalan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-semibold">Penjualan POS</td><td class="py-2 px-3">Penjualan Tunai / Bank</td><td class="py-2 px-3 text-right text-green-600 font-bold">Rp 12.450.000</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right font-black">Rp 15.700.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">23 Juni 2026</td><td class="py-2 px-3 font-semibold">Operasional</td><td class="py-2 px-3">Beli Bensin Delivery</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">Rp 250.000</td><td class="py-2 px-3 text-right font-black">Rp 3.250.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'pendapatan') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Sumber Pendapatan</th>
                                    <th class="py-2.5 px-3">Metode Pembayaran</th>
                                    <th class="py-2.5 px-3 text-center">Jumlah Transaksi</th>
                                    <th class="py-2.5 px-3 text-right">Total Bersih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Penjualan Retail Kasir</td><td class="py-2 px-3">Cash / Tunai</td><td class="py-2 px-3 text-center">31</td><td class="py-2 px-3 text-right font-bold text-green-700">Rp 3.500.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Penjualan Agen & Toko</td><td class="py-2 px-3">Transfer / QRIS</td><td class="py-2 px-3 text-center">11</td><td class="py-2 px-3 text-right font-bold text-green-700">Rp 8.950.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'pengeluaran') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Kategori Pengeluaran</th>
                                    <th class="py-2.5 px-3">Tanggal Jurnal</th>
                                    <th class="py-2.5 px-3">Keterangan</th>
                                    <th class="py-2.5 px-3 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Operasional Kendaraan</td><td class="py-2 px-3 text-zinc-500">23 Juni 2026</td><td class="py-2 px-3 text-zinc-600">Beli Bensin Delivery Truck</td><td class="py-2 px-3 text-right font-bold text-red-500">Rp 250.000</td></tr>
                            </tbody>
                        </table>
                    `;
                } else if (reportType === 'laba-rugi') {
                    html = `
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-cream-dark font-bold text-zinc-500 bg-cream/40">
                                    <th class="py-2.5 px-3">Komponen Keuangan</th>
                                    <th class="py-2.5 px-3 text-right">Pemasukan (Rp)</th>
                                    <th class="py-2.5 px-3 text-right">Pengeluaran (Rp)</th>
                                    <th class="py-2.5 px-3 text-right">Subtotal / Laba Bersih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3 font-bold">Pendapatan Penjualan Kotor</td><td class="py-2 px-3 text-right text-green-600 font-bold">75.400.000</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right">-</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">(-) Harga Pokok Penjualan (HPP)</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">42.150.000</td><td class="py-2 px-3 text-right">-</td></tr>
                                <tr class="border-b border-cream/50 bg-cream-dark/30"><td class="py-2 px-3 font-black text-sm">LABA KOTOR</td><td class="py-2 px-3 text-right font-bold">-</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right font-black text-sm">33.250.000</td></tr>
                                <tr class="border-b border-cream/50"><td class="py-2 px-3">(-) Pengeluaran Operasional & Gaji</td><td class="py-2 px-3 text-right">-</td><td class="py-2 px-3 text-right text-red-500">16.200.000</td><td class="py-2 px-3 text-right">-</td></tr>
                                <tr class="border-b border-cream/50 bg-green-50"><td class="py-2.5 px-3 font-extrabold text-sm text-green-800">LABA BERSIH (NET PROFIT)</td><td class="py-2 px-3 text-right font-bold">-</td><td class="py-2 px-3 text-right">-</td><td class="py-2.5 px-3 text-right font-black text-green-700 text-sm">Rp 17.050.000</td></tr>
                            </tbody>
                        </table>
                    `;
                }
            }

            container.innerHTML = html;
            // Ensure dynamically injected tables are horizontally scrollable
            // and have a minimum width for consistent responsive behavior.
            try {
                container.querySelectorAll('table').forEach(t => {
                    if (!/min-w-\[/.test(t.className)) t.classList.add('min-w-[640px]');
                });
            } catch (e) {
                // silent fallback if DOM operations fail
                console.warn('loadReport: could not normalize table widths', e);
            }
            lucide.createIcons();
        }

        // NOTIFICATIONS
        function showNotificationCenter() {
            Swal.fire({
                title: 'Pemberitahuan Sistem 🔔',
                html: `
                    <div class="text-left space-y-2 text-xs">
                        <div class="p-2.5 bg-red-50 border-l-4 border-red-500 rounded">
                            <span class="font-bold">Stok Kritis:</span> Galon Elangwater 19L sisa 2 pcs di Depo Elang Utara.
                        </div>
                        <div class="p-2.5 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                            <span class="font-bold">Tagihan Overdue:</span> Toko Makmur Sejahtera (Rp 4.500.000) jatuh tempo.
                        </div>
                        <div class="p-2.5 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <span class="font-bold">Transfer Pending:</span> 1 mutasi antar gudang menunggu persetujuan.
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false
            });
        }

        // CHARTS INITIALIZATION
        let salesChartRef, reportSalesChartRef, reportPurchaseChartRef;

        function initCharts() {
            // Main Dashboard Sales Tren
            const ctx1 = document.getElementById('salesChart').getContext('2d');
            salesChartRef = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Penjualan (Juta Rp)',
                        data: [8.5, 9.2, 7.8, 11.2, 12.4, 15.0, 10.5],
                        borderColor: '#E2AD3B',
                        backgroundColor: 'rgba(248, 194, 78, 0.2)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Laporan Sales Tren
            const ctx2 = document.getElementById('reportSalesChart').getContext('2d');
            reportSalesChartRef = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Omset Bulanan (Juta Rp)',
                        data: [48, 52, 60, 58, 68, 75],
                        backgroundColor: '#F8C24E',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Laporan Purchases
            const ctx3 = document.getElementById('reportPurchaseChart').getContext('2d');
            reportPurchaseChartRef = new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: ['PT Kemasan Plastik', 'CV Sumber Mata Air', 'Lain-Lain'],
                    datasets: [{
                        data: [12.5, 32.0, 4.5],
                        backgroundColor: ['#FCE1A2', '#F8C24E', '#E2AD3B']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elang Water POS & ERP</title>
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

    <!-- User Permissions and Roles for Frontend Access Control -->
    <script>
        window.userPermissions = @json($user->getAllPermissions()->pluck('name')->toArray());
        window.userRoles = @json($user->getRoleNames()->toArray());
    </script>

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
            @yield('content')
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

        // Access Control Functions
        function hasPermission(permission) {
            return window.userPermissions && window.userPermissions.includes(permission);
        }

        function hasRole(role) {
            return window.userRoles && window.userRoles.includes(role);
        }

        function applyAccessControl() {
            // Hide/show elements based on permissions
            document.querySelectorAll('[data-permission]').forEach(element => {
                const permission = element.getAttribute('data-permission');
                if (!hasPermission(permission)) {
                    element.style.display = 'none';
                }
            });

            // Hide/show elements based on roles
            document.querySelectorAll('[data-role]').forEach(element => {
                const role = element.getAttribute('data-role');
                if (!hasRole(role)) {
                    element.style.display = 'none';
                }
            });

            // Disable interactive elements based on permissions
            document.querySelectorAll('[data-permission-disabled]').forEach(element => {
                const permission = element.getAttribute('data-permission-disabled');
                if (!hasPermission(permission)) {
                    element.disabled = true;
                    element.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        }

        function toggleSubmenu(submenuId) {
            let submenu = document.getElementById(submenuId);
            let arrow = document.getElementById('arrow-' + submenuId.split('-')[1]);
            if (submenu) {
                if (submenu.classList.contains('hidden')) {
                    submenu.classList.remove('hidden');
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                } else {
                    submenu.classList.add('hidden');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                }
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
                admin: { name: 'Admin Elang Water', desc: 'Super Admin' },
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

        // Dummy/compatibility switchTab to prevent errors if reference exists
        window.switchTab = function(tabId) {
            // No-op or log for compatibility
            console.log('Redirecting to named route or using routing instead of switchTab for: ' + tabId);
        };

        window.onload = function () {
            // Apply access control on load
            applyAccessControl();

            // Run page-specific setup if defined
            if (typeof pageInit === 'function') {
                pageInit();
            }
        };
    </script>
    
    @stack('scripts')
</body>
</html>

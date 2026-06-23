<!-- Top Navbar -->
<header class="bg-white border-b border-cream-dark h-auto min-h-[64px] px-4 sm:px-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between shrink-0 z-20 py-3">
    <div class="flex items-center gap-3 flex-wrap">
        <button onclick="toggleMobileSidebar()" class="md:hidden p-2 rounded-lg bg-cream hover:bg-cream-dark text-zinc-700 transition-colors">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center font-bold text-zinc-900 shadow-md">
            <i data-lucide="droplet" class="w-6 h-6 text-zinc-900 fill-zinc-900/20"></i>
        </div>
        <div>
            <h1 class="font-bold text-lg leading-tight tracking-tight">Elangwater POS & ERP</h1>
            <span class="text-xs text-zinc-500 font-medium">Sistem Informasi Penjualan & Distribusi Air</span>
        </div>
    </div>

    <!-- Global Quick Info & Profile -->
    <div class="flex flex-wrap items-center gap-3 justify-end">
        <!-- Active Notification Bell -->
        <div class="relative cursor-pointer" onclick="showNotificationCenter()">
            <div class="p-2 rounded-lg hover:bg-cream-dark transition-colors">
                <i data-lucide="bell" class="w-5 h-5 text-zinc-600"></i>
                <span id="notif-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-[10px] text-white flex items-center justify-center rounded-full font-bold">5</span>
            </div>
        </div>

        <!-- Role Selector (Simulation) -->
        <div class="flex items-center gap-2 bg-cream-dark/50 px-3 py-1.5 rounded-lg border border-cream-dark">
            <i data-lucide="shield-check" class="w-4 h-4 text-primary-dark"></i>
            <select id="role-selector" class="bg-transparent text-xs font-semibold focus:outline-none cursor-pointer" onchange="changeRoleSim(this.value)">
                <option value="admin">Super Admin</option>
                <option value="kasir">Kasir / POS</option>
                <option value="gudang">Staf Gudang</option>
                <option value="distributor">Driver / Distribusi</option>
            </select>
        </div>

        <!-- User Info -->
        <div class="flex items-center gap-3 border-l border-cream-dark pl-4">
            <div class="text-right hidden md:block">
                <p id="user-display-name" class="text-sm font-semibold">Rakryan Alangwater</p>
                <p id="user-display-role" class="text-[11px] text-zinc-500 font-medium">Administrator</p>
            </div>
            <div class="w-9 h-9 rounded-full bg-primary-light flex items-center justify-center font-bold text-primary-dark text-sm border border-primary">
                RA
            </div>
        </div>
    </div>
</header>

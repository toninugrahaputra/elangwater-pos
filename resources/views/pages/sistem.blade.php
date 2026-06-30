@extends('layouts.app')

@section('content')
<!-- SECTION 11: PENGATURAN SISTEM -->
<div id="section-sistem" class="space-y-6" data-permission="settings.view" data-role="superadmin">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Pengaturan Sistem & User</h2>
            <p class="text-zinc-500 text-sm mt-0.5">Kelola data user, hak akses, audit log, and limit peringatan notifikasi.</p>
        </div>
    </div>

    <!-- Inner Settings Tab Bar -->
    <div class="bg-white p-2 rounded-2xl border border-cream-dark flex flex-wrap gap-1">
        <button onclick="switchSettingsSubTab(event, 'set-user')" id="btn-set-user" class="settings-subtab-btn px-5 py-3 text-xs font-bold rounded-lg transition-all bg-primary text-zinc-900 shadow-sm" data-permission="settings.view" data-role="superadmin">User, Role & Audit Log</button>
        <button onclick="switchSettingsSubTab(event, 'set-struk')" id="btn-set-struk" class="settings-subtab-btn px-5 py-3 text-xs font-bold rounded-lg transition-all text-zinc-600 hover:bg-cream hover:text-zinc-900" data-permission="settings.view" data-role="superadmin">Pengaturan Struk & Notifikasi</button>
    </div>

    <!-- SUB-SETTING: USER, ROLE & AUDIT LOG -->
    <div id="set-user" class="grid grid-cols-1 lg:grid-cols-2 gap-6 settings-sub-pane">
        <!-- User & Role CRUD -->
        <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-sm">Manajemen User & Hak Akses</h3>
                <button onclick="addNewUser()" class="bg-primary text-sm font-bold px-4 py-2 rounded-2xl hover:bg-primary-dark" data-permission="settings.view" data-role="superadmin">Tambah User</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-xs">
                    <thead>
                        <tr class="border-b border-cream-dark text-zinc-400 font-bold">
                            <th class="pb-2">Username</th>
                            <th class="pb-2">Role</th>
                            <th class="pb-2">Permissions</th>
                            <th class="pb-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-cream/50"><td class="py-2 font-semibold">admin.elang</td><td class="py-2">Super Admin</td><td class="py-2">Semua Fitur</td><td class="py-2 text-right text-zinc-400">Default</td></tr>
                        <tr class="border-b border-cream/50"><td class="py-2 font-semibold">lia.kasir</td><td class="py-2">Kasir</td><td class="py-2">POS, Kas Kecil</td><td class="py-2 text-right text-red-500 cursor-pointer" onclick="Swal.fire('Info', 'User default tidak bisa dihapus', 'info')">Hapus</td></tr>
                        <tr class="border-b border-cream/50"><td class="py-2 font-semibold">budi.driver</td><td class="py-2">Distributor / Driver</td><td class="py-2">DO, Upload Bukti</td><td class="py-2 text-right text-red-500 cursor-pointer" onclick="Swal.fire('Info', 'User default tidak bisa dihapus', 'info')">Hapus</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Audit Log & Notifikasi Alert Manager -->
        <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-4">
            <h3 class="font-bold text-sm border-b border-cream-dark pb-2">Audit Log Aktivitas Sistem Terakhir</h3>
            <div class="space-y-3 text-[11px] max-h-56 overflow-y-auto pr-1">
                <div class="p-2 bg-cream/30 border-l-2 border-primary rounded">
                    <span class="font-bold">admin.elang</span> melakukan <span class="font-bold text-zinc-900">Stock Opname Approval</span> untuk Gudang Utama.
                    <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 10:48</p>
                </div>
                <div class="p-2 bg-cream/30 border-l-2 border-green-500 rounded">
                    <span class="font-bold">lia.kasir</span> melakukan checkout penjualan <span class="font-bold text-green-700">Rp 120.000</span> (Tunai).
                    <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 10:30</p>
                </div>
                <div class="p-2 bg-cream/30 border-l-2 border-blue-500 rounded">
                    <span class="font-bold">budi.driver</span> memperbarui status <span class="font-bold text-blue-700">DO-0092 menjadi Terkirim</span>.
                    <p class="text-[9px] text-zinc-400 mt-0.5">23 Juni 2026 09:15</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SUB-SETTING: PENGATURAN STRUK & NOTIFIKASI -->
    <div id="set-struk" class="settings-sub-pane hidden" style="display:none">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Pengaturan Struk -->
            <div class="lg:col-span-2 bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-4">
                <h3 class="font-bold text-sm border-b border-cream-dark pb-2 flex items-center gap-2">
                    <i data-lucide="receipt" class="w-4 h-4 text-primary-dark"></i> Pengaturan Printer & Struk Belanja
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Judul Struk / Nama Toko</label>
                        <input type="text" id="set-receipt-title" onkeyup="updateLiveReceiptPreview()" value="DEPOT AIR ELANGWATER" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Email Toko</label>
                        <input type="email" id="set-receipt-email" onkeyup="updateLiveReceiptPreview()" value="info@elangwater.com" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="font-bold text-zinc-500 block mb-1">Alamat Toko</label>
                        <input type="text" id="set-receipt-address" onkeyup="updateLiveReceiptPreview()" value="Jl. Tumenggung Suryo 76A Malang" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="font-bold text-zinc-500 block mb-1">Catatan Kaki Struk (Footer Notes)</label>
                        <textarea id="set-receipt-footer" onkeyup="updateLiveReceiptPreview()" rows="2" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full font-semibold focus:outline-none">Air Bersih Sehat Keluarga Anda</textarea>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Tampilkan Logo Toko di Struk</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="checkbox" id="set-receipt-show-logo" onchange="updateLiveReceiptPreview()" checked class="w-4 h-4 accent-primary">
                            <span class="font-semibold text-zinc-600">Aktif</span>
                        </div>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Upload File Logo Struk</label>
                        <button onclick="Swal.fire('Upload File', 'Pilih file logo untuk struk belanja Anda', 'info')" class="bg-cream border border-cream-dark text-zinc-700 font-bold px-4 py-2 rounded-xl w-full flex items-center justify-center gap-1">
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i> Pilih Gambar Logo
                        </button>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Ukuran Kertas Thermal</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-1.5 font-semibold">
                                <input type="radio" name="paper-size" value="58mm" onchange="updateLiveReceiptPreview()" checked class="accent-primary"> 58mm
                            </label>
                            <label class="flex items-center gap-1.5 font-semibold">
                                <input type="radio" name="paper-size" value="80mm" onchange="updateLiveReceiptPreview()" class="accent-primary"> 80mm
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="font-bold text-zinc-500 block mb-1">Kirim Salinan Struk Otomatis ke Email</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="checkbox" id="set-receipt-email-auto" class="w-4 h-4 accent-primary">
                            <span class="font-semibold text-zinc-600">Aktifkan Kirim Email</span>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label class="font-bold text-zinc-500 block mb-1">Cetak Otomatis Setelah Pembayaran Sukses</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input type="checkbox" id="set-receipt-print-auto" checked class="w-4 h-4 accent-primary">
                            <span class="font-semibold text-zinc-600">Langsung Cetak ke Printer Lpt/Bluetooth</span>
                        </div>
                    </div>
                </div>

                <!-- Config Limit Notifikasi -->
                <div class="border-t border-cream-dark pt-4 space-y-3">
                    <h4 class="font-bold text-xs text-zinc-700">Pengaturan Notifikasi Alert & Limit System</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                        <div>
                            <label class="font-bold text-zinc-500 block mb-1">Stok Minimum (Alert)</label>
                            <input type="number" value="15" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        </div>
                        <div>
                            <label class="font-bold text-zinc-500 block mb-1">Tagihan Jatuh Tempo (Hari)</label>
                            <input type="number" value="7" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        </div>
                        <div>
                            <label class="font-bold text-zinc-500 block mb-1">Hutang Jatuh Tempo (Hari)</label>
                            <input type="number" value="14" class="bg-cream border border-cream-dark rounded-xl px-3 py-2 w-full focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-3">
                    <button onclick="saveReceiptSettingsSim()" class="bg-primary hover:bg-primary-dark text-zinc-900 font-bold px-6 py-3 rounded-2xl text-xs" data-permission="settings.view" data-role="superadmin">
                        Simpan Semua Konfigurasi
                    </button>
                </div>
            </div>

            <!-- Live Preview Struk (Interactive) -->
            <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-4">
                <h3 class="font-bold text-sm border-b border-cream-dark pb-2 flex items-center justify-between">
                    <span>Live Preview Struk</span>
                    <span id="preview-paper-size-badge" class="px-2 py-0.5 bg-zinc-200 text-zinc-700 rounded text-[9px] font-bold">58mm</span>
                </h3>
                
                <!-- Simulated Struk Paper -->
                <div id="live-receipt-paper" class="border border-zinc-300 p-4 bg-zinc-50 rounded-lg text-zinc-800 text-[10px] font-mono space-y-2 max-w-[240px] mx-auto shadow-sm">
                    <div class="text-center border-b border-dashed border-zinc-400 pb-2">
                        <div id="preview-logo-icon" class="mb-1"><i data-lucide="droplet" class="w-5 h-5 mx-auto text-primary-dark"></i></div>
                        <p id="preview-rec-title" class="font-bold text-[11px] uppercase">DEPOT AIR ELANGWATER</p>
                        <p id="preview-rec-email">info@elangwater.com</p>
                        <p id="preview-rec-address" class="text-[10px] text-zinc-500">Jl. H. Abdurrahman No. 12, Denpasar</p>
                        <p>HP: 0812-3456-7890</p>
                    </div>
                    <div class="space-y-0.5">
                        <p>No: TRX-171912459</p>
                        <p>Tgl: 23/06/2026 13:40</p>
                        <p>Ksr: Lia Kasir</p>
                    </div>
                    <div class="border-t border-b border-dashed border-zinc-400 py-1 space-y-0.5">
                        <div class="flex justify-between">
                            <span>Galon Elangwater x1</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Botol 600ml x2</span>
                            <span>Rp 76.000</span>
                        </div>
                    </div>
                    <div class="text-right space-y-0.5">
                        <p>Subtotal: Rp 91.000</p>
                        <p class="font-bold">Total: Rp 91.000</p>
                    </div>
                    <div class="text-center border-t border-dashed border-zinc-400 pt-2 text-[9px]">
                        <p class="font-bold">TERIMA KASIH</p>
                        <p id="preview-rec-footer">Air Bersih Sehat Keluarga Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchSettingsSubTab(event, tabId) {
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
            let activeBtn = document.getElementById(btnMap[tabId]);
            if (activeBtn) {
                activeBtn.classList.add('bg-primary', 'text-zinc-900', 'shadow-sm');
                activeBtn.classList.remove('text-zinc-600');
            }
        }

        let activePane = document.getElementById(tabId);
        if (activePane) {
            activePane.classList.remove('hidden');
            activePane.style.display = (tabId === 'set-user') ? 'grid' : 'block';
        }
    }

    function addNewUser() {
        Swal.fire({
            title: 'Tambah User Baru',
            html: `
                <input id="u-username" class="swal2-input" placeholder="Username">
                <select id="u-role" class="swal2-input">
                    <option value="superadmin">Super Admin</option>
                    <option value="admin_toko">Admin Toko</option>
                    <option value="kasir">Kasir</option>
                    <option value="gudang">Staf Gudang</option>
                    <option value="distributor">Driver / Distribusi</option>
                </select>
                <input id="u-password" type="password" class="swal2-input" placeholder="Password">
            `,
            preConfirm: () => {
                return {
                    username: document.getElementById('u-username').value,
                    role: document.getElementById('u-role').value
                }
            }
        }).then(res => {
            if (res.isConfirmed) {
                Swal.fire('Berhasil', `User baru ${res.value.username} dengan role ${res.value.role} berhasil didaftarkan!`, 'success');
            }
        });
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

    function pageInit() {
        switchSettingsSubTab(null, 'set-user');
        updateLiveReceiptPreview();
    }
</script>
@endpush

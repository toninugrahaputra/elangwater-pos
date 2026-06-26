# Product Requirements Document (PRD)

## Project

POS & Inventory Management System

Version: 1.0 (MVP)

Target Client: Elang Water

---

# 1. Overview

Sistem POS dan Inventory Management yang dirancang untuk menggantikan kebutuhan utama Olsera Premium yang saat ini digunakan oleh Elang Water.

Fokus utama sistem:

* Manajemen Produk
* Inventori & Gudang
* Penjualan POS
* Pembelian
* Pelanggan & Supplier
* Laporan Penjualan
* Laporan Inventori
* Kas Masuk & Kas Keluar
* Role & Permission
* Pengaturan Struk

Sistem harus mendukung multi gudang dan dapat dikembangkan menjadi multi toko di masa depan.

---

# 2. Objectives

## Business Objectives

* Mengurangi biaya berlangganan Olsera
* Menyediakan sistem yang hanya berisi fitur yang benar-benar digunakan
* Mempermudah kontrol stok
* Mempermudah monitoring penjualan
* Menyediakan laporan operasional yang lengkap

## Product Objectives

* POS cepat dan mudah digunakan
* Inventori real-time
* Laporan lengkap
* Sistem role yang fleksibel
* Mudah dikembangkan

---

# 3. User Roles

## Super Admin

Memiliki akses penuh terhadap seluruh sistem.

Hak akses:

* Produk
* Inventori
* Gudang
* Pelanggan
* Supplier
* Pembelian
* Penjualan
* Kas
* Laporan
* User Management
* Pengaturan Sistem

---

## Admin Toko (Kasir)

Mengelola operasional harian toko.

Hak akses:

* POS
* Pelanggan
* Supplier
* Pembelian
* Inventori
* Stock Opname
* Transfer Gudang
* Laporan Toko

---

## Petugas Gudang

Mengelola stok dan perpindahan barang.

Hak akses:

* Barang Masuk
* Barang Keluar
* Transfer Gudang
* Stock Opname
* Kartu Stok

---

# 4. Functional Requirements

## 4.1 Dashboard

### Fitur

* Total Penjualan Hari Ini
* Total Transaksi Hari Ini
* Produk Terlaris
* Produk Kurang Laku
* Nilai Stok
* Stok Minimum
* Piutang
* Hutang

---

## 4.2 Produk

### Data Produk

* SKU
* Barcode
* Nama Produk
* Kategori
* Brand
* Satuan
* Volume
* Harga Modal
* Harga Retail
* Harga Grosir
* Stok Minimum
* Status
* Foto Produk

### Operasi

* Tambah Produk
* Edit Produk
* Hapus Produk
* Import Produk
* Export Produk

---

## 4.3 Kategori Produk

### Operasi

* Tambah Kategori
* Edit Kategori
* Hapus Kategori

---

## 4.4 Brand

### Operasi

* Tambah Brand
* Edit Brand
* Hapus Brand

---

## 4.5 Gudang

### Fitur

* Multi Gudang
* Transfer Antar Gudang
* Stock Adjustment
* Stock Opname

---

## 4.6 Inventori

### Fitur

* Stok Real Time
* Barang Masuk
* Barang Keluar
* Kartu Stok
* Pergerakan Stok
* Nilai Persediaan

---

## 4.7 Pelanggan

### Data

* Nama
* Telepon
* Alamat
* Tipe Pelanggan
* Catatan

### Tipe

* Retail
* Agen
* Distributor
* Toko
* Kantor

---

## 4.8 Supplier

### Data

* Nama
* Telepon
* Email
* Alamat
* Catatan

---

## 4.9 Pembelian

### Fitur

* Purchase Order
* Penerimaan Barang
* Retur Pembelian

### Status

* Draft
* Completed
* Cancelled

---

## 4.10 POS

### Fitur

* Scan Barcode
* Cari Produk
* Pilih Pelanggan
* Diskon Item
* Diskon Transaksi
* Pajak
* Catatan Transaksi
* Cetak Struk
* Reprint Struk

### Metode Pembayaran

* Cash
* Transfer
* QRIS
* E-Wallet

---

## 4.11 Retur Penjualan

### Fitur

* Retur Sebagian
* Retur Penuh
* Riwayat Retur

---

## 4.12 Transfer Gudang

### Fitur

* Buat Transfer
* Kirim Transfer
* Terima Transfer

### Status

* Draft
* Sent
* Received

---

## 4.13 Stock Opname

### Fitur

* Opname Per Gudang
* Opname Per Produk
* Selisih Stok
* Approval Opname

---

## 4.14 Kas

### Kas Masuk

* Modal
* Pelunasan Piutang
* Pendapatan Lain

### Kas Keluar

* BBM
* Gaji
* Listrik
* Internet
* Operasional

---

## 4.15 Laporan

### Penjualan

* Harian
* Bulanan
* Tahunan
* Per Produk
* Per SKU
* Per Kategori
* Per Brand
* Per Pelanggan
* Produk Terlaris
* Produk Kurang Laku

### Inventori

* Stok Saat Ini
* Stok Masuk
* Stok Keluar
* Qty Produk Keluar
* Kartu Stok
* Pergerakan Stok
* Value Pergerakan Stok
* Usia Stok
* Stok Minimum
* Perubahan Harga
* FIFO Comparison

### Pembelian

* Per Supplier
* Per Produk
* Retur Pembelian

### Pelanggan

* Top Customer
* Customer Aktif
* Customer Tidak Aktif

### Keuangan

* Kas Masuk
* Kas Keluar
* Arus Kas
* Laba Rugi Sederhana

---

## 4.16 Pengaturan Struk

### Form Pengaturan

* Judul Struk
* Email Toko
* Catatan Struk
* Upload Logo
* Ukuran Kertas (58mm / 80mm)
* Cetak Otomatis
* Kirim Struk ke Email

### Preview

Preview struk ditampilkan secara real-time pada sisi kanan halaman.

Perubahan konfigurasi harus langsung diperbarui pada area preview.

---

## 4.17 Notifikasi

### Notifikasi Sistem

* Stok Minimum
* Piutang Jatuh Tempo
* Hutang Jatuh Tempo
* Transfer Gudang Pending
* Stock Opname Pending

---

## 4.18 User Management

### User

* Tambah User
* Edit User
* Nonaktifkan User

### Role

* Super Admin
* Admin Toko
* Gudang

### Permission

Menggunakan Role Based Access Control (RBAC).

---

## 4.19 Audit Log

Mencatat:

* Login
* Logout
* Tambah Data
* Edit Data
* Hapus Data
* Perubahan Harga
* Adjustment Stok
* Penjualan
* Pembelian

---

# 5. Non Functional Requirements

## Backend

* Laravel 13
* Mysql

## Frontend Web

* React
* TypeScript
* TailwindCSS

## Mobile

* Flutter

## Authentication

* Laravel Sanctum

## RBAC

* Spatie Laravel Permission

## API

* REST API

---

# 6. Success Metrics

* Waktu transaksi POS < 3 detik
* Akurasi stok > 99%
* Waktu generate laporan < 5 detik
* Sistem mampu menangani > 100.000 transaksi per tahun
* Uptime > 99%

---

# 7. MVP Scope

Modul yang wajib tersedia pada versi pertama:

1. Dashboard
2. Produk
3. Kategori
4. Brand
5. Gudang
6. Inventori
7. Pelanggan
8. Supplier
9. Pembelian
10. POS
11. Retur Penjualan
12. Transfer Gudang
13. Stock Opname
14. Kas Masuk & Kas Keluar
15. Laporan Penjualan
16. Laporan Inventori
17. User Management
18. RBAC
19. Audit Log
20. Pengaturan Struk

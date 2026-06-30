<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes (Guest only)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Protected Routes (Authenticated only)
Route::middleware(['auth'])->group(function () {
    $getViewWithUser = function ($viewName) {
        $user = auth()->user();
        if ($user) {
            $user->load(['roles', 'permissions']);
        }
        return view($viewName, ['user' => $user]);
    };

    // Dashboard
    Route::get('/', fn() => $getViewWithUser('pages.dashboard'))->name('dashboard');

    // Master Data
    Route::prefix('master')->name('master.')->group(function () use ($getViewWithUser) {
        Route::get('/produk', fn() => $getViewWithUser('pages.master.produk'))->name('produk');
        Route::get('/harga', fn() => $getViewWithUser('pages.master.harga'))->name('harga');
        Route::get('/kategori', fn() => $getViewWithUser('pages.master.kategori'))->name('kategori');
        Route::get('/brand', fn() => $getViewWithUser('pages.master.brand'))->name('brand');
        Route::get('/satuan', fn() => $getViewWithUser('pages.master.satuan'))->name('satuan');
    });

    // Inventori
    Route::prefix('inventori')->name('inventori.')->group(function () use ($getViewWithUser) {
        Route::get('/gudang', fn() => $getViewWithUser('pages.inventori.gudang'))->name('gudang');
        Route::get('/stok', fn() => $getViewWithUser('pages.inventori.stok'))->name('stok');
        Route::get('/masuk', fn() => $getViewWithUser('pages.inventori.masuk'))->name('masuk');
        Route::get('/keluar', fn() => $getViewWithUser('pages.inventori.keluar'))->name('keluar');
        Route::get('/transfer', fn() => $getViewWithUser('pages.inventori.transfer'))->name('transfer');
        Route::get('/opname', fn() => $getViewWithUser('pages.inventori.opname'))->name('opname');
        Route::get('/kartu-stok', fn() => $getViewWithUser('pages.inventori.kartu-stok'))->name('kartu-stok');
    });

    // Pelanggan & Supplier
    Route::get('/pelanggan', fn() => $getViewWithUser('pages.pelanggan'))->name('pelanggan');
    Route::get('/supplier', fn() => $getViewWithUser('pages.supplier'))->name('supplier');

    // Pembelian
    Route::prefix('pembelian')->name('pembelian.')->group(function () use ($getViewWithUser) {
        Route::get('/po', fn() => $getViewWithUser('pages.pembelian.po'))->name('po');
        Route::get('/retur', fn() => $getViewWithUser('pages.pembelian.retur'))->name('retur');
    });

    // Live POS Kasir
    Route::get('/pos', fn() => $getViewWithUser('pages.pos'))->name('pos');

    // Distribusi & Pengiriman
    Route::prefix('distribusi')->name('distribusi.')->group(function () use ($getViewWithUser) {
        Route::get('/do', fn() => $getViewWithUser('pages.distribusi.do'))->name('do');
        Route::get('/bukti', fn() => $getViewWithUser('pages.distribusi.bukti'))->name('bukti');
    });

    // Keuangan
    Route::prefix('keuangan')->name('keuangan.')->group(function () use ($getViewWithUser) {
        Route::get('/kas', fn() => $getViewWithUser('pages.keuangan.kas'))->name('kas');
        Route::get('/tagihan', fn() => $getViewWithUser('pages.keuangan.tagihan'))->name('tagihan');
        Route::get('/hutang', fn() => $getViewWithUser('pages.keuangan.hutang'))->name('hutang');
    });

    // Laporan
    Route::get('/laporan', fn() => $getViewWithUser('pages.laporan'))->name('laporan');

    // Sistem / Settings
    Route::get('/sistem', fn() => $getViewWithUser('pages.sistem'))->name('sistem');
});

// Redirect root to login if not authenticated (handled by middleware groups above)
// Redirect home/dashboard to root if authenticated
Route::redirect('/home', '/');
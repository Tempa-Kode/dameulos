<?php

use App\Http\Controllers\AksesPelangganController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Katalog;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'adminManajer'])->group(function () {
    // Test route sederhana
    Route::get('/dashboard-test', function () {
        return "Dashboard test berhasil!";
    });

    // Test dashboard controller
    Route::get('/dashboard-debug', function () {
        try {
            $controller = new \App\Http\Controllers\DashboardController();
            return $controller->index();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine();
        }
    });

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware(['auth', 'adminManajer', 'verified'])
        ->name('dashboard');

    Route::resource('produk', ProdukController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('katalog', KatalogController::class)->middleware(['auth', 'adminManajer']);    // Route khusus untuk transaksi harus sebelum resource
    Route::get('/transaksi/download-report', [TransaksiController::class, 'downloadReport'])->name('transaksi.download.report');
    Route::get('/transaksi/preview-report', [TransaksiController::class, 'previewReport'])->name('transaksi.preview.report');
    Route::resource('transaksi', TransaksiController::class)->middleware(['auth', 'adminManajer']);

    // Route khusus untuk pengiriman harus sebelum resource
    Route::get('/pengiriman/download-report', [PengirimanController::class, 'downloadReport'])->name('pengiriman.download.report');
    Route::get('/pengiriman/preview-report', [PengirimanController::class, 'previewReport'])->name('pengiriman.preview.report');
    Route::get('/pengiriman/{pengiriman}/print-label', [PengirimanController::class, 'printLabel'])->name('pengiriman.print.label');
    Route::resource('pengiriman', PengirimanController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('admin', \App\Http\Controllers\AdminController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('manajer', \App\Http\Controllers\ManajerController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('pelanggan', \App\Http\Controllers\PelangganController::class)->middleware(['auth', 'adminManajer']);
});

Route::get('/', [AksesPelangganController::class, 'index'])->name('pelanggan.home');
Route::get('/katalog', [AksesPelangganController::class, 'katalog'])->name('pelanggan.katalog');
Route::get('/katalog/{katalog:slug}', [AksesPelangganController::class, 'katalogBySlug'])->name('pelanggan.katalogBySlug');
Route::get('/produk/{produk:slug}', [AksesPelangganController::class, 'produkBySlug'])->name('pelanggan.produkBySlug');

// Checkout routes
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('pelanggan.checkout');
Route::get('/checkout/form', [CheckoutController::class, 'showCheckoutForm'])->name('pelanggan.checkout.form');
Route::get('/checkout/from-cart', [CheckoutController::class, 'checkoutFromCart'])->name('pelanggan.checkout.from-cart');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('pelanggan.checkout.process');
Route::get('/checkout/success/{kode_transaksi}', [CheckoutController::class, 'success'])->name('pelanggan.checkout.success');

Route::get('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'index'])->name('pelanggan.keranjang.index');
Route::post('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'create'])->name('pelanggan.keranjang.create');
Route::delete('/keranjang/{keranjang:id}', [\App\Http\Controllers\KeranjangController::class, 'destroy'])->name('pelanggan.keranjang.destroy');

// API Cek Lokasi Pengiriman
Route::get('/api/proxy/destination', [PengirimanController::class, 'cekDestinasiTujuan'])->name('proxy.destination');
Route::post('/api/proxy/ongkir', [PengirimanController::class, 'cekOngkir'])->name('proxy.ongkir');

// Pembayaran Midtrans
Route::post('/checkout/bayar', [PembayaranController::class, 'bayar'])->middleware(['auth'])->name('pembayaran');

Route::get('/transaksi', [TransaksiController::class, 'transaksiSaya'])->middleware(['auth'])->name('pelanggan.transaksi');
Route::post('/transaksi/update-status/{kode_transaksi}', [TransaksiController::class, 'updateStatus'])->middleware(['auth'])->name('transaksi.update-status');


require __DIR__.'/auth.php';


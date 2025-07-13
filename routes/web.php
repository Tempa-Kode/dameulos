<?php

use App\Http\Controllers\AksesPelangganController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController;
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
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware(['auth', 'adminManajer', 'verified'])
        ->name('dashboard');

    Route::resource('produk', ProdukController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('katalog', KatalogController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('transaksi', TransaksiController::class)->middleware(['auth', 'adminManajer']);
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
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('pelanggan.checkout.process');
Route::get('/checkout/success/{kode_transaksi}', [CheckoutController::class, 'success'])->name('pelanggan.checkout.success');

Route::post('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'create'])->name('pelanggan.keranjang.create');

require __DIR__.'/auth.php';


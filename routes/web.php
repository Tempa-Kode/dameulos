<?php

use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Katalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'adminManajer', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('produk', ProdukController::class)->middleware(['auth', 'adminManajer']);
Route::resource('katalog', KatalogController::class)->middleware(['auth', 'adminManajer']);
Route::resource('transaksi', TransaksiController::class)->middleware(['auth', 'adminManajer']);
Route::resource('pengiriman', PengirimanController::class)->middleware(['auth', 'adminManajer']);
Route::resource('admin', \App\Http\Controllers\AdminController::class)->middleware(['auth', 'adminManajer']);
Route::resource('manajer', \App\Http\Controllers\ManajerController::class)->middleware(['auth', 'adminManajer']);

require __DIR__.'/auth.php';

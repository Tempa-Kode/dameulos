<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AksesPelangganController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Katalog;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer profile routes
    Route::get('/customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::patch('/customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::patch('/customer/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('customer.profile.password.update');
});

Route::get('/kegiatan/{slug}', [AksesPelangganController::class, 'kegiatan'])->name('kegiatan.slug');

Route::prefix('dashboard')->middleware(['auth', 'adminManajer'])->group(function () {
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

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware(['auth', 'adminManajer', 'verified'])
        ->name('dashboard');

    // Profile routes
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::patch('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password.update');

    Route::resource('produk', ProdukController::class)->middleware(['auth', 'adminManajer']);
    Route::get('/produk-report', [ProdukController::class, 'downloadReport'])->name('produk.report')->middleware(['auth', 'adminManajer']);
    Route::delete('/produk-foto/{id}', [ProdukController::class, 'hapusFoto'])->name('produk.foto.hapus')->middleware(['auth', 'adminManajer']);
    Route::delete('/produk-ulasan/{id}', [ProdukController::class, 'hapusUlasan'])->name('produk.ulasan.hapus')->middleware(['auth', 'adminManajer']);
    Route::resource('katalog', KatalogController::class)->middleware(['auth', 'adminManajer']);    // Route khusus untuk transaksi harus sebelum resource
    Route::get('/transaksi/download-report', [TransaksiController::class, 'downloadReport'])->name('transaksi.download.report');
    Route::resource('transaksi', TransaksiController::class)->middleware(['auth', 'adminManajer']);

    Route::resource('kategori', \App\Http\Controllers\KategoriProdukController::class)->middleware(['auth', 'adminManajer']);

    // Route untuk mengelola video produk
    Route::get('/video-produk/tambah/{produk:id}', [\App\Http\Controllers\ProdukController::class, 'tambahVideoProduk'])->name('video-produk.tambah')->middleware(['auth', 'adminManajer']);
    Route::post('/video-produk/simpan/{produk:id}', [\App\Http\Controllers\ProdukController::class, 'simpanVideoProduk'])->name('video-produk.store')->middleware(['auth', 'adminManajer']);
    Route::delete('/video-produk/hapus/{videoProduk:id}', [\App\Http\Controllers\ProdukController::class, 'hapusVideoProduk'])->name('video-produk.hapus')->middleware(['auth', 'adminManajer']);

    // Route khusus untuk pengiriman harus sebelum resource
    Route::get('/pengiriman/download-report', [PengirimanController::class, 'downloadReport'])->name('pengiriman.download.report');
    Route::get('/pengiriman/preview-report', [PengirimanController::class, 'previewReport'])->name('pengiriman.preview.report');
    Route::get('/pengiriman/{pengiriman}/print-label', [PengirimanController::class, 'printLabel'])->name('pengiriman.print.label');
    Route::resource('pengiriman', PengirimanController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('admin', \App\Http\Controllers\AdminController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('manajer', \App\Http\Controllers\ManajerController::class)->middleware(['auth', 'adminManajer']);
    Route::get('/pelanggan/download-report', [\App\Http\Controllers\PelangganController::class, 'downloadReport'])->name('pelanggan.report');
    Route::resource('pelanggan', \App\Http\Controllers\PelangganController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('promosi', \App\Http\Controllers\PromosiController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('piagam', \App\Http\Controllers\PiagamController::class)->middleware(['auth', 'adminManajer']);
    Route::resource('kegiatan', \App\Http\Controllers\KegiatanController::class)->middleware(['auth', 'adminManajer']);

    // Pre-order routes
    Route::get('/preorder', [PreOrderController::class, 'index'])->name('preorder.index')->middleware(['auth', 'adminManajer']);
    Route::get('/preorder/download-report', [PreOrderController::class, 'downloadReport'])->name('preorder.download.report');

    // Admin routes untuk Pengembalian Dana
    Route::resource('pengembalian-dana', \App\Http\Controllers\PengembalianDanaController::class)->except(['create', 'store'])->middleware(['auth', 'adminManajer']);

    // Admin routes untuk Keluhan
    Route::get('/keluhan', [\App\Http\Controllers\KeluhanController::class, 'adminIndex'])->name('admin.keluhan.index');
    Route::get('/keluhan/{keluhan}', [\App\Http\Controllers\KeluhanController::class, 'adminShow'])->name('admin.keluhan.show');
    Route::post('/keluhan/{keluhan}/reply', [\App\Http\Controllers\KeluhanController::class, 'adminReply'])->name('admin.keluhan.reply');
    Route::patch('/keluhan/{keluhan}/status', [\App\Http\Controllers\KeluhanController::class, 'updateStatus'])->name('admin.keluhan.status');
});

Route::put('/pengiriman/{transaksi:id}/terima-pesanan', [PengirimanController::class, 'terimaPesanan'])->name('pengiriman.terima.pesanan');

Route::get('/', [AksesPelangganController::class, 'index'])->name('pelanggan.home');
Route::get('/katalog', [AksesPelangganController::class, 'katalog'])->name('pelanggan.katalog');
Route::get('/katalog/{katalog:slug}', [AksesPelangganController::class, 'katalogBySlug'])->name('pelanggan.katalogBySlug');
Route::get('/produk/{produk:slug}', [AksesPelangganController::class, 'produkBySlug'])->name('pelanggan.produkBySlug');
Route::get('/tentang-kami', [AksesPelangganController::class, 'tentangKami'])->name('pelanggan.tentang-kami');

// Checkout routes
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('pelanggan.checkout');
Route::get('/checkout/form', [CheckoutController::class, 'showCheckoutForm'])->name('pelanggan.checkout.form');
Route::get('/checkout/from-cart', [CheckoutController::class, 'checkoutFromCart'])->name('pelanggan.checkout.from-cart');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('pelanggan.checkout.process');
Route::get('/checkout/success/{kode_transaksi}', [CheckoutController::class, 'success'])->name('pelanggan.checkout.success');

Route::get('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'index'])->name('pelanggan.keranjang.index');
Route::post('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'create'])->name('pelanggan.keranjang.create');
Route::delete('/keranjang/{keranjang:id}', [\App\Http\Controllers\KeranjangController::class, 'destroy'])->name('pelanggan.keranjang.destroy');
Route::put('/keranjang/{keranjang:id}/qty/{produkId}', [\App\Http\Controllers\KeranjangController::class, 'updateJumlahQty'])->name('pelanggan.keranjang.update');

// API Cek Lokasi Pengiriman
Route::get('/api/proxy/destination', [PengirimanController::class, 'cekDestinasiTujuan'])->name('proxy.destination');
Route::post('/api/proxy/ongkir', [PengirimanController::class, 'cekOngkir'])->name('proxy.ongkir');

// Pembayaran Midtrans
Route::post('/checkout/bayar', [PembayaranController::class, 'bayar'])->middleware(['auth'])->name('pembayaran');

Route::get('/transaksi', [TransaksiController::class, 'transaksiSaya'])->middleware(['auth'])->name('pelanggan.transaksi');
Route::post('/transaksi/update-status/{kode_transaksi}', [TransaksiController::class, 'updateStatus'])->middleware(['auth'])->name('transaksi.update-status');

// Route untuk edit detail transaksi (ukuran dan warna)
Route::get('/transaksi/{transaksi}/edit-detail', [TransaksiController::class, 'editDetail'])->middleware(['auth'])->name('transaksi.edit-detail');
Route::put('/transaksi/{transaksi}/update-detail', [TransaksiController::class, 'updateDetail'])->middleware(['auth'])->name('transaksi.update-detail');

// Routes untuk Pengembalian Dana
Route::middleware(['auth'])->group(function () {
    Route::get('/pengembalian-dana', [\App\Http\Controllers\PengembalianDanaController::class, 'pelangganIndex'])->name('pelanggan.pengembalian-dana.index');
    Route::get('/pengembalian-dana/create', [\App\Http\Controllers\PengembalianDanaController::class, 'create'])->name('pengembalian-dana.create');
    Route::post('/pengembalian-dana', [\App\Http\Controllers\PengembalianDanaController::class, 'store'])->name('pengembalian-dana.store');
    Route::get('/pengembalian-dana/{pengembalianDana}', [\App\Http\Controllers\PengembalianDanaController::class, 'show'])->name('pengembalian-dana.show');
});

Route::post('/bukti-pembayaran/{id}/upload-bukti', [PembayaranController::class, 'uploadBuktiPembayaran'])->middleware(['auth'])->name('pembayaran.upload.bukti');


// Ulasan routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ulasan', [\App\Http\Controllers\UlasanController::class, 'index'])->name('pelanggan.ulasan.index');
    Route::get('/ulasan/create', [\App\Http\Controllers\UlasanController::class, 'create'])->name('pelanggan.ulasan.create');
    Route::post('/ulasan', [\App\Http\Controllers\UlasanController::class, 'store'])->name('pelanggan.ulasan.store');
    Route::get('/ulasan/{ulasan}', [\App\Http\Controllers\UlasanController::class, 'show'])->name('pelanggan.ulasan.show');
    Route::get('/ulasan/{ulasan}/edit', [\App\Http\Controllers\UlasanController::class, 'edit'])->name('pelanggan.ulasan.edit');
    Route::put('/ulasan/{ulasan}', [\App\Http\Controllers\UlasanController::class, 'update'])->name('pelanggan.ulasan.update');
    Route::delete('/ulasan/{ulasan}', [\App\Http\Controllers\UlasanController::class, 'destroy'])->name('pelanggan.ulasan.destroy');
});

// Keluhan routes (Customer)
Route::middleware(['auth'])->group(function () {
    Route::get('/keluhan', [\App\Http\Controllers\KeluhanController::class, 'index'])->name('pelanggan.keluhan.index');
    Route::get('/keluhan/create', [\App\Http\Controllers\KeluhanController::class, 'create'])->name('pelanggan.keluhan.create');
    Route::post('/keluhan', [\App\Http\Controllers\KeluhanController::class, 'store'])->name('pelanggan.keluhan.store');
    Route::get('/keluhan/{keluhan}', [\App\Http\Controllers\KeluhanController::class, 'show'])->name('pelanggan.keluhan.show');
    Route::post('/keluhan/{keluhan}/reply', [\App\Http\Controllers\KeluhanController::class, 'reply'])->name('pelanggan.keluhan.reply');
});

//Route::resource('kegiatan', KegiatanController::class);
Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->post('/upload-image', [KegiatanController::class, 'uploadImage'])
    ->name('upload.image');


require __DIR__.'/auth.php';


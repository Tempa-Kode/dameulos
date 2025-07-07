<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalJenisProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Pembayaran::where('status', 'berhasil')->sum('total_pembayaran');

        return view('dashboard',
            compact('totalPelanggan', 'totalJenisProduk', 'totalTransaksi', 'totalPendapatan')
        );
    }
}

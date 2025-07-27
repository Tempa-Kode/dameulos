<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Pengiriman;
use App\Models\Keranjang;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data overview
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalJenisProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Pembayaran::where('status', 'dibayar')->sum('total_pembayaran');

        // Data tambahan
        $totalKeranjang = Keranjang::count();
        $totalPengiriman = Pengiriman::count();

        // Produk terlaris - menggunakan query yang aman
        $produkTerlaris = Produk::select('produk.id', 'produk.nama')
            ->leftJoin('detail_transaksi', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->selectRaw('COUNT(detail_transaksi.id) as detail_transaksi_count')
            ->groupBy('produk.id', 'produk.nama')
            ->orderBy('detail_transaksi_count', 'desc')
            ->take(5)
            ->get();

        // Transaksi terakhir
        $transaksiTerakhir = Transaksi::with(['user', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik per bulan (6 bulan terakhir)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'transaksi' => Transaksi::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'pendapatan' => Pembayaran::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->where('status', 'dibayar')
                    ->sum('total_pembayaran'),
                'pelanggan' => User::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->where('role', 'pelanggan')
                    ->count()
            ];
        }

        // Status transaksi
        $statusTransaksi = [
            'pending' => Transaksi::where('status', 'pending')->count(),
            'dibayar' => Transaksi::where('status', 'dibayar')->count(),
            'dikonfirmasi' => Transaksi::where('status', 'dikonfirmasi')->count(),
            'diproses' => Transaksi::where('status', 'diproses')->count(),
            'dikirim' => Transaksi::where('status', 'dikirim')->count(),
            'selesai' => Transaksi::where('status', 'selesai')->count(),
            'batal' => Transaksi::where('status', 'batal')->count(),
        ];

        // Perbandingan bulan ini vs bulan lalu
        $thisMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $thisMonthTransaksi = Transaksi::whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();
        $lastMonthTransaksi = Transaksi::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $thisMonthPendapatan = Pembayaran::whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->where('status', 'dibayar')
            ->sum('total_pembayaran');
        $lastMonthPendapatan = Pembayaran::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->where('status', 'dibayar')
            ->sum('total_pembayaran');

        // Hitung pertumbuhan pendapatan (growth)
        if ($lastMonthPendapatan > 0) {
            $pendapatanGrowth = (($thisMonthPendapatan - $lastMonthPendapatan) / $lastMonthPendapatan) * 100;
        } else if ($thisMonthPendapatan > 0) {
            $pendapatanGrowth = 100;
        } else {
            $pendapatanGrowth = 0;
        }

        // Hitung pertumbuhan transaksi (growth)
        if ($lastMonthTransaksi > 0) {
            $transaksiGrowth = (($thisMonthTransaksi - $lastMonthTransaksi) / $lastMonthTransaksi) * 100;
        } else if ($thisMonthTransaksi > 0) {
            $transaksiGrowth = 100;
        } else {
            $transaksiGrowth = 0;
        }

        // Tambahan analisis untuk insights
        $avgTransaksiPerDay = $thisMonthTransaksi > 0 ? $thisMonthTransaksi / now()->day : 0;
        $avgPendapatanPerDay = $thisMonthPendapatan > 0 ? $thisMonthPendapatan / now()->day : 0;

        // Prediksi akhir bulan
        $daysInMonth = now()->daysInMonth;
        $predictedTransaksi = $avgTransaksiPerDay * $daysInMonth;
        $predictedPendapatan = $avgPendapatanPerDay * $daysInMonth;

        return view('dashboard', compact(
            'totalPelanggan', 'totalJenisProduk', 'totalTransaksi', 'totalPendapatan',
            'totalKeranjang', 'totalPengiriman', 'produkTerlaris', 'transaksiTerakhir',
            'monthlyStats', 'statusTransaksi', 'transaksiGrowth', 'pendapatanGrowth',
            'thisMonthTransaksi', 'thisMonthPendapatan', 'avgTransaksiPerDay', 'avgPendapatanPerDay',
            'predictedTransaksi', 'predictedPendapatan'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AksesPelangganController extends Controller
{
    public function index()
    {
        $produk = Produk::with('katalog')->paginate(20);
        // Get best-selling products based on transaction quantity
        // Try all statuses except 'pending' and 'dibatalkan'
        $produkTerlaris = Produk::select('produk.*', DB::raw('COALESCE(SUM(detail_transaksi.jumlah), 0) as total_terjual'))
            ->leftJoin('detail_transaksi', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->leftJoin('transaksi', function($join) {
                $join->on('detail_transaksi.transaksi_id', '=', 'transaksi.id')
                     ->whereNotIn('transaksi.status', ['pending', 'dibatalkan']); // Exclude pending and cancelled
            })
            ->groupBy('produk.id')
            ->having('total_terjual', '>', 0) // Only show products that have been sold
            ->orderBy('total_terjual', 'desc')
            ->limit(8) // Show top 8 best-selling products
            ->get();

        // If no best-selling products, show some random products as fallback
        if ($produkTerlaris->isEmpty()) {
            $produkTerlaris = Produk::inRandomOrder()->limit(8)->get();
            // Add a default total_terjual of 0 for display
            $produkTerlaris->each(function($produk) {
                $produk->total_terjual = 0;
            });
        }

        return view('pelanggan.index', compact('produkTerlaris', 'produk'));
    }

    public function katalog(Request $request)
    {
        $search = $request->input('search');
        $kategori = Katalog::withCount('produk')->get();
        $produk = Produk::with('katalog')->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })->paginate(12);
        return view('pelanggan.katalog', compact('kategori', 'produk'));
    }

    public function katalogBySlug(Katalog $katalog)
    {
        $kategori = Katalog::withCount('produk')->get();
        $produk = Produk::where('katalog_id', $katalog->id)->paginate(20);
        return view('pelanggan.katalog', compact('kategori', 'produk'));
    }

    public function produkBySlug(Produk $produk)
    {
        $produk->load(['katalog', 'ukuran', 'jenisWarnaProduk', 'warnaProduk']);
        $produkTerkait = Produk::where('katalog_id', $produk->katalog_id)
            ->where('id', '!=', $produk->id)
            ->limit(4)
            ->get();
        return view('pelanggan.produk-detail', compact('produk', 'produkTerkait'));
    }

    public function tentangKami()
    {
        return view('pelanggan.tentang-kami');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Piagam;
use App\Models\Produk;
use App\Models\Katalog;
use App\Models\Promosi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AksesPelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('cari');
        $kategori = $request->input('kategori');
        if ($kategori) {
            $kategoriId = KategoriProduk::where('slug', $kategori)->value('id');
        } else {
            $kategoriId = null;
        }
        $produk = Produk::with('katalog')->filter(['cari' => $search, 'kategori' => $kategoriId])->paginate(20);
        // Get best-selling products based on transaction quantity
        // Try all statuses except 'pending' and 'dibatalkan'
        $produkTerlaris = Produk::select('produk.*', DB::raw('COALESCE(SUM(detail_transaksi.jumlah), 0) as total_terjual'))
            ->leftJoin('detail_transaksi', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->leftJoin('transaksi', function($join) {
                $join->on('detail_transaksi.transaksi_id', '=', 'transaksi.id')
                     ->whereNotIn('transaksi.status', ['pending', 'dibatalkan']); // Exclude pending and cancelled
            })
            ->groupBy([
                'produk.id',
                'produk.nama',
                'produk.katalog_id',
                'produk.harga',
                'produk.stok',
            ])
            ->having('total_terjual', '>', 0)
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

        $kategori = KategoriProduk::all();
        $promosi = Promosi::all();

        return view('pelanggan.index', compact('produkTerlaris', 'produk', 'kategori', 'promosi'));
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
        $produk->load(['katalog', 'ukuran', 'jenisWarnaProduk', 'warnaProduk', 'fotoProduk', 'ulasan.user']);
        $produkTerkait = Produk::where('katalog_id', $produk->katalog_id)
            ->where('id', '!=', $produk->id)
            ->limit(4)
            ->get();

        // Load ulasan dengan pagination
        $ulasan = $produk->ulasan()->with('user')->orderBy('created_at', 'desc')->paginate(5);

        return view('pelanggan.produk-detail', compact('produk', 'produkTerkait', 'ulasan'));
    }

    public function tentangKami()
    {
        $piagam = Piagam::all();
        $kegiatan = Kegiatan::latest()->take(10)->get();
        return view('pelanggan.tentang-kami', compact('piagam', 'kegiatan'));
    }

    public function kegiatan($slug)
    {
        $kegiatan = Kegiatan::where('slug', $slug)->firstOrFail();
        return view('pelanggan.kegiatan', compact('kegiatan'));
    }
}

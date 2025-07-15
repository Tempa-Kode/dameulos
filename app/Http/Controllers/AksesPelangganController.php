<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Produk;
use Illuminate\Http\Request;

class AksesPelangganController extends Controller
{
    public function index()
    {
        return view('pelanggan.index');
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

<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * tambah produk ke keranjang
     */
    public function create(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'ukuran_id' => 'required|exists:ukuran_produk,id',
            'warna_id' => 'required|exists:jenis_warna_produk,id',
        ]);

        // Cek apakah produk sudah ada di keranjang
        $keranjang = Keranjang::where('user_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->whereHas('ukuranProduk', function ($query) use ($request) {
                $query->where('id', $request->ukuran_id);
            })
            ->whereHas('jenisWarnaProduk', function ($query) use ($request) {
                $query->where('id', $request->warna_id);
            })
            ->first();

        if ($keranjang) {
            // Jika produk sudah ada, update jumlahnya
            $keranjang->jumlah += $request->jumlah;
            $keranjang->save();
        } else {
            // Jika belum ada, buat entri baru
            Keranjang::create([
                'user_id' => auth()->id(),
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'ukuran_produk_id' => $request->ukuran_id,
                'jenis_warna_produk_id' => $request->warna_id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'keranjang_count' => Keranjang::where('user_id', auth()->id())->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        //
    }
}

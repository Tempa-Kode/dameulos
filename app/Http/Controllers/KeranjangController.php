<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index()
    {
        // Ambil semua produk di keranjang untuk user yang sedang login
        $keranjang = Keranjang::where('user_id', auth()->id())
            ->with(['produk', 'ukuranProduk', 'jenisWarnaProduk'])
            ->get();

        // Hitung total harga
        $totalHarga = $keranjang->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->produk->harga;
        });
        // dd($keranjang);
        return view('pelanggan.keranjang', compact('keranjang', 'totalHarga'));
    }

    public function create(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'ukuran_id' => 'nullable|exists:ukuran_produk,id',
            'warna_id' => 'nullable|exists:jenis_warna_produk,id',
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

    public function destroy(Keranjang $keranjang)
    {
        // Hapus entri keranjang
        $keranjang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang.',
            'keranjang_count' => Keranjang::where('user_id', auth()->id())->count(),
        ]);
    }

    /*
     * fungsi untuk mengupdate jumlah qty produk
     */
    public function updateJumlahQty(Request $request, Keranjang $keranjang, $produkId){
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $keranjang->where('produk_id', $produkId)
                ->update(['jumlah' => $request->jumlah]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk berhasil diperbarui.',
                'keranjang_count' => Keranjang::where('id', $keranjang->id)->where('produk_id', $produkId)->count(),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui jumlah produk: ' . $th->getMessage(),
            ], 500);
        }

    }
}

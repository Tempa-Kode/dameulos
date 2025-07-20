<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ulasan = Ulasan::with(['user', 'produk'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.ulasan.index', compact('ulasan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $transaksi_id = $request->transaksi_id;
        $produk_id = $request->produk_id;

        // Validasi bahwa transaksi ini milik user yang sedang login
        $transaksi = Transaksi::where('id', $transaksi_id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->first();

        if (!$transaksi) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi tidak ditemukan atau belum selesai.');
        }

        // Validasi bahwa produk ada dalam transaksi ini
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi_id)
            ->where('produk_id', $produk_id)
            ->first();

        if (!$detailTransaksi) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Produk tidak ditemukan dalam transaksi ini.');
        }

        // Cek apakah sudah pernah memberikan ulasan untuk produk ini di transaksi ini
        $existingUlasan = Ulasan::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->where('transaksi_id', $transaksi_id)
            ->first();

        if ($existingUlasan) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        $produk = Produk::findOrFail($produk_id);

        return view('pelanggan.ulasan.create', compact('transaksi', 'produk', 'detailTransaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'produk_id' => 'required|exists:produk,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Rating harus dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'ulasan.required' => 'Ulasan harus diisi.',
            'ulasan.min' => 'Ulasan minimal 10 karakter.',
            'ulasan.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        // Validasi ulang bahwa user berhak memberikan ulasan
        $transaksi = Transaksi::where('id', $request->transaksi_id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->first();

        if (!$transaksi) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi tidak valid.');
        }

        // Cek apakah sudah pernah memberikan ulasan
        $existingUlasan = Ulasan::where('user_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->where('transaksi_id', $request->transaksi_id)
            ->first();

        if ($existingUlasan) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        DB::beginTransaction();
        try {
            Ulasan::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'transaksi_id' => $request->transaksi_id,
                'rating' => $request->rating,
                'ulasan' => $request->ulasan,
            ]);

            DB::commit();

            return redirect()->route('pelanggan.transaksi')
                ->with('success', 'Ulasan berhasil diberikan. Terima kasih atas feedback Anda!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ulasan $ulasan)
    {
        // Pastikan ulasan milik user yang sedang login
        if ($ulasan->user_id !== Auth::id()) {
            abort(403);
        }

        $ulasan->load(['produk', 'transaksi']);

        return view('pelanggan.ulasan.show', compact('ulasan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ulasan $ulasan)
    {
        // Pastikan ulasan milik user yang sedang login
        if ($ulasan->user_id !== Auth::id()) {
            abort(403);
        }

        $ulasan->load(['produk', 'transaksi']);

        return view('pelanggan.ulasan.edit', compact('ulasan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ulasan $ulasan)
    {
        // Pastikan ulasan milik user yang sedang login
        if ($ulasan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Rating harus dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'ulasan.required' => 'Ulasan harus diisi.',
            'ulasan.min' => 'Ulasan minimal 10 karakter.',
            'ulasan.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        DB::beginTransaction();
        try {
            $ulasan->update([
                'rating' => $request->rating,
                'ulasan' => $request->ulasan,
            ]);

            DB::commit();

            return redirect()->route('pelanggan.ulasan.index')
                ->with('success', 'Ulasan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ulasan $ulasan)
    {
        // Pastikan ulasan milik user yang sedang login
        if ($ulasan->user_id !== Auth::id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        DB::beginTransaction();
        try {
            $ulasan->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ulasan berhasil dihapus.'
                ]);
            }

            return redirect()->route('pelanggan.ulasan.index')
                ->with('success', 'Ulasan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus ulasan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus ulasan: ' . $e->getMessage());
        }
    }
}

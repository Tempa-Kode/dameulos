<?php

namespace App\Http\Controllers;

use App\Models\PengembalianDana;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengembalianDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PengembalianDana::with(['transaksi', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter untuk admin atau user
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $pengembalianDana = $query->paginate(10);

        return view('admin.pengembalian-dana.index', compact('pengembalianDana'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil transaksi_id dari parameter
        $transaksiId = $request->get('transaksi_id');

        if (!$transaksiId) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        // Cari transaksi dan pastikan milik user yang login
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'pembayaran'])
            ->where('id', $transaksiId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaksi) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi tidak ditemukan atau bukan milik Anda.');
        }

        // Cek apakah transaksi bisa dibatalkan
        if (!$this->canCancelTransaction($transaksi)) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi dengan status "' . $transaksi->status . '" tidak dapat dibatalkan.');
        }

        // Cek apakah sudah ada pengajuan pengembalian dana
        $existingRefund = PengembalianDana::where('transaksi_id', $transaksi->id)
            ->whereIn('status', ['pending', 'diproses'])
            ->first();

        if ($existingRefund) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Sudah ada pengajuan pengembalian dana untuk transaksi ini.');
        }

        return view('pelanggan.pengembalian-dana.create', compact('transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'alasan_pembatalan' => 'required|string|min:10|max:1000',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik_rekening' => 'required|string|max:100',
            'bank' => 'required|string|max:50',
        ], [
            // Validasi transaksi_id
            'transaksi_id.required' => 'ID transaksi wajib diisi.',
            'transaksi_id.exists' => 'Transaksi yang dipilih tidak ditemukan.',

            // Validasi alasan pembatalan
            'alasan_pembatalan.required' => 'Alasan pembatalan wajib diisi.',
            'alasan_pembatalan.string' => 'Alasan pembatalan harus berupa teks.',
            'alasan_pembatalan.min' => 'Alasan pembatalan minimal harus 10 karakter.',
            'alasan_pembatalan.max' => 'Alasan pembatalan maksimal 1000 karakter.',

            // Validasi nomor rekening
            'nomor_rekening.required' => 'Nomor rekening/akun wajib diisi.',
            'nomor_rekening.string' => 'Nomor rekening/akun harus berupa teks.',
            'nomor_rekening.max' => 'Nomor rekening/akun maksimal 50 karakter.',

            // Validasi nama pemilik rekening
            'nama_pemilik_rekening.required' => 'Nama pemilik rekening/akun wajib diisi.',
            'nama_pemilik_rekening.string' => 'Nama pemilik rekening/akun harus berupa teks.',
            'nama_pemilik_rekening.max' => 'Nama pemilik rekening/akun maksimal 100 karakter.',

            // Validasi bank
            'bank.required' => 'Nama bank wajib dipilih.',
            'bank.string' => 'Nama bank harus berupa teks.',
            'bank.max' => 'Nama bank maksimal 50 karakter.',
        ]);

        try {
            DB::beginTransaction();

            // Ambil transaksi dan pastikan milik user yang login
            $transaksi = Transaksi::where('id', $request->transaksi_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$transaksi) {
                throw new \Exception('Transaksi tidak ditemukan atau bukan milik Anda.');
            }

            // Cek apakah transaksi bisa dibatalkan
            if (!$this->canCancelTransaction($transaksi)) {
                throw new \Exception('Transaksi dengan status "' . $transaksi->status . '" tidak dapat dibatalkan.');
            }

            // Cek apakah sudah ada pengajuan pengembalian dana
            $existingRefund = PengembalianDana::where('transaksi_id', $transaksi->id)
                ->whereIn('status', ['pending', 'diproses'])
                ->first();

            if ($existingRefund) {
                throw new \Exception('Sudah ada pengajuan pengembalian dana untuk transaksi ini.');
            }

            // Buat pengajuan pengembalian dana
            $pengembalianDana = PengembalianDana::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => Auth::id(),
                'kode_pengembalian' => PengembalianDana::generateKodePengembalian(),
                'jumlah_pengembalian' => $transaksi->total,
                'alasan_pembatalan' => $request->alasan_pembatalan,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik_rekening' => $request->nama_pemilik_rekening,
                'bank' => $request->bank,
                'status' => PengembalianDana::STATUS_PENDING,
                'tanggal_pengajuan' => now(),
            ]);

            // Update status transaksi menjadi dibatalkan
            $transaksi->update(['status' => 'batal']);

            // Update status pembayaran jika ada
            if ($transaksi->pembayaran) {
                $transaksi->pembayaran->update(['status' => 'dibatalkan']);
            }

            DB::commit();

            return redirect()->route('pelanggan.transaksi')
                ->with('success', 'Pengajuan pembatalan dan pengembalian dana berhasil disubmit. Kode pengembalian: ' . $pengembalianDana->kode_pengembalian);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PengembalianDana $pengembalianDana)
    {
        // Pastikan user hanya bisa melihat pengembalian dana miliknya sendiri
        if (Auth::user()->role !== 'admin' && $pengembalianDana->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pengembalianDana->load(['transaksi.detailTransaksi.produk', 'user']);

        return view('admin.pengembalian-dana.show', compact('pengembalianDana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengembalianDana $pengembalianDana)
    {
        // Hanya admin yang bisa mengedit (untuk update status)
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $pengembalianDana->load(['transaksi', 'user']);

        return view('admin.pengembalian-dana.edit', compact('pengembalianDana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengembalianDana $pengembalianDana)
    {
        // Hanya admin yang bisa update
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Validasi status
            'status.required' => 'Status pengembalian dana wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid. Pilih: Pending, Diproses, Selesai, atau Ditolak.',

            // Validasi catatan admin
            'catatan_admin.string' => 'Catatan admin harus berupa teks.',
            'catatan_admin.max' => 'Catatan admin maksimal 1000 karakter.',

            // Validasi bukti transfer
            'bukti_transfer.image' => 'File bukti transfer harus berupa gambar.',
            'bukti_transfer.mimes' => 'Format file bukti transfer harus: JPEG, PNG, atau JPG.',
            'bukti_transfer.max' => 'Ukuran file bukti transfer maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
            ];

            // Set tanggal berdasarkan status
            if ($request->status === 'diproses' && $pengembalianDana->status === 'pending') {
                $data['tanggal_diproses'] = now();
            } elseif ($request->status === 'selesai' && $pengembalianDana->status !== 'selesai') {
                $data['tanggal_selesai'] = now();
            }

            // Upload bukti transfer jika ada
            if ($request->hasFile('bukti_transfer')) {
                // Hapus bukti transfer lama jika ada
                if ($pengembalianDana->bukti_transfer) {
                    Storage::disk('public')->delete($pengembalianDana->bukti_transfer);
                }

                $path = $request->file('bukti_transfer')->store('bukti-pengembalian', 'public');
                $data['bukti_transfer'] = $path;
            }

            $pengembalianDana->update($data);

            // Jika status ditolak, kembalikan status transaksi
            if ($request->status === 'ditolak') {
                $transaksi = $pengembalianDana->transaksi;
                // Kembalikan ke status sebelumnya (misalnya dibayar)
                $transaksi->update(['status' => 'dibayar']);

                if ($transaksi->pembayaran) {
                    $transaksi->pembayaran->update(['status' => 'dibayar']);
                }
            }

            DB::commit();

            return redirect()->route('pengembalian-dana.index')
                ->with('success', 'Status pengembalian dana berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengembalianDana $pengembalianDana)
    {
        // Hanya admin yang bisa menghapus
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Hapus bukti transfer jika ada
            if ($pengembalianDana->bukti_transfer) {
                Storage::disk('public')->delete($pengembalianDana->bukti_transfer);
            }

            $pengembalianDana->delete();

            return redirect()->route('pengembalian-dana.index')
                ->with('success', 'Data pengembalian dana berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Cek apakah transaksi bisa dibatalkan
     */
    private function canCancelTransaction($transaksi)
    {
        // Hanya bisa dibatalkan jika status pending atau dibayar
        return in_array($transaksi->status, ['pending', 'dibayar']);
    }

    /**
     * Menampilkan daftar pengembalian dana untuk pelanggan
     */
    public function pelangganIndex(Request $request)
    {
        $query = PengembalianDana::with(['transaksi'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        $pengembalianDana = $query->paginate(10);

        return view('pelanggan.pengembalian-dana.index', compact('pengembalianDana'));
    }
}

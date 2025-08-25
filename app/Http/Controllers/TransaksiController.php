<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $data = Transaksi::where('preorder', false)
            ->status($status)
            ->with(['user' => function ($query) {
                $query->withCount(['transaksi as transaksi_count' => function ($q) {
                    $q->where('preorder', false);
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.transaksi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Transaksi $transaksi)
    {
        // Load transaksi dengan relasi yang diperlukan
        $transaksi->load([
            'user',
            'detailTransaksi.produk.katalog',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk',
            'pembayaran',
            'pengiriman',
            'requestWarna.kodeWarnaRequests'
        ]);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:pending,dibayar,dikonfirmasi,diproses,dikirim,batal',
            'no_resi' => 'nullable|string|max:255',
        ]);

        $transaksi->update([
            'status' => $request->status
        ]);

        if ($request->status == 'dikirim') {
            $transaksi->pengiriman()->updateOrCreate([
                'transaksi_id' => $transaksi->id,
                'nama_penerima' => $transaksi->user->name,
                'no_resi' => $request->no_resi,
                'ongkir' => $transaksi->ongkir,
                'berat' => 10,
                'alamat_pengiriman' => 'SaiTnihuta, Banjarnahor, Hutatoruan V, Kec. Tarutung, Kabupaten Tapanuli Utara, Sumatera Utara 22411',
                'alamat_penerima' => $transaksi->alamat_pengiriman,
                'catatan' => $transaksi->catatan ?? '-',
            ]);
        }

        return redirect()->route('transaksi.show', $transaksi->id)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    /**
     * Menampilkan transaksi pengguna yang sedang login
     */
    public function transaksiSaya(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Mengambil transaksi pengguna yang sedang login dengan relasi terkait
        $transaksi = Transaksi::with([
            'detailTransaksi.produk',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk',
            'pembayaran',
            'pengiriman'
        ])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($transaksi);
        return view('pelanggan.transaksi', compact('transaksi'));
    }

    /**
     * Update status transaksi dengan mengambil data dari Midtrans API
     */
    public function updateStatus($kode_transaksi)
    {
        try {
            // Cari transaksi berdasarkan kode transaksi
            $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            // Ambil server key dari config
            $serverKey = config('midtrans.server_key');

            // Buat auth string dengan Base64 encode
            $authString = base64_encode($serverKey . ':');

            // Request ke Midtrans API
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $authString
            ])->get("https://api.sandbox.midtrans.com/v2/{$kode_transaksi}/status");

            if ($response->successful()) {
                $data = $response->json();

                // Update status transaksi berdasarkan response dari Midtrans
                $this->updateTransactionStatus($transaksi, $data);

                return response()->json([
                    'success' => true,
                    'message' => 'Status transaksi berhasil diupdate',
                    'status' => $transaksi->fresh()->status
                ]);
            } else {
                Log::error('Midtrans API Error: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil status dari Midtrans'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Update Status Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate status'
            ], 500);
        }
    }

    /**
     * Update status transaksi berdasarkan response dari Midtrans
     */
    private function updateTransactionStatus($transaksi, $midtransData)
    {
        $transactionStatus = $midtransData['transaction_status'] ?? null;
        $fraudStatus = $midtransData['fraud_status'] ?? null;

        // Update status transaksi berdasarkan response Midtrans
        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'challenge') {
                    $transaksi->update(['status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $transaksi->update(['status' => 'dibayar']);
                }
                break;
            case 'settlement':
                $transaksi->update(['status' => 'dibayar']);
                break;
            case 'pending':
                $transaksi->update(['status' => 'pending']);
                break;
            case 'deny':
                $transaksi->update(['status' => 'gagal']);
                break;
            case 'expire':
                $transaksi->update(['status' => 'gagal']);
                break;
            case 'cancel':
                $transaksi->update(['status' => 'gagal']);
                break;
            default:
                // Jika status tidak dikenali, biarkan status tetap
                break;
        }

        // Update status pembayaran jika ada
        if ($transaksi->pembayaran) {
            $paymentStatus = match($transactionStatus) {
                'settlement', 'capture' => 'dibayar',
                'pending' => 'pending',
                'deny', 'expire', 'cancel' => 'gagal',
                default => $transaksi->pembayaran->status
            };

            $transaksi->pembayaran->update(['status' => $paymentStatus]);
        }
    }

    /**
     * Download report transaksi berdasarkan status
     */
    public function downloadReport(Request $request)
    {
        $request->validate([
            'status' => 'nullable',
            'start' => 'nullable',
            'end' => 'nullable',
        ]);
        $status = $request->input('status');

        // Query transaksi berdasarkan status
        $query = Transaksi::where('preorder', false)->with([
            'user',
            'detailTransaksi.produk.katalog',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk'
        ]);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('start') && $request->filled('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        // Jika tidak ada data
        if ($transaksi->isEmpty()) {
            return redirect()->route('transaksi.index')
                ->with('warning', 'Tidak ada data transaksi untuk status yang dipilih.');
        }

        // Tentukan nama status untuk file
        $statusText = $status && $status !== 'all' ? ucfirst($status) : 'Semua Status';

        // Generate filename
        $filename = 'laporan_transaksi_' . str_replace(' ', '_', $statusText) . '_' . date('Y-m-d_H-i-s') . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('admin.transaksi.report-pdf', [
            'transaksi' => $transaksi,
            'statusText' => $statusText,
            'status' => $status
        ]);

        // Set paper size dan orientation
        $pdf->setPaper('A4', 'landscape');

        // Return PDF download
        return $pdf->stream($filename);
    }

    /**
     * Menampilkan form edit detail transaksi (ukuran dan warna)
     */
    public function editDetail(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang sedang login
        if ($transaksi->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Cek apakah transaksi bisa diedit
        if (!$transaksi->canEditDetails()) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi dengan status "' . $transaksi->status . '" tidak dapat diedit lagi.');
        }

        // Load relasi yang diperlukan
        $transaksi->load([
            'detailTransaksi.produk.ukuranProduk',
            'detailTransaksi.produk.jenisWarnaProduk',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk'
        ]);

        return view('pelanggan.edit-detail-transaksi', compact('transaksi'));
    }

    /**
     * Update detail transaksi (ukuran dan warna)
     */
    public function updateDetail(Request $request, Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang sedang login
        if ($transaksi->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Cek apakah transaksi bisa diedit
        if (!$transaksi->canEditDetails()) {
            return redirect()->route('pelanggan.transaksi')
                ->with('error', 'Transaksi dengan status "' . $transaksi->status . '" tidak dapat diedit lagi.');
        }

        $request->validate([
            'details' => 'required|array',
            'details.*.ukuran_produk_id' => 'required|exists:ukuran_produk,id',
            'details.*.jenis_warna_produk_id' => 'required|exists:jenis_warna_produk,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->details as $detailId => $data) {
                $detail = $transaksi->detailTransaksi()->find($detailId);

                if ($detail) {
                    $detail->update([
                        'ukuran_produk_id' => $data['ukuran_produk_id'],
                        'jenis_warna_produk_id' => $data['jenis_warna_produk_id'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pelanggan.transaksi')
                ->with('success', 'Detail transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui detail transaksi.')
                ->withInput();
        }
    }
}

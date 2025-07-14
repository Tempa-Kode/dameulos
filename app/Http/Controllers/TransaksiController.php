<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::with('user')->get();
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
        //
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
        //
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
                'settlement', 'capture' => 'paid',
                'pending' => 'pending',
                'deny', 'expire', 'cancel' => 'failed',
                default => $transaksi->pembayaran->status
            };

            $transaksi->pembayaran->update(['status' => $paymentStatus]);
        }
    }
}

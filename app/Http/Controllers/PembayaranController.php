<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function bayar(Request $request)
    {
        \Midtrans\Config::$serverKey = "Mid-server-iJIfyYiHT1kCE3c1NML_WrTn";
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        DB::transaction(function() use($request) {
            $pembayaran = Pembayaran::create([
                'transaksi_id' => $request->transaksi_id,
                'kode_transaksi' => $request->kode_transaksi,
                'total_pembayaran' => $request->total_pembayaran,
                'tanggal_pembayaran' => now()->format('Y-m-d H:i:s')
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id'     => $pembayaran->kode_transaksi,
                    'gross_amount' => $pembayaran->total_pembayaran,
                ],
                'customer_details' => [
                    'name' => Auth::user()->name,
                    'email'=> Auth::user()->email,
                    'phone' => Auth::user()->no_telp,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $pembayaran->snap_token = $snapToken;
            $pembayaran->save();

            $this->response['snap_token'] = $snapToken;
        });

        return response()->json([
            'status'     => 'success',
            'snap_token' => $this->response,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}

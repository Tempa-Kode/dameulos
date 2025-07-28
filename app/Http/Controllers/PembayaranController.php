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
        $pembayaran = Pembayaran::where('kode_transaksi', $request->kode_transaksi)->first();
        if ($pembayaran && $pembayaran->status == 'pending') {
            return response()->json([
                'status'     => 'success',
                'data'       => $pembayaran,
                'snap_token' => ['snap_token' => $pembayaran->snap_token],
            ]);
        } else {

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
    }

    /**
     * upload bukti pembayaran berdasarkan kode transaksi
     */
    public function uploadBuktiPembayaran(Request $request, $pembayaranId)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_transfer.required' => 'Bukti pembayaran harus diunggah.',
            'bukti_transfer.image' => 'File yang diunggah harus berupa gambar.',
            'bukti_transfer.mimes' => 'File yang diunggah harus berformat jpg, jpeg, atau png.',
            'bukti_transfer.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);
        $pembayaran = Pembayaran::find($pembayaranId);

        $file = $request->file('bukti_transfer');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti_transfer'), $filename);
        $pembayaran->bukti_transfer = 'uploads/bukti_transfer/' . $filename;
        $pembayaran->save();
        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah.');
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

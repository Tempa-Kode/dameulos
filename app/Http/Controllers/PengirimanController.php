<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengirimanController extends Controller
{
    public function index()
    {
        $data = Pengiriman::all();
        return view('admin.pengiriman.index', compact('data'));
    }

    public function cekDestinasiTujuan(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('KOMERCE_API_KEY') // disarankan simpan di .env
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $request->query('search'),
            // 'limit' => $request->query('limit', 10),
            // 'offset' => $request->query('offset', 0),
        ]);

        return response()->json($response->json(), $response->status());
    }

    public function cekOngkir(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|integer',
            'destination' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'key' => env('KOMERCE_API_KEY')
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'weight' => env('KOMERCE_WEIGHT'),
            'courier' => env('KOMERCE_COURIER'),
        ]);

        return response()->json($response->json(), $response->status());
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
    public function show(Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        //
    }
}

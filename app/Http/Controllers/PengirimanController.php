<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PengirimanController extends Controller
{
    public function index()
    {
        $data = Pengiriman::with('transaksi')->get();
        return view('admin.pengiriman.index', compact('data'));
    }

    public function cekDestinasiTujuan(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('KOMERCE_API_KEY', "ew0ZJZz513ba1d44c4878df9wHk40hkr")
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $request->query('search'),
        ]);

        return response()->json($response->json(), $response->status());
    }

    public function cekOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('KOMERCE_API_KEY', "ew0ZJZz513ba1d44c4878df9wHk40hkr"),
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => env('ORIGIN_LOCATION_ID', "28400"),
            'destination' => $request->destination,
            'weight' => env('KOMERCE_WEIGHT', 10),
            'courier' => env('KOMERCE_COURIER', 'jnt'),
        ]);

        return response()->json($response->json());
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
        // Load pengiriman dengan relasi transaksi dan detailnya
        $pengiriman->load([
            'transaksi.user',
            'transaksi.detailTransaksi.produk.katalog',
            'transaksi.detailTransaksi.ukuranProduk',
            'transaksi.detailTransaksi.jenisWarnaProduk',
            'transaksi.pembayaran'
        ]);

        return view('admin.pengiriman.show', compact('pengiriman'));
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

    /**
     * Print shipping label
     */
    public function printLabel($id)
    {
        $pengiriman = Pengiriman::with(['transaksi.user', 'transaksi.detailTransaksi.produk', 'transaksi.detailTransaksi.ukuranProduk', 'transaksi.detailTransaksi.jenisWarnaProduk'])
            ->findOrFail($id);

        return view('admin.pengiriman.print-label', compact('pengiriman'));
    }

    public function downloadReport()
    {
        // Ambil data pengiriman dengan relasi
        $data = Pengiriman::with(['transaksi.user', 'transaksi.detailTransaksi.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalPengiriman = $data->count();
        $totalOngkir = $data->sum('ongkir');
        $totalBerat = $data->sum('berat');

        // Statistik per status
        $statusStats = [
            'pending' => $data->where('transaksi.status', 'pending')->count(),
            'dibayar' => $data->where('transaksi.status', 'dibayar')->count(),
            'dikonfirmasi' => $data->where('transaksi.status', 'dikonfirmasi')->count(),
            'diproses' => $data->where('transaksi.status', 'diproses')->count(),
            'dikirim' => $data->where('transaksi.status', 'dikirim')->count(),
            'batal' => $data->where('transaksi.status', 'batal')->count(),
        ];

        $pdf = PDF::loadView('admin.pengiriman.report-pdf', compact('data', 'totalPengiriman', 'totalOngkir', 'totalBerat', 'statusStats'));

        return $pdf->download('laporan_pengiriman_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function previewReport()
    {
        // Ambil data pengiriman dengan relasi
        $data = Pengiriman::with(['transaksi.user', 'transaksi.detailTransaksi.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalPengiriman = $data->count();
        $totalOngkir = $data->sum('ongkir');
        $totalBerat = $data->sum('berat');

        // Statistik per status
        $statusStats = [
            'pending' => $data->where('transaksi.status', 'pending')->count(),
            'dibayar' => $data->where('transaksi.status', 'dibayar')->count(),
            'dikonfirmasi' => $data->where('transaksi.status', 'dikonfirmasi')->count(),
            'diproses' => $data->where('transaksi.status', 'diproses')->count(),
            'dikirim' => $data->where('transaksi.status', 'dikirim')->count(),
            'batal' => $data->where('transaksi.status', 'batal')->count(),
        ];

        $pdf = PDF::loadView('admin.pengiriman.report-pdf', compact('data', 'totalPengiriman', 'totalOngkir', 'totalBerat', 'statusStats'));

        return $pdf->stream('laporan_pengiriman_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}

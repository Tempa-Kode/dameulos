<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PreOrderController extends Controller
{
    public function index()
    {
        $data = \App\Models\Transaksi::where('preorder', true)
            ->with([
                'user',
                'detailTransaksi.produk.katalog',
                'detailTransaksi.ukuranProduk',
            ])
            ->get();

        return view('admin.preorder.index', compact('data'));
    }

    public function downloadReport(Request $request)
    {
        $status = $request->input('status');

        // Query transaksi berdasarkan status
        $query = Transaksi::where('preorder', true)->with([
            'user',
            'detailTransaksi.produk.katalog',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk'
        ]);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        // Jika tidak ada data
        if ($transaksi->isEmpty()) {
            return redirect()->route('preorder.index')
                ->with('warning', 'Tidak ada data transaksi untuk status yang dipilih.');
        }

        // Tentukan nama status untuk file
        $statusText = $status && $status !== 'all' ? ucfirst($status) : 'Semua Status';

        // Generate filename
        $filename = 'laporan_preorder_' . str_replace(' ', '_', $statusText) . '_' . date('Y-m-d_H-i-s') . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('admin.transaksi.report-pdf', [
            'transaksi' => $transaksi,
            'statusText' => $statusText,
            'status' => $status
        ]);

        // Set paper size dan orientation
        $pdf->setPaper('A4', 'landscape');

        // Return PDF download
        return $pdf->download($filename);
    }

    /**
     * Preview report transaksi dalam browser sebelum download
     */
    public function previewReport(Request $request)
    {
        $status = $request->input('status');

        // Query transaksi berdasarkan status
        $query = Transaksi::where('preoder', true)->with([
            'user',
            'detailTransaksi.produk.katalog',
            'detailTransaksi.ukuranProduk',
            'detailTransaksi.jenisWarnaProduk'
        ]);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        // Jika tidak ada data
        if ($transaksi->isEmpty()) {
            return redirect()->route('preorder.index')
                ->with('warning', 'Tidak ada data transaksi untuk status yang dipilih.');
        }

        // Tentukan nama status untuk file
        $statusText = $status && $status !== 'all' ? ucfirst($status) : 'Semua Status';

        // Generate PDF
        $pdf = Pdf::loadView('admin.transaksi.report-pdf', [
            'transaksi' => $transaksi,
            'statusText' => $statusText,
            'status' => $status
        ]);

        // Set paper size dan orientation
        $pdf->setPaper('A4', 'landscape');

        // Return PDF untuk preview di browser
        return $pdf->stream('preview_laporan_transaksi.pdf');
    }
}

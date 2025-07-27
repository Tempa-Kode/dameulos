<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'pelanggan')->get();
        return view('admin.pelanggan.index', compact('data'));
    }

    public function show(string $id)
    {
        $pelanggan = User::where('role', 'pelanggan')->findOrFail($id);
        return view('admin.pelanggan.detail', compact('pelanggan'));
    }

    public function destroy(string $id)
    {
        try {
            $pelanggan = User::where('role', 'pelanggan')->findOrFail($id);

            $pelangganName = $pelanggan->name;
            $pelanggan->delete();

            return redirect()->route('pelanggan.index')
                ->with('success', "pelanggan '$pelangganName' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pelanggan: ' . $e->getMessage());
        }
    }

    public function downloadReport()
    {
        $data = User::where('role', 'pelanggan')
            ->withCount(['transaksi as jumlah_transaksi' => function ($query) {
                $query->select(\DB::raw('COALESCE(COUNT(id),0)'));
            }])
            ->orderBy('jumlah_transaksi', 'desc')
            ->get();

        $filename = 'laporan_pelanggan_' . date('Y-m-d_H-i-s') . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('admin.pelanggan.report-pdf', compact('data'));

        // Set paper size dan orientation
        $pdf->setPaper('A4', 'landscape');

        // Return PDF download
        return $pdf->stream($filename);
    }

}

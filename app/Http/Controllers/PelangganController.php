<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}

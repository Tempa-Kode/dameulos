<?php

namespace App\Http\Controllers;

use App\Models\Promosi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromosiController extends Controller
{
    public function index()
    {
        $data = Promosi::all();
        return view('admin.promosi.index', compact('data'));
    }

    public function create()
    {
        return view('admin.promosi.tambah');
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'judul.required' => 'Judul promosi harus diisi.',
            'deskripsi.required' => 'Deskripsi promosi harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'File yang diunggah harus berformat jpeg, png, jpg, gif, atau svg.',
            'gambar.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        DB::beginTransaction();
        try {
            $promosi = new Promosi();
            $promosi->judul = $validasi['judul'];
            $promosi->deskripsi = $validasi['deskripsi'];

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/promosi'), $filename);
                $promosi->gambar = 'uploads/promosi/' . $filename;
            }

            $promosi->save();
            DB::commit();

            return redirect()->route('promosi.index')->with('success', 'Promosi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan promosi: ' . $e->getMessage()]);
        }
    }

    public function show(Promosi $promosi)
    {
        return view('admin.promosi.detail', compact('promosi'));
    }

    public function edit(Promosi $promosi)
    {
        $data = $promosi;
        return view('admin.promosi.edit', compact('data'));
    }

    public function update(Request $request, Promosi $promosi)
    {
        $validasi = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'judul.required' => 'Judul promosi harus diisi.',
            'deskripsi.required' => 'Deskripsi promosi harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'File yang diunggah harus berformat jpeg, png, jpg, gif, atau svg.',
            'gambar.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        DB::beginTransaction();
        try {
            $promosi->judul = $validasi['judul'];
            $promosi->deskripsi = $validasi['deskripsi'];

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/promosi'), $filename);
                $promosi->gambar = 'uploads/promosi/' . $filename;
            }

            $promosi->save();
            DB::commit();

            return redirect()->route('promosi.index')->with('success', 'Promosi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui promosi: ' . $e->getMessage()]);
        }
    }

    public function destroy(Promosi $promosi)
    {
        DB::beginTransaction();
        try {
            $promosi->delete();
            DB::commit();

            return redirect()->route('promosi.index')->with('success', 'Promosi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus promosi: ' . $e->getMessage()]);
        }
    }
}

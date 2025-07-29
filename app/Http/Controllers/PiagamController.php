<?php

namespace App\Http\Controllers;

use App\Models\Piagam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PiagamController extends Controller
{
    public function index()
    {
        $data = Piagam::all();
        return view('admin.piagam.index', compact('data'));
    }

    public function create()
    {
        return view('admin.piagam.tambah');
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
            $piagam = new Piagam();
            $piagam->judul = $validasi['judul'];
            $piagam->deskripsi = $validasi['deskripsi'];

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/piagam'), $filename);
                $piagam->gambar = 'uploads/piagam/' . $filename;
            }

            $piagam->save();
            DB::commit();

            return redirect()->route('piagam.index')->with('success', 'Piagam berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan piagam: ' . $e->getMessage()]);
        }
    }

    public function show(Piagam $piagam)
    {
        return view('admin.piagam.detail', compact('piagam'));
    }

    public function edit(Piagam $piagam)
    {
        $data = $piagam;
        return view('admin.piagam.edit', compact('data'));
    }

    public function update(Request $request, Piagam $piagam)
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
            $piagam->judul = $validasi['judul'];
            $piagam->deskripsi = $validasi['deskripsi'];

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/piagam'), $filename);
                $piagam->gambar = 'uploads/piagam/' . $filename;
            }

            $piagam->save();
            DB::commit();

            return redirect()->route('piagam.index')->with('success', 'Piagam berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui piagam: ' . $e->getMessage()]);
        }
    }

    public function destroy(Piagam $piagam)
    {
        DB::beginTransaction();
        try {
            $piagam->delete();
            DB::commit();

            return redirect()->route('piagam.index')->with('success', 'Piagam berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus piagam: ' . $e->getMessage()]);
        }
    }
}

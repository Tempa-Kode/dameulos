<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $data = Katalog::all();
        return view('admin.katalog.index', compact('data'));
    }
    public function create()
    {
        return view('admin.katalog.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ], [
            'nama.required' => 'Nama katalog harus diisi.',
            'nama.max' => 'Nama katalog tidak boleh lebih dari 50 karakter.',
        ]);

        try {
            Katalog::create([
                'nama' => $request->nama,
                'slug' => Str::slug($request->nama, '-'),
            ]);
            return redirect()->route('katalog.index')->with('success', 'Katalog berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan katalog: ' . $e->getMessage()]);
        }
    }

    public function edit(Katalog $katalog)
    {
        $data = Katalog::findOrFail($katalog->id);
        return view('admin.katalog.edit', compact('data'));
    }

    public function update(Request $request, Katalog $katalog)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ], [
            'nama.required' => 'Nama katalog harus diisi.',
            'nama.max' => 'Nama katalog tidak boleh lebih dari 50 karakter.',
        ]);

        try {
            $katalog->update([
                'nama' => $request->nama,
                'slug' => Str::slug($request->nama, '-'),
            ]);
            return redirect()->route('katalog.index')->with('success', 'Katalog berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui katalog: ' . $e->getMessage()]);
        }
    }

    public function destroy(Katalog $katalog)
    {
        try {
            $katalog->delete();
            return redirect()->route('katalog.index')->with('success', 'Katalog berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus katalog: ' . $e->getMessage());
        }
    }
}

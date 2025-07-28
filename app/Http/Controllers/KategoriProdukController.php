<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $data = KategoriProduk::all();
        return view('admin.kategori.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kategori.tambah');
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_kategori' => 'required|max:100',
            'keterangan' => 'nullable|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 100 karakter.',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        DB::beginTransaction();

        try {
            $data = KategoriProduk::create($validasi);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', "Kategori produk {$data->nama_kategori} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan kategori produk: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $data = KategoriProduk::findOrFail($id);

        if (!$data) {
            return redirect()->route('kategori.index')->withErrors(['error' => 'Kategori produk tidak ditemukan.']);
        }

        return view('admin.kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama_kategori' => 'required|max:100',
            'keterangan' => 'nullable|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 100 karakter.',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        DB::beginTransaction();

        try {
            $kategori = KategoriProduk::findOrFail($id);
            $kategori->update($validasi);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', "Kategori produk {$kategori->nama_kategori} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui kategori produk: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $kategori = KategoriProduk::findOrFail($id);
            $kategori->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', "Kategori produk {$kategori->nama_kategori} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus kategori produk: ' . $e->getMessage()]);
        }
    }
}

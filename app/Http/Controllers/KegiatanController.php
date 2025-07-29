<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KegiatanController extends Controller
{
    // Menampilkan semua kegiatan
    public function index()
    {
        $data = Kegiatan::latest()->get();
        return view('admin.kegiatan.index', compact('data'));
    }

    // Tampilkan form tambah kegiatan
    public function create()
    {
        return view('admin.kegiatan.tambah');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ], [
            'judul.required' => 'Judul kegiatan harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'File yang diunggah harus berformat jpeg, png, jpg, gif, atau svg.',
            'gambar.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'content.required' => 'Konten kegiatan harus diisi.',
        ]);

        $file = $request->file('gambar');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('uploads/konten'), $filename);

        Kegiatan::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'content' => $request->content,
            'gambar' => 'uploads/konten/' . $filename,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Berita berhasil ditambahkan');
    }

    // Tampilkan detail kegiatan
    public function show(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    // Tampilkan form edit
    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    // Update data
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ], [
            'judul.required' => 'Judul kegiatan harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'File yang diunggah harus berformat jpeg, png, jpg, gif, atau svg.',
            'gambar.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'content.required' => 'Konten kegiatan harus diisi.',
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'content' => $request->content,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kegiatan->gambar && file_exists(public_path($kegiatan->gambar))) {
                unlink(public_path($kegiatan->gambar));
            }

            // Simpan gambar baru
            $file = $request->file('gambar');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konten'), $filename);

            $data['gambar'] = 'uploads/konten/' . $filename;
        }

        $kegiatan->update($data);

        return redirect()->route('kegiatan.index')->with('success', 'Berita berhasil diperbarui');
    }

    // Hapus data
    public function destroy(Kegiatan $kegiatan)
    {
        // Hapus file gambar jika ada dan file-nya benar-benar ada di disk
        if ($kegiatan->gambar && file_exists(public_path($kegiatan->gambar))) {
            unlink(public_path($kegiatan->gambar));
        }

        // Hapus data dari database
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Berita berhasil dihapus');
    }


    // ✅ Upload gambar dari CKEditor
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konten'), $filename);

            return response()->json([
                'uploaded' => true,
                'url' => asset('uploads/konten/' . $filename)
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'No file uploaded.']
        ], 400);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FotoProduk;
use App\Models\JenisWarnaProduk;
use App\Models\Katalog;
use App\Models\Produk;
use App\Models\Ukuran;
use App\Models\UkuranProduk;
use App\Models\Warna;
use App\Models\WarnaProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::with(['katalog', 'ukuran', 'warnaProduk'])->get();
        return view('admin.produk.index', compact('data'));
    }

    public function create()
    {
        $katalog = Katalog::all();
        return view('admin.produk.tambah', compact('katalog'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'katalog_id' => 'required|exists:katalog,id',
            'nama' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'jenisWarna' => 'required|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|min:1',
            'ukuran.*' => 'nullable|string|max:50',
            'warna' => 'nullable|min:1',
            'warna.*' => 'nullable|string|max:50',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'foto_produk' => 'nullable|array',
            'foto_produk.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'katalog_id.required' => 'Katalog harus dipilih.',
            'nama.required' => 'Nama produk harus diisi.',
            'nama.max' => 'Nama produk tidak boleh lebih dari 50 karakter.',
            'deskripsi.required' => 'Deskripsi produk harus diisi.',
            'jenisWarna.required' => 'jenis warna produk harus diisi.',
            'jenisWarna.min' => 'Minimal satu jenis warna harus diisi.',
            'harga.required' => 'Harga produk harus diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'stok.required' => 'Stok produk harus diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'ukuran.required' => 'Ukuran produk harus diisi.',
            'ukuran.min' => 'Minimal satu ukuran harus diisi.',
            'ukuran.*.required' => 'Ukuran harus diisi.',
            'ukuran.*.string' => 'Ukuran harus berupa teks.',
            'ukuran.*.max' => 'Ukuran tidak boleh lebih dari 50 karakter.',
            'warna.required' => 'Warna produk harus diisi.',
            'warna.min' => 'Minimal satu warna harus diisi.',
            'warna.*.required' => 'Warna harus diisi.',
            'warna.*.string' => 'Warna harus berupa teks.',
            'warna.*.max' => 'Warna tidak boleh lebih dari 50 karakter.',
            'gambar.required' => 'Gambar produk harus diunggah.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 10mb.',
            'foto_produk.*.image' => 'File foto produk harus berupa gambar.',
            'foto_produk.*.mimes' => 'Foto produk harus berformat jpeg, png, jpg, atau gif.',
            'foto_produk.*.max' => 'Ukuran foto produk tidak boleh lebih dari 10mb.'
        ]);

        try {
            // Generate slug dari nama produk
            $slug = Str::slug($validated['nama']);

            // Pastikan slug unik
            $originalSlug = $slug;
            $counter = 1;
            while (Produk::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Handle upload gambar
            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarName = time() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('images/produk'), $gambarName);
                $gambarPath = 'images/produk/' . $gambarName;
            }

            // Simpan data produk
            $produk = Produk::create([
                'katalog_id' => $validated['katalog_id'],
                'nama' => $validated['nama'],
                'slug' => $slug,
                'deskripsi' => $validated['deskripsi'],
                'warna' => $validated['warna'],
                'harga' => $validated['harga'],
                'stok' => $validated['stok'],
                'gambar' => $gambarPath
            ]);

            foreach (array_filter($validated['ukuran']) as $ukuranNama) {
                $ukuran = UkuranProduk::create([
                    'produk_id' => $produk->id,
                    'ukuran' => trim($ukuranNama)
                ]);
            }

            foreach (array_filter($validated['jenisWarna']) as $warna) {
                $jenisWarna = JenisWarnaProduk::create([
                    'produk_id' => $produk->id,
                    'warna' => trim($warna)
                ]);
            }

            foreach (array_filter($validated['warna']) as $warnaNama) {
                $warna = WarnaProduk::create([
                    'produk_id' => $produk->id,
                    'kode_warna' => trim($warnaNama)
                ]);
            }

            // Handle upload foto produk tambahan
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $foto) {
                    $fotoName = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                    $foto->move(public_path('images/produk'), $fotoName);
                    $fotoPath = 'images/produk/' . $fotoName;

                    FotoProduk::create([
                        'produk_id' => $produk->id,
                        'foto' => $fotoPath
                    ]);
                }
            }

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage());
        }
    }

    public function show(Produk $produk)
    {
        $produk->load(['katalog', 'ukuran', 'warnaProduk', 'jenisWarnaProduk', 'fotoProduk', 'ulasan.user']);

        // Load ulasan dengan pagination dan relasi
        $ulasan = $produk->ulasan()->with(['user', 'transaksi'])->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.produk.detail', compact('produk', 'ulasan'));
    }    public function edit(Produk $produk)
    {
        $produk->load(['katalog', 'ukuran', 'warnaProduk', 'jenisWarnaProduk', 'fotoProduk']);

        $katalog = Katalog::all();
        return view('admin.produk.edit', compact('produk', 'katalog'));
    }

    public function update(Request $request, Produk $produk)
    {
        // Validasi input
        $validated = $request->validate([
            'katalog_id' => 'required|exists:katalog,id',
            'nama' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'jenisWarna' => 'required|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|min:1',
            'ukuran.*' => 'nullable|string|max:50',
            'warna' => 'nullable|min:1',
            'warna.*' => 'nullable|string|max:50',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'foto_produk' => 'nullable|array',
            'foto_produk.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'hapus_foto' => 'nullable|array',
            'hapus_foto.*' => 'nullable|integer|exists:foto_produk,id'
        ], [
            'katalog_id.required' => 'Katalog harus dipilih.',
            'nama.required' => 'Nama produk harus diisi.',
            'nama.max' => 'Nama produk tidak boleh lebih dari 50 karakter.',
            'deskripsi.required' => 'Deskripsi produk harus diisi.',
            'jenisWarna.required' => 'jenis warna produk harus diisi.',
            'jenisWarna.min' => 'Minimal satu jenis warna harus diisi.',
            'harga.required' => 'Harga produk harus diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'stok.required' => 'Stok produk harus diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'ukuran.required' => 'Ukuran produk harus diisi.',
            'ukuran.min' => 'Minimal satu ukuran harus diisi.',
            'ukuran.*.required' => 'Ukuran harus diisi.',
            'ukuran.*.string' => 'Ukuran harus berupa teks.',
            'ukuran.*.max' => 'Ukuran tidak boleh lebih dari 50 karakter.',
            'warna.required' => 'Warna produk harus diisi.',
            'warna.min' => 'Minimal satu warna harus diisi.',
            'warna.*.required' => 'Warna harus diisi.',
            'warna.*.string' => 'Warna harus berupa teks.',
            'warna.*.max' => 'Warna tidak boleh lebih dari 50 karakter.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 10mb.',
            'foto_produk.*.image' => 'File foto produk harus berupa gambar.',
            'foto_produk.*.mimes' => 'Foto produk harus berformat jpeg, png, jpg, atau gif.',
            'foto_produk.*.max' => 'Ukuran foto produk tidak boleh lebih dari 10mb.'
        ]);

        try {
            // Generate slug dari nama produk jika nama berubah
            if ($produk->nama !== $validated['nama']) {
                $slug = Str::slug($validated['nama']);

                // Pastikan slug unik
                $originalSlug = $slug;
                $counter = 1;
                while (Produk::where('slug', $slug)->where('id', '!=', $produk->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $validated['slug'] = $slug;
            }

            // Handle upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                    unlink(public_path($produk->gambar));
                }

                $gambar = $request->file('gambar');
                $gambarName = time() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('images/produk'), $gambarName);
                $validated['gambar'] = 'images/produk/' . $gambarName;
            }

            // Update data produk
            $produk->update([
                'katalog_id' => $validated['katalog_id'],
                'nama' => $validated['nama'],
                'slug' => $validated['slug'] ?? $produk->slug,
                'deskripsi' => $validated['deskripsi'],
                'warna' => $validated['warna'],
                'harga' => $validated['harga'],
                'stok' => $validated['stok'],
                'gambar' => $validated['gambar'] ?? $produk->gambar
            ]);

            // Hapus ukuran, jenis warna dan warna lama
            UkuranProduk::where('produk_id', $produk->id)->delete();
            JenisWarnaProduk::where('produk_id', $produk->id)->delete();
            WarnaProduk::where('produk_id', $produk->id)->delete();

            // Tambah jenis warna baru
            foreach (array_filter($validated['jenisWarna']) as $warna) {
                JenisWarnaProduk::create([
                    'produk_id' => $produk->id,
                    'warna' => trim($warna)
                ]);
            }

            // Tambah ukuran baru
            foreach (array_filter($validated['ukuran']) as $ukuranNama) {
                UkuranProduk::create([
                    'produk_id' => $produk->id,
                    'ukuran' => trim($ukuranNama)
                ]);
            }

            // Tambah warna baru
            foreach (array_filter($validated['warna']) as $warnaNama) {
                WarnaProduk::create([
                    'produk_id' => $produk->id,
                    'kode_warna' => trim($warnaNama)
                ]);
            }

            // Handle penghapusan foto produk yang dipilih
            if ($request->has('hapus_foto') && is_array($request->hapus_foto)) {
                $fotoHapus = FotoProduk::whereIn('id', $request->hapus_foto)
                    ->where('produk_id', $produk->id)
                    ->get();

                foreach ($fotoHapus as $foto) {
                    // Hapus file fisik
                    if ($foto->foto && file_exists(public_path($foto->foto))) {
                        unlink(public_path($foto->foto));
                    }
                    // Hapus record dari database
                    $foto->delete();
                }
            }

            // Handle upload foto produk baru
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $foto) {
                    $fotoName = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                    $foto->move(public_path('images/produk'), $fotoName);
                    $fotoPath = 'images/produk/' . $fotoName;

                    FotoProduk::create([
                        'produk_id' => $produk->id,
                        'foto' => $fotoPath
                    ]);
                }
            }

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            // Hapus gambar utama jika ada
            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            // Hapus foto produk tambahan
            $fotoProduk = FotoProduk::where('produk_id', $produk->id)->get();
            foreach ($fotoProduk as $foto) {
                if ($foto->foto && file_exists(public_path($foto->foto))) {
                    unlink(public_path($foto->foto));
                }
                $foto->delete();
            }

            // Hapus relasi dengan ukuran dan warna (akan otomatis terhapus karena onDelete cascade)
            // Tidak perlu manual delete karena foreign key constraint sudah cascade

            // Hapus produk
            $produk->delete();

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Hapus foto produk individual
     */
    public function hapusFoto($id)
    {
        try {
            $foto = FotoProduk::findOrFail($id);

            // Hapus file fisik
            if ($foto->foto && file_exists(public_path($foto->foto))) {
                unlink(public_path($foto->foto));
            }

            // Hapus record dari database
            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus ulasan produk (khusus admin)
     */
    public function hapusUlasan($ulasanId)
    {
        try {
            $ulasan = \App\Models\Ulasan::findOrFail($ulasanId);
            $produkId = $ulasan->produk_id;

            $ulasan->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ulasan berhasil dihapus.'
                ]);
            }

            return redirect()->route('produk.show', $produkId)
                ->with('success', 'Ulasan berhasil dihapus.');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus ulasan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus ulasan: ' . $e->getMessage());
        }
    }
}

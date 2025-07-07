<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManajerController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'manajer')->get();
        return view('admin.manajer.index', compact('data'));
    }

    public function create()
    {
        return view('admin.manajer.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|max:20',
            'alamat' => 'nullable',
        ], [
            'name.required' => 'Nama manajer harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.required' => 'Nomor telepon harus diisi.',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'alamat.nullable' => 'Alamat boleh kosong.',
            'alamat.string' => 'Alamat harus berupa string.',
        ]);

        try {
            $passwordSementara = Str::random(8);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($passwordSementara),
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'role' => 'manajer',
            ]);

            return redirect()->route('manajer.index')->with('success', "Manajer berhasil $request->name berhasil ditambah. Password sementara: $passwordSementara");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan manajer: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $manajer = User::where('role', 'manajer')->findOrFail($id);
        return view('admin.manajer.detail', compact('manajer'));
    }

    public function edit(string $id)
    {
        $manajer = User::where('role', 'manajer')->findOrFail($id);
        return view('admin.manajer.edit', compact('manajer'));
    }

    public function update(Request $request, string $id)
    {
        $manajer = User::where('role', 'manajer')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Nama manajer harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.required' => 'Nomor telepon harus diisi.',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $manajer->update($updateData);

            return redirect()->route('manajer.show', $id)
                ->with('success', 'Data manajer berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui manajer: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $manajer = User::where('role', 'manajer')->findOrFail($id);

            // Pastikan tidak menghapus manajer yang sedang login
            if (Auth::id() == $manajer->id) {
                return redirect()->back()
                    ->with('error', 'Anda tidak dapat menghapus akun manajer yang sedang aktif.');
            }

            $manajerName = $manajer->name;
            $manajer->delete();

            return redirect()->route('manajer.index')
                ->with('success', "Manajer '$manajerName' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus manajer: ' . $e->getMessage());
        }
    }
}

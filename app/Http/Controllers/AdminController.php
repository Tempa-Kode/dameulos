<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'admin')->get();
        return view('admin.admin.index', compact('data'));
    }

    public function create()
    {
        return view('admin.admin.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|max:20',
            'alamat' => 'nullable',
        ], [
            'name.required' => 'Nama admin harus diisi.',
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
                'role' => 'admin',
            ]);

            return redirect()->route('admin.index')->with('success', "Admin berhasil $request->name. Password sementara: $passwordSementara");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan admin: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.admin.detail', compact('admin'));
    }

    public function edit(string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Nama admin harus diisi.',
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

            $admin->update($updateData);

            return redirect()->route('admin.show', $id)
                ->with('success', 'Data admin berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $admin = User::where('role', 'admin')->findOrFail($id);
            
            // Pastikan tidak menghapus admin yang sedang login
            if (Auth::id() == $admin->id) {
                return redirect()->back()
                    ->with('error', 'Anda tidak dapat menghapus akun admin yang sedang aktif.');
            }

            $adminName = $admin->name;
            $admin->delete();

            return redirect()->route('admin.index')
                ->with('success', "Admin '$adminName' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}

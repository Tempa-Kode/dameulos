# 📋 Dokumentasi Alert Component - Laravel

Panduan lengkap penggunaan sistem alert untuk aplikasi Laravel Anda.

## 🎯 Overview

Komponen alert ini dibuat untuk menampilkan berbagai jenis pesan notifikasi di aplikasi Laravel dengan styling Bootstrap yang konsisten dan user-friendly.

**Lokasi File:** `resources/views/components/alert.blade.php`

## 🚀 Instalasi & Setup

### 1. Struktur File
```
resources/
└── views/
    └── components/
        └── alert.blade.php
```

### 2. Cara Menggunakan
Tambahkan di template blade Anda:
```blade
@include('components.alert')
```

## 📢 Jenis Alert yang Tersedia

### ✅ Success Alert (Hijau)
```php
// Di Controller
return redirect()->route('katalog.index')->with('success', 'Katalog berhasil ditambahkan!');
return redirect()->back()->with('success', 'Data berhasil disimpan!');
```

### ❌ Error Alert (Merah)
```php
// Di Controller
return redirect()->back()->with('error', 'Gagal menambahkan katalog!');
return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
```

### ℹ️ Info Alert (Biru)
```php
// Di Controller
return redirect()->back()->with('info', 'Data telah diperbarui secara otomatis!');
return redirect()->back()->with('info', 'Sistem maintenance setiap hari Minggu 02:00 WIB');
```

### ⚠️ Warning Alert (Kuning)
```php
// Di Controller
return redirect()->back()->with('warning', 'Data akan dihapus permanen!');
return redirect()->back()->with('warning', 'Stok produk hampir habis!');
```

### 🔍 Validation Errors (Merah)
```php
// Otomatis muncul dari validation
$request->validate([
    'nama' => 'required|string|max:50',
    'email' => 'required|email|unique:users',
]);

// Manual withErrors
return redirect()->back()->withErrors([
    'nama' => 'Nama katalog harus diisi!',
    'email' => 'Format email tidak valid!'
]);
```

## 💻 Contoh Implementasi Complete di Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nama' => 'required|string|max:50',
        ], [
            'nama.required' => 'Nama katalog harus diisi.',
            'nama.max' => 'Nama katalog tidak boleh lebih dari 50 karakter.',
        ]);

        try {
            Katalog::create([
                'nama' => $request->nama,
            ]);
            
            // Success Alert
            return redirect()->route('katalog.index')
                ->with('success', 'Katalog berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            // Error Alert
            return redirect()->back()
                ->with('error', 'Gagal menambahkan katalog: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Katalog $katalog)
    {
        try {
            $katalog->delete();
            
            // Success Alert
            return redirect()->route('katalog.index')
                ->with('success', 'Katalog berhasil dihapus!');
                
        } catch (\Exception $e) {
            // Error Alert
            return redirect()->back()
                ->with('error', 'Gagal menghapus katalog: ' . $e->getMessage());
        }
    }
    
    public function updateStatus(Katalog $katalog)
    {
        $katalog->update(['status' => !$katalog->status]);
        
        // Info Alert
        return redirect()->back()
            ->with('info', 'Status katalog berhasil diperbarui!');
    }
    
    public function checkStock()
    {
        $lowStock = Katalog::where('stok', '<', 10)->count();
        
        if ($lowStock > 0) {
            // Warning Alert
            return redirect()->back()
                ->with('warning', "Terdapat {$lowStock} katalog dengan stok rendah!");
        }
        
        return redirect()->back()
            ->with('success', 'Semua stok dalam kondisi baik!');
    }
}
```

## 🎨 Contoh Implementasi di Blade Template

### Form Input (tambah.blade.php)
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Katalog</h4>
        </div>
        <div class="card-body">
            {{-- Include Alert Component --}}
            @include('components.alert')

            <form action="{{ route('katalog.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Katalog</label>
                    <input type="text" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}" 
                           placeholder="Masukkan nama katalog">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="ti ti-device-floppy me-2"></i>
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
```

### List Data (index.blade.php)
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Data Katalog</h4>
            <a href="{{ route('katalog.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-2"></i>
                Tambah Katalog
            </a>
        </div>
        <div class="card-body">
            {{-- Include Alert Component --}}
            @include('components.alert')

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('katalog.edit', $item->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('katalog.destroy', $item->id) }}" 
                                      method="POST" 
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
```

## 🎭 Fitur Alert Component

### ✨ Features
- **Auto-dismiss**: Alert dapat ditutup dengan tombol close
- **Icon Support**: Setiap alert memiliki icon yang sesuai (Tabler Icons)
- **Bootstrap Styling**: Menggunakan Bootstrap 5 alert classes
- **Responsive Design**: Menyesuaikan dengan berbagai ukuran layar
- **Fade Animation**: Smooth show/hide animation

### 🎨 Icons Used
- ✅ Success: `ti ti-check-circle`
- ❌ Error: `ti ti-alert-circle`
- ℹ️ Info: `ti ti-info-circle`
- ⚠️ Warning: `ti ti-alert-triangle`

## 🔧 Kustomisasi Alert

### Menambah Auto-Hide dengan JavaScript
```html
<script>
// Auto hide alert setelah 5 detik
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);

// Atau dengan vanilla JavaScript
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
```

### Custom Styling
```css
/* Custom alert styles */
.alert {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
}
```

### Sound Effects (Opsional)
```javascript
// Tambah sound effect
function playAlertSound(type) {
    const audio = new Audio();
    switch(type) {
        case 'success':
            audio.src = '/sounds/success.mp3';
            break;
        case 'error':
            audio.src = '/sounds/error.mp3';
            break;
    }
    audio.play();
}

// Panggil di komponen alert
@if(session('success'))
    <script>playAlertSound('success');</script>
@endif
```

## 🔄 Best Practices

### 1. Consistency
- Selalu gunakan komponen alert yang sama di seluruh aplikasi
- Gunakan pesan yang jelas dan informatif

### 2. User Experience
- Jangan gunakan terlalu banyak alert dalam satu halaman
- Berikan feedback yang tepat untuk setiap aksi user

### 3. Error Handling
- Selalu tangani exception dengan try-catch
- Berikan pesan error yang user-friendly

### 4. Validation
- Kombinasikan alert dengan validation individual field
- Tampilkan pesan yang spesifik

## 📱 Mobile Responsiveness

Alert component sudah responsive dan akan menyesuaikan dengan layar mobile:

```css
@media (max-width: 768px) {
    .alert {
        margin: 10px;
        font-size: 14px;
    }
}
```

## 🚨 Troubleshooting

### Alert Tidak Muncul
1. Pastikan `@include('components.alert')` sudah ditambahkan
2. Cek Bootstrap CSS sudah ter-load
3. Periksa session flash message sudah di-set dengan benar

### Styling Tidak Sesuai
1. Pastikan Bootstrap 5 sudah ter-load
2. Cek tidak ada CSS custom yang override
3. Pastikan Tabler Icons ter-load untuk icon

### JavaScript Error
1. Pastikan jQuery ter-load (jika menggunakan auto-hide)
2. Cek browser console untuk error details

---

**📝 Catatan:** Komponen ini compatible dengan Laravel 8+ dan Bootstrap 5+

**🔗 Dependencies:**
- Laravel Framework
- Bootstrap 5
- Tabler Icons (untuk icon)

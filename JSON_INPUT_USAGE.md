# 📋 Dokumentasi Input JSON Fields - Laravel

Panduan penggunaan input fields untuk data JSON (ukuran, warna, alamat) di form produk.

## 🎯 Overview

Form produk ini memiliki 3 jenis input JSON:
1. **Ukuran** - JSON Array `["S", "M", "L", "XL"]`
2. **Warna** - JSON Array `["Merah", "Biru", "Hijau"]`  
3. **Alamat** - JSON Object `{"jalan": "...", "kota": "...", ...}`

## 📝 Struktur Data

### 1. Ukuran (JSON Array)
```json
["S", "M", "L", "XL", "XXL"]
```

### 2. Warna (JSON Array)
```json
["Merah", "Biru", "Hijau", "Kuning", "Hitam"]
```

### 3. Alamat (JSON Object)
```json
{
    "jalan": "Jl. Merdeka No. 123",
    "kota": "Jakarta",
    "provinsi": "DKI Jakarta",
    "kode_pos": "12345",
    "negara": "Indonesia"
}
```

## 🎨 Fitur Input

### ✨ Ukuran & Warna Input
- **Dynamic Tags**: Tambah/hapus dengan interface visual
- **Duplicate Prevention**: Mencegah duplikasi data
- **Enter Key Support**: Tekan Enter untuk menambah
- **Visual Preview**: Badge preview untuk setiap item
- **Validation**: Error handling yang baik

### 🏠 Alamat Input
- **Structured Form**: Input terpisah untuk setiap field
- **Bootstrap Grid**: Layout responsive
- **Validation**: Individual field validation
- **Default Values**: Negara default "Indonesia"

## 💻 Implementasi Controller

```php
public function store(Request $request)
{
    $request->validate([
        'katalog_id' => 'required|exists:katalog,id',
        'nama' => 'required|string|max:50',
        'ukuran' => 'nullable|string', // JSON string dari JavaScript
        'warna' => 'nullable|string',  // JSON string dari JavaScript
        'alamat.jalan' => 'required|string|max:255',
        'alamat.kota' => 'required|string|max:100',
        // ... validation lainnya
    ]);

    // Parse JSON untuk ukuran
    $ukuran = null;
    if ($request->ukuran && $request->ukuran !== '') {
        $ukuranData = json_decode($request->ukuran, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($ukuranData)) {
            $ukuran = $ukuranData;
        }
    }

    // Parse JSON untuk warna
    $warna = null;
    if ($request->warna && $request->warna !== '') {
        $warnaData = json_decode($request->warna, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($warnaData)) {
            $warna = $warnaData;
        }
    }

    // Buat JSON object untuk alamat
    $alamat = [
        'jalan' => $request->input('alamat.jalan'),
        'kota' => $request->input('alamat.kota'),
        'provinsi' => $request->input('alamat.provinsi'),
        'kode_pos' => $request->input('alamat.kode_pos'),
        'negara' => $request->input('alamat.negara'),
    ];

    Produk::create([
        'katalog_id' => $request->katalog_id,
        'nama' => $request->nama,
        'slug' => Str::slug($request->nama),
        'ukuran' => $ukuran,
        'warna' => $warna,
        'alamat' => $alamat,
        // ... field lainnya
    ]);
}
```

## 🗄️ Model Configuration

```php
class Produk extends Model
{
    protected $fillable = [
        'katalog_id', 'nama', 'slug', 'deskripsi', 
        'harga', 'stok', 'ukuran', 'warna', 'alamat'
    ];

    protected $casts = [
        'ukuran' => 'array',
        'warna' => 'array',
        'alamat' => 'array'
    ];
}
```

## 🎮 JavaScript Functions

### Core Functions
- `addUkuran()` - Menambah ukuran baru
- `addWarna()` - Menambah warna baru
- `removeUkuran(index)` - Hapus ukuran berdasarkan index
- `removeWarna(index)` - Hapus warna berdasarkan index
- `updateUkuranPreview()` - Update tampilan badge ukuran
- `updateWarnaPreview()` - Update tampilan badge warna

### Event Handlers
- **Enter Key**: Otomatis tambah item saat tekan Enter
- **Click Remove**: Hapus item dengan klik tombol close
- **Form Submit**: Validasi sebelum submit

## 🎨 HTML Structure

### Input Ukuran
```html
<div class="form-group">
    <label for="ukuran" class="form-label">Ukuran</label>
    <div class="input-group">
        <input type="text" id="ukuran_input" placeholder="Masukkan ukuran">
        <button type="button" onclick="addUkuran()">Tambah</button>
    </div>
    <input type="hidden" name="ukuran" id="ukuran">
    <div id="ukuran_preview">
        <div id="ukuran_tags"></div>
    </div>
</div>
```

### Input Alamat
```html
<div class="form-group">
    <label class="form-label">Alamat</label>
    <div class="row">
        <div class="col-md-6">
            <input name="alamat[jalan]" placeholder="Nama jalan">
        </div>
        <div class="col-md-6">
            <input name="alamat[kota]" placeholder="Nama kota">
        </div>
    </div>
    <!-- Row kedua untuk provinsi, kode_pos, negara -->
</div>
```

## 🎯 Contoh Penggunaan

### Menampilkan Data di Blade
```blade
{{-- Tampilkan ukuran --}}
@if($produk->ukuran)
    <div class="ukuran-list">
        @foreach($produk->ukuran as $ukuran)
            <span class="badge bg-primary">{{ $ukuran }}</span>
        @endforeach
    </div>
@endif

{{-- Tampilkan warna --}}
@if($produk->warna)
    <div class="warna-list">
        @foreach($produk->warna as $warna)
            <span class="badge bg-success">{{ $warna }}</span>
        @endforeach
    </div>
@endif

{{-- Tampilkan alamat --}}
@if($produk->alamat)
    <div class="alamat-detail">
        <address>
            {{ $produk->alamat['jalan'] }}<br>
            {{ $produk->alamat['kota'] }}, {{ $produk->alamat['provinsi'] }}<br>
            {{ $produk->alamat['kode_pos'] }}<br>
            {{ $produk->alamat['negara'] }}
        </address>
    </div>
@endif
```

### Query Database
```php
// Cari produk berdasarkan ukuran
$produk = Produk::whereJsonContains('ukuran', 'L')->get();

// Cari produk berdasarkan warna
$produk = Produk::whereJsonContains('warna', 'Merah')->get();

// Cari produk berdasarkan kota
$produk = Produk::where('alamat->kota', 'Jakarta')->get();

// Cari dengan multiple kondisi JSON
$produk = Produk::whereJsonContains('ukuran', 'M')
                ->whereJsonContains('warna', 'Biru')
                ->where('alamat->provinsi', 'DKI Jakarta')
                ->get();
```

## 🔧 Validasi Custom

### Validate JSON Array
```php
// Custom validation untuk ukuran
'ukuran' => [
    'nullable',
    'string',
    function ($attribute, $value, $fail) {
        if ($value) {
            $data = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $fail('Format ukuran tidak valid.');
            }
            if (!is_array($data)) {
                $fail('Ukuran harus berupa array.');
            }
            if (count($data) > 10) {
                $fail('Maksimal 10 ukuran yang dapat ditambahkan.');
            }
        }
    },
],
```

## 🎨 Styling CSS

```css
.badge {
    display: inline-flex;
    align-items: center;
    font-size: 0.8rem;
    margin: 2px;
}

.btn-close {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 0.65em;
}

#ukuran_tags, #warna_tags {
    min-height: 30px;
    padding: 5px 0;
}

.input-group .btn {
    border-left: none;
}
```

## 🚨 Error Handling

### Common Issues
1. **JSON Parse Error**: Validasi JSON sebelum decode
2. **Empty Arrays**: Cek array tidak kosong
3. **Duplicate Values**: Prevent duplikasi di JavaScript
4. **Long Arrays**: Batasi jumlah maksimal item

### Best Practices
1. **Validation**: Selalu validasi input JSON
2. **Error Messages**: Berikan pesan error yang jelas
3. **User Experience**: Provide visual feedback
4. **Performance**: Batasi jumlah maksimal item

---

**📝 Notes:**
- Compatible dengan Laravel 8+
- Requires Bootstrap 5 untuk styling
- Support responsive design
- Auto-save dengan hidden inputs

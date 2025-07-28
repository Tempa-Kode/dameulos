@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Tambah Data Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Produk</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="katalog_id" class="form-label">Nama Katalog</label>
                        <select class="form-control @error('katalog_id') is-invalid @enderror" name="katalog_id" id="katalog_id">
                            <option value="" selected hidden>Pilih Katalog</option>
                            @foreach ($katalog as $k)
                                <option value="{{ $k->id }}" {{ old('katalog_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('katalog_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kategori_produk_id" class="form-label">Nama Kategori</label>
                        <select class="form-control @error('kategori_produk_id') is-invalid @enderror" name="kategori_produk_id" id="kategori_produk_id">
                            <option value="" selected hidden>Pilih Kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_produk_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_produk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input class="form-control @error('nama') is-invalid @enderror"
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama produk">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                            id="deskripsi"
                            name="deskripsi"
                            rows="3"
                            placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenisWarna" class="form-label">Jenis Warna</label>
                        <div id="jenisWarnaContainer">
                            <div class="jenisWarna-item mb-2">
                                <div class="input-group">
                                    <input class="form-control @error('jenisWarna.0') is-invalid @enderror"
                                        type="text"
                                        name="jenisWarna[]"
                                        value="{{ old('jenisWarna.0') }}"
                                        placeholder="Masukkan jenis warna produk">
                                    <button type="button" class="btn btn-danger hapus-jenisWarna" style="display: none;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                                @error('jenisWarna.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="tambahjenisWarna" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah jenis warna
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="harga" class="form-label">Harga</label>
                        <input class="form-control @error('harga') is-invalid @enderror"
                            type="number"
                            id="harga"
                            name="harga"
                            value="{{ old('harga') }}"
                            placeholder="Masukkan harga produk">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stok" class="form-label">Stok</label>
                        <input class="form-control @error('stok') is-invalid @enderror"
                            type="number"
                            id="stok"
                            name="stok"
                            value="{{ old('stok') }}"
                            placeholder="Masukkan jumlah stok produk">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <div id="ukuranContainer">
                            <div class="ukuran-item mb-2">
                                <div class="input-group">
                                    <input class="form-control @error('ukuran.0') is-invalid @enderror"
                                        type="text"
                                        name="ukuran[]"
                                        value="{{ old('ukuran.0') }}"
                                        placeholder="Masukkan ukuran produk (contoh: 108X70, 108X80, dll)">
                                    <button type="button" class="btn btn-danger hapus-ukuran" style="display: none;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                                @error('ukuran.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="tambahUkuran" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah Ukuran
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="warna" class="form-label">Kode Warna</label>
                        <div id="warnaContainer">
                            <div class="warna-item mb-2">
                                <div class="input-group">
                                    <input class="form-control @error('warna.0') is-invalid @enderror"
                                        type="text"
                                        name="warna[]"
                                        value="{{ old('warna.0') }}"
                                        placeholder="Masukkan warna produk (contoh: Merah, Biru, Hijau)">
                                    <button type="button" class="btn btn-danger hapus-warna" style="display: none;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                                @error('warna.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="tambahWarna" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah Warna
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="gambar" class="form-label">Gambar Utama Produk</label>
                        <input class="form-control @error('gambar') is-invalid @enderror"
                               type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_produk" class="form-label">Foto Produk Tambahan</label>
                        <div id="fotoProdukContainer">
                            <div class="foto-item mb-2">
                                <div class="input-group">
                                    <input class="form-control @error('foto_produk.0') is-invalid @enderror"
                                           type="file"
                                           name="foto_produk[]"
                                           accept="image/*">
                                    <button type="button" class="btn btn-danger hapus-foto" style="display: none;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                                @error('foto_produk.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="tambahFoto" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah Foto
                        </button>
                        <small class="form-text text-muted">
                            <i class="ti ti-info-circle me-1"></i>
                            Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 10MB per file.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success float-end">
                        <span class="pc-micon"><i class="ti ti-device-floppy me-2"></i></span>
                        Simpan
                    </button>
              </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let jenisWarnaIndex = 1;
            let ukuranIndex = 1;
            let warnaIndex = 1;
            let fotoIndex = 1;
            const tambahJenisWarnaBtn = document.getElementById('tambahjenisWarna');
            const tambahUkuranBtn = document.getElementById('tambahUkuran');
            const tambahWarnaBtn = document.getElementById('tambahWarna');
            const tambahFotoBtn = document.getElementById('tambahFoto');
            const jenisWarnaContainer = document.getElementById('jenisWarnaContainer');
            const ukuranContainer = document.getElementById('ukuranContainer');
            const warnaContainer = document.getElementById('warnaContainer');
            const fotoProdukContainer = document.getElementById('fotoProdukContainer');

            // Function untuk menambah jenis warna
            tambahJenisWarnaBtn.addEventListener('click', function() {
                const newJeniswarnaItem = document.createElement('div');
                newJeniswarnaItem.className = 'jenisWarna-item mb-2';
                newJeniswarnaItem.innerHTML = `
                    <div class="input-group">
                        <input class="form-control"
                            type="text"
                            name="jenisWarna[]"
                            placeholder="Masukkan jenis warna produk">
                        <button type="button" class="btn btn-danger hapus-jenisWarna">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;

                jenisWarnaContainer.appendChild(newJeniswarnaItem);
                jenisWarnaIndex++;

                // Show hapus button untuk semua item jika ada lebih dari 1
                updateHapusJenisWarnaButtons();
            });

            // Function untuk menambah ukuran
            tambahUkuranBtn.addEventListener('click', function() {
                const newUkuranItem = document.createElement('div');
                newUkuranItem.className = 'ukuran-item mb-2';
                newUkuranItem.innerHTML = `
                    <div class="input-group">
                        <input class="form-control"
                            type="text"
                            name="ukuran[]"
                            placeholder="Masukkan ukuran produk (contoh: 108X70, 108X80, dll)">
                        <button type="button" class="btn btn-danger hapus-ukuran">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;

                ukuranContainer.appendChild(newUkuranItem);
                ukuranIndex++;

                // Show hapus button untuk semua item jika ada lebih dari 1
                updateHapusUkuranButtons();
            });

            // Function untuk menambah warna
            tambahWarnaBtn.addEventListener('click', function() {
                const newWarnaItem = document.createElement('div');
                newWarnaItem.className = 'warna-item mb-2';
                newWarnaItem.innerHTML = `
                    <div class="input-group">
                        <input class="form-control"
                            type="text"
                            name="warna[]"
                            placeholder="Masukkan warna produk (contoh: Merah, Biru, Hijau)">
                        <button type="button" class="btn btn-danger hapus-warna">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;

                warnaContainer.appendChild(newWarnaItem);
                warnaIndex++;

                // Show hapus button untuk semua item jika ada lebih dari 1
                updateHapusWarnaButtons();
            });

            // Function untuk menambah foto
            tambahFotoBtn.addEventListener('click', function() {
                const newFotoItem = document.createElement('div');
                newFotoItem.className = 'foto-item mb-2';
                newFotoItem.innerHTML = `
                    <div class="input-group">
                        <input class="form-control"
                            type="file"
                            name="foto_produk[]"
                            accept="image/*">
                        <button type="button" class="btn btn-danger hapus-foto">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;

                fotoProdukContainer.appendChild(newFotoItem);
                fotoIndex++;

                // Show hapus button untuk semua item jika ada lebih dari 1
                updateHapusFotoButtons();
            });

            // Function untuk menghapus jenis warna
            jenisWarnaContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapus-jenisWarna') || e.target.closest('.hapus-jenisWarna')) {
                    const jenisWarnaItem = e.target.closest('.jenisWarna-item');
                    jenisWarnaItem.remove();
                    updateHapusJenisWarnaButtons();
                }
            });

            // Function untuk menghapus ukuran
            ukuranContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapus-ukuran') || e.target.closest('.hapus-ukuran')) {
                    const ukuranItem = e.target.closest('.ukuran-item');
                    ukuranItem.remove();
                    updateHapusUkuranButtons();
                }
            });

            // Function untuk menghapus warna
            warnaContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapus-warna') || e.target.closest('.hapus-warna')) {
                    const warnaItem = e.target.closest('.warna-item');
                    warnaItem.remove();
                    updateHapusWarnaButtons();
                }
            });

            // Function untuk menghapus foto
            fotoProdukContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapus-foto') || e.target.closest('.hapus-foto')) {
                    const fotoItem = e.target.closest('.foto-item');
                    fotoItem.remove();
                    updateHapusFotoButtons();
                }
            });

            // Function untuk update visibility tombol hapus jenis warna
            function updateHapusJenisWarnaButtons() {
                const jenisWarnaItems = jenisWarnaContainer.querySelectorAll('.jenisWarna-item');
                jenisWarnaItems.forEach(function(item, index) {
                    const hapusBtn = item.querySelector('.hapus-jenisWarna');
                    if (jenisWarnaItems.length > 1) {
                        hapusBtn.style.display = 'block';
                    } else {
                        hapusBtn.style.display = 'none';
                    }
                });
            }

            // Function untuk update visibility tombol hapus ukuran
            function updateHapusUkuranButtons() {
                const ukuranItems = ukuranContainer.querySelectorAll('.ukuran-item');
                ukuranItems.forEach(function(item, index) {
                    const hapusBtn = item.querySelector('.hapus-ukuran');
                    if (ukuranItems.length > 1) {
                        hapusBtn.style.display = 'block';
                    } else {
                        hapusBtn.style.display = 'none';
                    }
                });
            }

            // Function untuk update visibility tombol hapus warna
            function updateHapusWarnaButtons() {
                const warnaItems = warnaContainer.querySelectorAll('.warna-item');
                warnaItems.forEach(function(item, index) {
                    const hapusBtn = item.querySelector('.hapus-warna');
                    if (warnaItems.length > 1) {
                        hapusBtn.style.display = 'block';
                    } else {
                        hapusBtn.style.display = 'none';
                    }
                });
            }

            // Function untuk update visibility tombol hapus foto
            function updateHapusFotoButtons() {
                const fotoItems = fotoProdukContainer.querySelectorAll('.foto-item');
                fotoItems.forEach(function(item, index) {
                    const hapusBtn = item.querySelector('.hapus-foto');
                    if (fotoItems.length > 1) {
                        hapusBtn.style.display = 'block';
                    } else {
                        hapusBtn.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection


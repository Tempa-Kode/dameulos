@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Edit Data Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Produk: {{ $produk->nama }}</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="katalog_id" class="form-label">Nama Katalog</label>
                        <select class="form-control @error('katalog_id') is-invalid @enderror" name="katalog_id" id="katalog_id">
                            <option value="" selected hidden>Pilih Katalog</option>
                            @foreach ($katalog as $k)
                                <option value="{{ $k->id }}" {{ (old('katalog_id') ?? $produk->katalog_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('katalog_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input class="form-control @error('nama') is-invalid @enderror"
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') ?? $produk->nama }}"
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
                            placeholder="Masukkan deskripsi produk">{{ old('deskripsi') ?? $produk->deskripsi }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenisWarna" class="form-label">Jenis Warna</label>
                        <div id="jenisWarnaContainer">
                            @php
                                $jenisWarnaCollection = $produk->jenisWarnaProduk ?? collect();
                                $oldJenisWarna = old('jenisWarna', $jenisWarnaCollection->pluck('warna')->toArray());
                            @endphp
                            @if(count($oldJenisWarna) > 0)
                                @foreach($oldJenisWarna as $index => $jenisWarna)
                                    <div class="jenisWarna-item mb-2">
                                        <div class="input-group">
                                            <input class="form-control @error('jenisWarna.'.$index) is-invalid @enderror"
                                                type="text"
                                                name="jenisWarna[]"
                                                value="{{ $jenisWarna }}"
                                                placeholder="Masukkan jenis warna produk (contoh: 108X70, 108X80, dll)">
                                            <button type="button" class="btn btn-danger hapus-jenisWarna" {{ count($oldJenisWarna) <= 1 ? 'style=display:none;' : '' }}>
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                        @error('jenisWarna.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @else
                                <div class="jenisWarna-item mb-2">
                                    <div class="input-group">
                                        <input class="form-control @error('jenisWarna.0') is-invalid @enderror"
                                            type="text"
                                            name="jenisWarna[]"
                                            value=""
                                            placeholder="Masukkan jenis warna produk (contoh: 108X70, 108X80, dll)">
                                        <button type="button" class="btn btn-danger hapus-jenisWarna" style="display: none;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                    @error('jenisWarna.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
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
                            value="{{ old('harga') ?? $produk->harga }}"
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
                            value="{{ old('stok') ?? $produk->stok }}"
                            placeholder="Masukkan jumlah stok produk">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <div id="ukuranContainer">
                            @php
                                $ukuranCollection = $produk->ukuran ?? collect();
                                $oldUkuran = old('ukuran', $ukuranCollection->pluck('ukuran')->toArray());
                            @endphp
                            @if(count($oldUkuran) > 0)
                                @foreach($oldUkuran as $index => $ukuran)
                                    <div class="ukuran-item mb-2">
                                        <div class="input-group">
                                            <input class="form-control @error('ukuran.'.$index) is-invalid @enderror"
                                                type="text"
                                                name="ukuran[]"
                                                value="{{ $ukuran }}"
                                                placeholder="Masukkan ukuran produk (contoh: 108X70, 108X80, dll)">
                                            <button type="button" class="btn btn-danger hapus-ukuran" {{ count($oldUkuran) <= 1 ? 'style=display:none;' : '' }}>
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                        @error('ukuran.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @else
                                <div class="ukuran-item mb-2">
                                    <div class="input-group">
                                        <input class="form-control @error('ukuran.0') is-invalid @enderror"
                                            type="text"
                                            name="ukuran[]"
                                            value=""
                                            placeholder="Masukkan ukuran produk (contoh: 108X70, 108X80, dll)">
                                        <button type="button" class="btn btn-danger hapus-ukuran" style="display: none;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                    @error('ukuran.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <button type="button" id="tambahUkuran" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah Ukuran
                        </button>
                    </div>

                    <div class="form-group">
                        <label for="warna" class="form-label">Warna</label>
                        <div id="warnaContainer">
                            @php
                                $warnaCollection = $produk->warnaProduk ?? collect();
                                $oldWarna = old('warna', $warnaCollection->pluck('kode_warna')->toArray());
                            @endphp
                            @if(count($oldWarna) > 0)
                                @foreach($oldWarna as $index => $warna)
                                    <div class="warna-item mb-2">
                                        <div class="input-group">
                                            <input class="form-control @error('warna.'.$index) is-invalid @enderror"
                                                type="text"
                                                name="warna[]"
                                                value="{{ $warna }}"
                                                placeholder="Masukkan kode warna (contoh: ff0000, 00ff00, 0000ff)">
                                            <button type="button" class="btn btn-danger hapus-warna" {{ count($oldWarna) <= 1 ? 'style=display:none;' : '' }}>
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                        @error('warna.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @else
                                <div class="warna-item mb-2">
                                    <div class="input-group">
                                        <input class="form-control @error('warna.0') is-invalid @enderror"
                                            type="text"
                                            name="warna[]"
                                            value=""
                                            placeholder="Masukkan kode warna (contoh: ff0000, 00ff00, 0000ff)">
                                        <button type="button" class="btn btn-danger hapus-warna" style="display: none;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                    @error('warna.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <button type="button" id="tambahWarna" class="btn btn-secondary mt-2">
                            <i class="ti ti-plus me-1"></i>Tambah Warna
                        </button>
                    </div>

                    <div class="form-group">
                        <label for="gambar" class="form-label">Gambar Produk</label>

                        @if($produk->gambar)
                            <div class="current-image mb-3">
                                <p class="mb-2"><strong>Gambar Saat Ini:</strong></p>
                                <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}"
                                     class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                <p class="text-muted mt-2"><small>Upload gambar baru untuk mengganti gambar saat ini</small></p>
                            </div>
                        @endif

                        <input class="form-control @error('gambar') is-invalid @enderror"
                               type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <span class="pc-micon"><i class="ti ti-device-floppy me-2"></i></span>
                            Update Produk
                        </button>
                        <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        // Ensure variables are available for JavaScript
        $jenisWarnaCount = count($oldJenisWarna ?? []);
        $ukuranCount = count($oldUkuran ?? []);
        $warnaCount = count($oldWarna ?? []);
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let jenisWarnaIndex = {{ $jenisWarnaCount }};
            let ukuranIndex = {{ $ukuranCount }};
            let warnaIndex = {{ $warnaCount }};
            const tambahJenisWarnaBtn = document.getElementById('tambahjenisWarna');
            const tambahUkuranBtn = document.getElementById('tambahUkuran');
            const tambahWarnaBtn = document.getElementById('tambahWarna');
            const jenisWarnaContainer = document.getElementById('jenisWarnaContainer');
            const ukuranContainer = document.getElementById('ukuranContainer');
            const warnaContainer = document.getElementById('warnaContainer');

            // Periksa apakah semua element ditemukan
            if (!tambahJenisWarnaBtn || !tambahUkuranBtn || !tambahWarnaBtn ||
                !jenisWarnaContainer || !ukuranContainer || !warnaContainer) {
                return;
            }

            // Function untuk menambah jenis warna
            tambahJenisWarnaBtn.addEventListener('click', function() {
                const newJeniswarnaItem = document.createElement('div');
                newJeniswarnaItem.className = 'jenisWarna-item mb-2';
                newJeniswarnaItem.innerHTML = `
                    <div class="input-group">
                        <input class="form-control"
                            type="text"
                            name="jenisWarna[]"
                            placeholder="Masukkan jenis warna produk (contoh: 108X70, 108X80, dll)">
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
                            placeholder="Masukkan ukuran produk (contoh: S, M, L, XL)">
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
                            placeholder="Masukkan kode warna (contoh: ff0000, 00ff00, 0000ff)">
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

            // Initialize buttons visibility
            updateHapusJenisWarnaButtons();
            updateHapusUkuranButtons();
            updateHapusWarnaButtons();
        });
    </script>
@endsection

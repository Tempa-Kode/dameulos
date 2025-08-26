@extends("layouts.guest")

@section("title", "Buat Keluhan Baru - Dame Ulos")

@section("content")

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Buat Keluhan Baru</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <a href="{{ route("pelanggan.keluhan.index") }}">Keluhan Saya</a>
                            <span>Buat Baru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Keluhan Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("pelanggan.keluhan.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if ($transaksi)
                                <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
                                <div class="alert alert-info">
                                    <strong>Keluhan terkait transaksi:</strong> {{ $transaksi->kode_transaksi }}
                                </div>
                            @endif

                            <div class="form-group d-flex flex-column">
                                <label for="kategori">Kategori Keluhan <span class="text-danger">*</span></label>
                                <select class="form-control @error("kategori") is-invalid @enderror" name="kategori"
                                    id="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="produk" {{ old("kategori") == "produk" ? "selected" : "" }}>Produk
                                    </option>
                                    <option value="pengiriman" {{ old("kategori") == "pengiriman" ? "selected" : "" }}>
                                        Pengiriman</option>
                                    <option value="pembayaran" {{ old("kategori") == "pembayaran" ? "selected" : "" }}>
                                        Pembayaran</option>
                                    <option value="layanan" {{ old("kategori") == "layanan" ? "selected" : "" }}>Layanan
                                        Pelanggan</option>
                                    <option value="lainnya" {{ old("kategori") == "lainnya" ? "selected" : "" }}>Lainnya
                                    </option>
                                </select>
                                @error("kategori")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (!$transaksi)
                                <div class="form-group">
                                    <label for="transaksi_id">Terkait Transaksi (Opsional)</label>
                                    <input type="text" class="form-control @error("transaksi_id") is-invalid @enderror"
                                        id="transaksi_search" placeholder="Masukkan kode transaksi...">
                                    <input type="hidden" name="transaksi_id" id="transaksi_id"
                                        value="{{ old("transaksi_id") }}">
                                    <small class="form-text text-muted">Kosongkan jika keluhan tidak terkait transaksi
                                        tertentu</small>
                                    @error("transaksi_id")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="subjek">Subjek Keluhan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error("subjek") is-invalid @enderror"
                                    name="subjek" id="subjek" value="{{ old("subjek") }}"
                                    placeholder="Ringkasan singkat keluhan Anda" required>
                                @error("subjek")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pesan">Detail Keluhan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error("pesan") is-invalid @enderror" name="pesan" id="pesan" rows="6"
                                    required placeholder="Jelaskan detail keluhan Anda...">{{ old("pesan") }}</textarea>
                                @error("pesan")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="lampiran">Lampiran (Opsional)</label>
                                <input type="file" class="form-control-file @error("lampiran.*") is-invalid @enderror"
                                    name="lampiran[]" id="lampiran" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <small class="form-text text-muted">
                                    Maksimal 3 file. Format: JPG, PNG, PDF, DOC, DOCX. Ukuran maksimal: 2MB per file.
                                </small>
                                @error("lampiran.*")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route("pelanggan.keluhan.index") }}"
                                            class="btn btn-secondary btn-block">
                                            <i class="fa fa-arrow-left mr-1"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-paper-plane mr-1"></i> Kirim Keluhan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Terdapat Kesalahan!',
                    html: '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection

@push("styles")
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
@endpush

@push("scripts")
    <script>
        // File upload preview
        document.getElementById('lampiran').addEventListener('change', function(e) {
            const files = e.target.files;
            const maxFiles = 3;

            if (files.length > maxFiles) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: `Maksimal ${maxFiles} file yang dapat diupload.`,
                    confirmButtonText: 'OK'
                });
                e.target.value = '';
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Terlalu Besar',
                        text: `File ${file.name} lebih dari 2MB. Silakan pilih file yang lebih kecil.`,
                        confirmButtonText: 'OK'
                    });
                    e.target.value = '';
                    return;
                }
            }
        });
    </script>
@endpush

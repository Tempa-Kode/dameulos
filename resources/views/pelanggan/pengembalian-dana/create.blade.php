@extends("layouts.guest")

@section("title", "Pembatalan & Pengembalian Dana")

@section("content")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Pembatalan & Pengembalian Dana</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <span>Pembatalan & Pengembalian Dana</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="blog_area section_padding mt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">
                        <div class="single_blog_item blog_item_02">
                            <div class="single_blog_text">

                                <!-- Informasi Transaksi -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-white">
                                            <i class="fa fa-file-text mr-2"></i>Informasi Transaksi
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item mb-3">
                                                    <strong><i class="fa fa-barcode me-2 text-primary mr-2"></i>Kode
                                                        Transaksi:</strong>
                                                    <span
                                                        class="badge bg-primary ms-2 text-white">{{ $transaksi->kode_transaksi }}</span>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <strong><i
                                                            class="fa fa-info-circle me-2 text-info mr-2"></i>Status:</strong>
                                                    @if ($transaksi->status == "pending")
                                                        <span class="badge bg-warning ms-2">⏳ Pending</span>
                                                    @elseif($transaksi->status == "dibayar")
                                                        <span class="badge bg-success ms-2">✅ Dibayar</span>
                                                    @endif
                                                </div>
                                                <div class="info-item mb-3">
                                                    <strong><i class="fa fa-money-bill me-2 text-success mr-2"></i>Total
                                                        Pembayaran:</strong>
                                                    <span class="fw-bold text-success ms-2">Rp
                                                        {{ number_format($transaksi->total, 0, ",", ".") }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item mb-3">
                                                    <strong><i class="fa fa-calendar me-2 text-warning mr-2"></i>Tanggal
                                                        Transaksi:</strong>
                                                    <span
                                                        class="ms-2">{{ $transaksi->created_at->format("d-m-Y H:i") }}</span>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <strong><i class="fa fa-map-marker-alt me-2 text-danger mr-2"></i>Alamat
                                                        Pengiriman:</strong>
                                                    <small
                                                        class="text-muted d-block ms-4">{{ $transaksi->alamat_pengiriman }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Produk yang Dibeli -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-white">
                                            <i class="fa fa-shopping-bag mr-2"></i>Produk yang Dibeli
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($transaksi->detailTransaksi as $index => $detail)
                                            <div class="row mb-3 pb-3 {{ !$loop->last ? "border-bottom" : "" }}">
                                                <div class="col-md-1 text-center">
                                                    <div class="product-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <h6 class="mb-2 text-primary">{{ $detail->produk->nama }}</h6>
                                                    <div class="product-details">
                                                        <span class="badge bg-light text-dark me-2">
                                                            <i
                                                                class="fa fa-expand-arrows-alt me-1"></i>{{ $detail->ukuranProduk->ukuran ?? "-" }}
                                                        </span>
                                                        <span class="badge bg-light text-dark me-2">
                                                            <i
                                                                class="fa fa-palette me-1"></i>{{ $detail->jenisWarnaProduk->warna ?? "-" }}
                                                        </span>
                                                        <span class="badge bg-light text-dark">
                                                            <i class="fa fa-cube me-1"></i>Qty: {{ $detail->jumlah }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div class="price-info">
                                                        <small class="text-muted d-block">Harga Satuan: Rp
                                                            {{ number_format($detail->harga_satuan, 0, ",", ".") }}</small>
                                                        <strong class="text-success">Subtotal: Rp
                                                            {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ",", ".") }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="row mt-3 pt-3 border-top bg-light rounded p-3">
                                            <div class="col-md-8">
                                                <h6 class="mb-0">Total Keseluruhan:</h6>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h5 class="mb-0 text-success fw-bold">Rp
                                                    {{ number_format($transaksi->total, 0, ",", ".") }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Pembatalan -->
                                <form action="{{ route("pengembalian-dana.store") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-white">
                                                <i class="fa fa-times-circle mr-2"></i>Form Pembatalan & Pengembalian Dana
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Alasan Pembatalan -->
                                            <div class="mb-4">
                                                <label for="alasan_pembatalan" class="form-label fw-bold">
                                                    <i class="fa fa-edit mr-2"></i>Alasan Pembatalan
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control @error("alasan_pembatalan") is-invalid @enderror" id="alasan_pembatalan"
                                                    name="alasan_pembatalan" rows="5"
                                                    placeholder="Jelaskan alasan Anda membatalkan transaksi ini dengan detail. Contoh: Salah ukuran, berubah pikiran, dll."
                                                    required>{{ old("alasan_pembatalan") }}</textarea>
                                                @error("alasan_pembatalan")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    <i class="fa fa-info-circle me-1"></i>
                                                    Minimal 10 karakter, maksimal 1000 karakter
                                                </small>
                                            </div>

                                            <!-- Detail Rekening (untuk transfer bank dan ewallet) -->
                                            <div id="detail_rekening" class="border border-light rounded p-3 bg-light mb-4">
                                                <h6 class="text-primary mb-3">
                                                    <i class="fa fa-user-circle mr-2"></i>Informasi Rekening/Akun
                                                </h6>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nama_pemilik_rekening" class="form-label fw-bold">
                                                                Nama Pemilik Rekening/Akun <span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fa fa-user"></i></span>
                                                                <input type="text"
                                                                    class="form-control @error("nama_pemilik_rekening") is-invalid @enderror"
                                                                    id="nama_pemilik_rekening"
                                                                    name="nama_pemilik_rekening"
                                                                    value="{{ old("nama_pemilik_rekening") }}"
                                                                    placeholder="Nama sesuai rekening/akun">
                                                            </div>
                                                            @error("nama_pemilik_rekening")
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nomor_rekening" class="form-label fw-bold">
                                                                Nomor Rekening/Akun <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fa fa-credit-card"></i></span>
                                                                <input type="text"
                                                                    class="form-control @error("nomor_rekening") is-invalid @enderror"
                                                                    id="nomor_rekening" name="nomor_rekening"
                                                                    value="{{ old("nomor_rekening") }}"
                                                                    placeholder="Nomor rekening/akun">
                                                            </div>
                                                            @error("nomor_rekening")
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 d-flex flex-column" id="bank_field">
                                                    <label for="bank" class="form-label fw-bold">
                                                        <i class="fa fa-university me-2"></i>Nama Bank <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select @error("bank") is-invalid @enderror"
                                                        id="bank" name="bank">
                                                        <option value="">-- Pilih Bank --</option>
                                                        <option value="BCA"
                                                            {{ old("bank") == "BCA" ? "selected" : "" }}>
                                                            🏦 Bank Central Asia (BCA)
                                                        </option>
                                                        <option value="BNI"
                                                            {{ old("bank") == "BNI" ? "selected" : "" }}>
                                                            🏦 Bank Negara Indonesia (BNI)
                                                        </option>
                                                        <option value="BRI"
                                                            {{ old("bank") == "BRI" ? "selected" : "" }}>
                                                            🏦 Bank Rakyat Indonesia (BRI)
                                                        </option>
                                                        <option value="Mandiri"
                                                            {{ old("bank") == "Mandiri" ? "selected" : "" }}>
                                                            🏦 Bank Mandiri
                                                        </option>
                                                        <option value="CIMB Niaga"
                                                            {{ old("bank") == "CIMB Niaga" ? "selected" : "" }}>
                                                            🏦 CIMB Niaga
                                                        </option>
                                                        <option value="Danamon"
                                                            {{ old("bank") == "Danamon" ? "selected" : "" }}>
                                                            🏦 Bank Danamon
                                                        </option>
                                                        <option value="BSI"
                                                            {{ old("bank") == "BSI" ? "selected" : "" }}>
                                                            🏦 Bank Syariah Indonesia (BSI)
                                                        </option>
                                                        <option value="Lainnya"
                                                            {{ old("bank") == "Lainnya" ? "selected" : "" }}>
                                                            🏦 Bank Lainnya
                                                        </option>
                                                    </select>
                                                    @error("bank")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="alert alert-info mb-0">
                                                    <i class="fa fa-shield-alt me-2"></i>
                                                    <strong>Keamanan Data:</strong> Informasi rekening Anda akan dijaga
                                                    kerahasiaannya dan hanya digunakan untuk proses pengembalian dana.
                                                </div>
                                            </div>

                                            <!-- Informasi Penting -->
                                            <div class="alert alert-warning border-warning shadow-sm">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa fa-exclamation-triangle fa-2x text-warning me-3"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="alert-heading mb-3">
                                                            <i class="fa fa-info-circle me-2"></i>Informasi Penting Sebelum
                                                            Membatalkan:
                                                        </h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <ul class="mb-2">
                                                                    <li class="mb-2">
                                                                        <i class="fa fa-ban text-danger me-2"></i>
                                                                        Pembatalan akan mengubah status transaksi menjadi
                                                                        <strong>"Dibatalkan"</strong>
                                                                    </li>
                                                                    <li class="mb-2">
                                                                        <i class="fa fa-clock text-info me-2"></i>
                                                                        Proses pengembalian dana membutuhkan <strong>1-3
                                                                            hari kerja</strong> setelah persetujuan admin
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <ul class="mb-2">
                                                                    <li class="mb-2">
                                                                        <i
                                                                            class="fa fa-check-circle text-success me-2"></i>
                                                                        Pastikan data rekening/akun yang dimasukkan
                                                                        <strong>benar dan aktif</strong>
                                                                    </li>
                                                                    <li class="mb-2">
                                                                        <i class="fa fa-envelope text-primary me-2"></i>
                                                                        Anda akan mendapat <strong>notifikasi email</strong>
                                                                        mengenai status pengembalian dana
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <hr class="my-3">
                                                        <div class="text-center">
                                                            <small class="text-muted">
                                                                <i class="fa fa-shield-alt me-1"></i>
                                                                Data Anda aman dan akan diproses sesuai kebijakan privasi
                                                                kami
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Aksi -->
                                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                                <a href="{{ route("pelanggan.transaksi") }}"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fa fa-arrow-left mr-2"></i>Kembali ke Transaksi
                                                </a>
                                                <button type="submit" class="btn btn-danger px-3"
                                                    onclick="return confirm('⚠️ KONFIRMASI PEMBATALAN\n\nApakah Anda yakin ingin membatalkan transaksi ini?\n\n✓ Transaksi akan dibatalkan secara permanen\n✓ Pengembalian dana akan diproses oleh admin\n✓ Proses tidak dapat dibatalkan setelah dikonfirmasi\n\nKlik OK untuk melanjutkan atau Cancel untuk membatalkan.')">
                                                    <i class="fa fa-times mr-2"></i>Batalkan & Ajukan Pengembalian
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
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodeSelect = document.getElementById('metode_pengembalian');
            const detailRekening = document.getElementById('detail_rekening');
            const bankField = document.getElementById('bank_field');
            const namaField = document.getElementById('nama_pemilik_rekening');
            const nomorField = document.getElementById('nomor_rekening');
            const bankSelect = document.getElementById('bank');

            metodeSelect.addEventListener('change', function() {
                if (this.value === 'transfer_bank' || this.value === 'ewallet') {
                    detailRekening.style.display = 'block';
                    namaField.required = true;
                    nomorField.required = true;

                    if (this.value === 'transfer_bank') {
                        bankField.style.display = 'block';
                        bankSelect.required = true;
                        document.querySelector('label[for="nomor_rekening"]').innerHTML =
                            'Nomor Rekening <span class="text-danger">*</span>';
                        document.querySelector('label[for="nama_pemilik_rekening"]').innerHTML =
                            'Nama Pemilik Rekening <span class="text-danger">*</span>';
                        document.querySelector('label[for="bank"]').innerHTML =
                            '<i class="fa fa-university me-2"></i>Nama Bank <span class="text-danger">*</span>';
                    } else {
                        bankField.style.display = 'none';
                        bankSelect.required = false;
                        document.querySelector('label[for="nomor_rekening"]').innerHTML =
                            'Nomor Akun E-Wallet <span class="text-danger">*</span>';
                        document.querySelector('label[for="nama_pemilik_rekening"]').innerHTML =
                            'Nama Pemilik Akun <span class="text-danger">*</span>';
                    }
                } else {
                    detailRekening.style.display = 'none';
                    namaField.required = false;
                    nomorField.required = false;
                    bankSelect.required = false;
                }
            });

            // Trigger change event jika ada nilai yang sudah dipilih (untuk old input)
            if (metodeSelect.value) {
                metodeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

    <style>
        /* Custom styling untuk form pembatalan */
        .form-label.fw-bold {
            color: #495057;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1.5px solid #e3e6f0;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
            background-color: #f8f9fc;
            border: 1.5px solid #e3e6f0;
            color: #5a5c69;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            border: none;
        }

        .alert-warning {
            border-radius: 10px;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-color: #ffc107;
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-outline-secondary {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }

        #detail_rekening {
            animation: slideDown 0.3s ease-in-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bg-light {
            background: linear-gradient(135deg, #f8f9fc 0%, #f1f3f9 100%) !important;
        }

        .border-top {
            border-color: #e3e6f0 !important;
        }

        .text-primary {
            color: #4e73df !important;
        }

        /* Badge styling */
        .badge {
            font-size: 0.85rem;
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
        }

        /* Alert info styling */
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-color: #17a2b8;
            border-radius: 8px;
        }

        /* Info item styling */
        .info-item {
            padding: 0.5rem 0;
        }

        .info-item strong {
            display: inline-block;
            min-width: 140px;
        }

        /* Product details styling */
        .product-details .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }

        .product-number {
            font-weight: bold;
            font-size: 0.85rem;
        }

        .price-info small {
            font-size: 0.8rem;
        }

        /* Hover effects */
        .card:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
            box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #6c757d;
        }
    </style>
@endsection

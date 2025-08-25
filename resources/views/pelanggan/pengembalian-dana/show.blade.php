@extends("layouts.guest")

@section("title", "Detail Pengembalian Dana")

@section("content")
    <section class="blog_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">
                        <div class="single_blog_item blog_item_02">
                            <div class="single_blog_text">
                                <h3 class="text-center mb-4">Detail Pengembalian Dana</h3>

                                <!-- Informasi Pengembalian Dana -->
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>{{ $pengembalianDana->kode_pengembalian }}</h5>
                                        <div>
                                            @if ($pengembalianDana->status == "pending")
                                                <span class="badge bg-warning">{{ $pengembalianDana->status_text }}</span>
                                            @elseif($pengembalianDana->status == "diproses")
                                                <span class="badge bg-info">{{ $pengembalianDana->status_text }}</span>
                                            @elseif($pengembalianDana->status == "selesai")
                                                <span class="badge bg-success">{{ $pengembalianDana->status_text }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $pengembalianDana->status_text }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Kode Transaksi:</strong>
                                                    {{ $pengembalianDana->transaksi->kode_transaksi }}</p>
                                                <p><strong>Jumlah Pengembalian:</strong> Rp
                                                    {{ number_format($pengembalianDana->jumlah_pengembalian, 0, ",", ".") }}
                                                </p>
                                                <p><strong>Metode Pengembalian:</strong>
                                                    {{ $pengembalianDana->metode_pengembalian_text }}</p>
                                                @if ($pengembalianDana->metode_pengembalian != "cash")
                                                    <p><strong>Rekening/Akun:</strong>
                                                        {{ $pengembalianDana->nama_pemilik_rekening }}</p>
                                                    <p><strong>Nomor:</strong> {{ $pengembalianDana->nomor_rekening }}</p>
                                                    @if ($pengembalianDana->bank)
                                                        <p><strong>Bank:</strong> {{ $pengembalianDana->bank }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Tanggal Pengajuan:</strong>
                                                    {{ $pengembalianDana->tanggal_pengajuan->format("d-m-Y H:i") }}</p>
                                                @if ($pengembalianDana->tanggal_diproses)
                                                    <p><strong>Tanggal Diproses:</strong>
                                                        {{ $pengembalianDana->tanggal_diproses->format("d-m-Y H:i") }}</p>
                                                @endif
                                                @if ($pengembalianDana->tanggal_selesai)
                                                    <p><strong>Tanggal Selesai:</strong>
                                                        {{ $pengembalianDana->tanggal_selesai->format("d-m-Y H:i") }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alasan Pembatalan -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Alasan Pembatalan</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $pengembalianDana->alasan_pembatalan }}</p>
                                    </div>
                                </div>

                                <!-- Catatan Admin -->
                                @if ($pengembalianDana->catatan_admin)
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Catatan Admin</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info">
                                                {{ $pengembalianDana->catatan_admin }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Bukti Transfer -->
                                @if ($pengembalianDana->bukti_transfer)
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>Bukti Transfer</h5>
                                        </div>
                                        <div class="card-body">
                                            <a href="{{ Storage::url($pengembalianDana->bukti_transfer) }}" target="_blank"
                                                class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Lihat Bukti Transfer
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <!-- Informasi Transaksi -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Detail Transaksi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text-primary">Produk yang Dibeli:</h6>
                                                @foreach ($pengembalianDana->transaksi->detailTransaksi as $detail)
                                                    <div class="row mb-2 pb-2 border-bottom">
                                                        <div class="col-md-8">
                                                            <strong>{{ $detail->produk->nama }}</strong><br>
                                                            <small>
                                                                Ukuran: {{ $detail->ukuranProduk->ukuran ?? "-" }} |
                                                                Warna: {{ $detail->jenisWarnaProduk->warna ?? "-" }} |
                                                                Qty: {{ $detail->jumlah }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-4 text-end">
                                                            Rp
                                                            {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ",", ".") }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="row mt-3 pt-2 border-top">
                                                    <div class="col-md-8">
                                                        <strong>Total Transaksi:</strong>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <strong>Rp
                                                            {{ number_format($pengembalianDana->transaksi->total, 0, ",", ".") }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeline Status -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Timeline Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            <div
                                                class="timeline-item {{ $pengembalianDana->status != "pending" ? "completed" : "active" }}">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6>Pengajuan Dibuat</h6>
                                                    <p>{{ $pengembalianDana->tanggal_pengajuan->format("d-m-Y H:i") }}</p>
                                                </div>
                                            </div>

                                            @if ($pengembalianDana->tanggal_diproses)
                                                <div
                                                    class="timeline-item {{ $pengembalianDana->status == "selesai" ? "completed" : "active" }}">
                                                    <div class="timeline-marker"></div>
                                                    <div class="timeline-content">
                                                        <h6>Sedang Diproses</h6>
                                                        <p>{{ $pengembalianDana->tanggal_diproses->format("d-m-Y H:i") }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($pengembalianDana->tanggal_selesai)
                                                <div class="timeline-item completed">
                                                    <div class="timeline-marker"></div>
                                                    <div class="timeline-content">
                                                        <h6>Selesai</h6>
                                                        <p>{{ $pengembalianDana->tanggal_selesai->format("d-m-Y H:i") }}
                                                        </p>
                                                        <p><small>Dana telah dikembalikan ke rekening Anda.</small></p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($pengembalianDana->status == "ditolak")
                                                <div class="timeline-item rejected">
                                                    <div class="timeline-marker"></div>
                                                    <div class="timeline-content">
                                                        <h6>Pengajuan Ditolak</h6>
                                                        <p>Pengajuan pengembalian dana Anda ditolak.</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="text-center">
                                    <a href="{{ route("pelanggan.pengembalian-dana.index") }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                    <a href="{{ route("pelanggan.transaksi") }}" class="btn btn-primary">
                                        <i class="fa fa-list"></i> Lihat Semua Transaksi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-marker {
            position: absolute;
            left: -37px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e9ecef;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e9ecef;
        }

        .timeline-item.completed .timeline-marker {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }

        .timeline-item.active .timeline-marker {
            background: #007bff;
            box-shadow: 0 0 0 2px #007bff;
        }

        .timeline-item.rejected .timeline-marker {
            background: #dc3545;
            box-shadow: 0 0 0 2px #dc3545;
        }

        .timeline-content h6 {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .timeline-content p {
            margin-bottom: 0;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
@endsection

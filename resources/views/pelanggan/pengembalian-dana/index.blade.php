@extends("layouts.guest")

@section("title", "Daftar Pengembalian Dana")

@section("content")
<!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Daftar Pengembalian Dana Saya</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <span>Daftar Pengembalian Dana Saya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="blog_area section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog_left_sidebar">
                        <div class="single_blog_item blog_item_02">
                            <div class="single_blog_text">

                                <!-- Filter Status -->
                                <form method="GET" class="mb-4 mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                <option value="">Semua Status</option>
                                                <option value="pending"
                                                    {{ request("status") == "pending" ? "selected" : "" }}>Menunggu
                                                    Persetujuan</option>
                                                <option value="diproses"
                                                    {{ request("status") == "diproses" ? "selected" : "" }}>Sedang Diproses
                                                </option>
                                                <option value="selesai"
                                                    {{ request("status") == "selesai" ? "selected" : "" }}>Selesai</option>
                                                <option value="ditolak"
                                                    {{ request("status") == "ditolak" ? "selected" : "" }}>Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                                @if ($pengembalianDana->count() > 0)
                                    @foreach ($pengembalianDana as $item)
                                        <div class="card mb-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $item->kode_pengembalian }}</strong>
                                                    <small class="text-muted">|
                                                        {{ $item->transaksi->kode_transaksi }}</small>
                                                </div>
                                                <div>
                                                    @if ($item->status == "pending")
                                                        <span class="badge bg-warning">{{ $item->status_text }}</span>
                                                    @elseif($item->status == "diproses")
                                                        <span class="badge bg-info">{{ $item->status_text }}</span>
                                                    @elseif($item->status == "selesai")
                                                        <span class="badge bg-success">{{ $item->status_text }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $item->status_text }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <p class="mb-2"><strong>Jumlah Pengembalian:</strong> Rp
                                                            {{ number_format($item->jumlah_pengembalian, 0, ",", ".") }}
                                                        </p>
                                                        <p class="mb-2"><strong>Metode Pengembalian:</strong>
                                                            {{ $item->metode_pengembalian_text }}</p>
                                                        @if ($item->metode_pengembalian != "cash")
                                                            <p class="mb-2"><strong>Rekening/Akun:</strong>
                                                                {{ $item->nama_pemilik_rekening }} -
                                                                {{ $item->nomor_rekening }}</p>
                                                            @if ($item->bank)
                                                                <p class="mb-2"><strong>Bank:</strong>
                                                                    {{ $item->bank }}</p>
                                                            @endif
                                                        @endif
                                                        <p class="mb-2"><strong>Alasan:</strong>
                                                            {{ Str::limit($item->alasan_pembatalan, 100) }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-2"><strong>Tanggal
                                                                Pengajuan:</strong><br>{{ $item->tanggal_pengajuan->format("d-m-Y H:i") }}
                                                        </p>
                                                        @if ($item->tanggal_diproses)
                                                            <p class="mb-2"><strong>Tanggal
                                                                    Diproses:</strong><br>{{ $item->tanggal_diproses->format("d-m-Y H:i") }}
                                                            </p>
                                                        @endif
                                                        @if ($item->tanggal_selesai)
                                                            <p class="mb-2"><strong>Tanggal
                                                                    Selesai:</strong><br>{{ $item->tanggal_selesai->format("d-m-Y H:i") }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($item->catatan_admin)
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Catatan Admin:</strong><br>
                                                        {{ $item->catatan_admin }}
                                                    </div>
                                                @endif

                                                @if ($item->bukti_transfer)
                                                    <div class="mt-3">
                                                        <strong>Bukti Transfer:</strong><br>
                                                        <a href="{{ Storage::url($item->bukti_transfer) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-eye"></i> Lihat Bukti Transfer
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center">
                                        {{ $pengembalianDana->links() }}
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="alert alert-info">
                                            <h5><i class="fa fa-info-circle"></i> Tidak Ada Data</h5>
                                            <p>Anda belum memiliki pengajuan pengembalian dana.</p>
                                            <a href="{{ route("pelanggan.transaksi") }}" class="btn btn-primary">
                                                <i class="fa fa-arrow-left"></i> Kembali ke Transaksi
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends("layouts.app")

@section("title", "Detail Pengembalian Dana")

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Detail Pengembalian Dana</h5>
                    <a href="{{ route("pengembalian-dana.index") }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Pengembalian Dana -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Informasi Pengembalian Dana</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Kode Pengembalian:</strong>
                                        {{ $pengembalianDana->kode_pengembalian }}</p>
                                    <p class="mb-2"><strong>Status:</strong>
                                        @if ($pengembalianDana->status == "pending")
                                            <span class="badge text-bg-warning">{{ $pengembalianDana->status_text }}</span>
                                        @elseif($pengembalianDana->status == "diproses")
                                            <span class="badge text-bg-info">{{ $pengembalianDana->status_text }}</span>
                                        @elseif($pengembalianDana->status == "selesai")
                                            <span class="badge text-bg-success">{{ $pengembalianDana->status_text }}</span>
                                        @else
                                            <span class="badge text-bg-danger">{{ $pengembalianDana->status_text }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong>Jumlah Pengembalian:</strong> Rp
                                        {{ number_format($pengembalianDana->jumlah_pengembalian, 0, ",", ".") }}</p>
                                    <p class="mb-2"><strong>Metode Pengembalian:</strong>
                                        {{ $pengembalianDana->metode_pengembalian_text }}</p>

                                    @if ($pengembalianDana->metode_pengembalian != "cash")
                                        <p class="mb-2"><strong>Nama Pemilik:</strong>
                                            {{ $pengembalianDana->nama_pemilik_rekening }}</p>
                                        <p class="mb-2"><strong>Nomor Rekening/Akun:</strong>
                                            {{ $pengembalianDana->nomor_rekening }}</p>
                                        @if ($pengembalianDana->bank)
                                            <p class="mb-2"><strong>Bank:</strong> {{ $pengembalianDana->bank }}</p>
                                        @endif
                                    @endif

                                    <p class="mb-2"><strong>Tanggal Pengajuan:</strong>
                                        {{ $pengembalianDana->tanggal_pengajuan->format("d-m-Y H:i") }}</p>
                                    @if ($pengembalianDana->tanggal_diproses)
                                        <p class="mb-2"><strong>Tanggal Diproses:</strong>
                                            {{ $pengembalianDana->tanggal_diproses->format("d-m-Y H:i") }}</p>
                                    @endif
                                    @if ($pengembalianDana->tanggal_selesai)
                                        <p class="mb-2"><strong>Tanggal Selesai:</strong>
                                            {{ $pengembalianDana->tanggal_selesai->format("d-m-Y H:i") }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Alasan Pembatalan -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6>Alasan Pembatalan</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $pengembalianDana->alasan_pembatalan }}</p>
                                </div>
                            </div>

                            @if ($pengembalianDana->catatan_admin)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6>Catatan Admin</h6>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $pengembalianDana->catatan_admin }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($pengembalianDana->bukti_transfer)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6>Bukti Transfer</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ Storage::url($pengembalianDana->bukti_transfer) }}" target="_blank"
                                            class="btn btn-primary">
                                            <i class="ti ti-eye me-1"></i>Lihat Bukti Transfer
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi Transaksi -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Informasi Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Kode Transaksi:</strong>
                                        {{ $pengembalianDana->transaksi->kode_transaksi }}</p>
                                    <p class="mb-2"><strong>Pelanggan:</strong> {{ $pengembalianDana->user->name }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $pengembalianDana->user->email }}</p>
                                    <p class="mb-2"><strong>No. Telepon:</strong>
                                        {{ $pengembalianDana->user->no_telp ?? "-" }}</p>
                                    <p class="mb-2"><strong>Total Transaksi:</strong> Rp
                                        {{ number_format($pengembalianDana->transaksi->total, 0, ",", ".") }}</p>
                                    <p class="mb-2"><strong>Status Transaksi:</strong>
                                        @if ($pengembalianDana->transaksi->status == "batal")
                                            <span class="badge text-bg-danger">Dibatalkan</span>
                                        @else
                                            <span
                                                class="badge text-bg-info">{{ ucfirst($pengembalianDana->transaksi->status) }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-2"><strong>Tanggal Transaksi:</strong>
                                        {{ $pengembalianDana->transaksi->created_at->format("d-m-Y H:i") }}</p>
                                </div>
                            </div>

                            <!-- Detail Produk -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6>Detail Produk</h6>
                                </div>
                                <div class="card-body">
                                    @foreach ($pengembalianDana->transaksi->detailTransaksi as $detail)
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                            <div>
                                                <strong>{{ $detail->produk->nama }}</strong><br>
                                                <small class="text-muted">
                                                    Ukuran: {{ $detail->ukuranProduk->ukuran ?? "-" }} |
                                                    Warna: {{ $detail->jenisWarnaProduk->warna ?? "-" }} |
                                                    Qty: {{ $detail->jumlah }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <strong>Rp
                                                    {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ",", ".") }}</strong>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                        <strong>Total:</strong>
                                        <strong>Rp
                                            {{ number_format($pengembalianDana->transaksi->total, 0, ",", ".") }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi untuk Admin -->
                    @if (Auth::user()->role === "admin" && $pengembalianDana->status != "selesai")
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Aksi Admin</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route("pengembalian-dana.edit", $pengembalianDana->id) }}"
                                            class="btn btn-warning">
                                            <i class="ti ti-edit me-1"></i>Update Status
                                        </a>

                                        @if ($pengembalianDana->status == "pending")
                                            <form action="{{ route("pengembalian-dana.update", $pengembalianDana->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method("PUT")
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" class="btn btn-info"
                                                    onclick="return confirm('Setuju untuk memproses pengembalian dana ini?')">
                                                    <i class="ti ti-check me-1"></i>Proses
                                                </button>
                                            </form>

                                            <form action="{{ route("pengembalian-dana.update", $pengembalianDana->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method("PUT")
                                                <input type="hidden" name="status" value="ditolak">
                                                <input type="hidden" name="catatan_admin"
                                                    value="Pengembalian dana ditolak oleh admin">
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Tolak pengajuan pengembalian dana ini?')">
                                                    <i class="ti ti-x me-1"></i>Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

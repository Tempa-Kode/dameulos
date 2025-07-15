@extends('layouts.app')

@section('halaman', 'Transaksi')

@section('judul', 'Detail Transaksi')

@section('content')
    {{-- Include komponen alert --}}
    @include('components.alert')

    <div class="row">
        <!-- Informasi Transaksi -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Transaksi - {{ $transaksi->kode_transaksi }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Transaksi</h6>
                            <p class="mb-1"><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
                            <p class="mb-1"><strong>Status:</strong>
                                @if ($transaksi->status == 'pending')
                                    <span class="badge text-bg-secondary">Pending</span>
                                @elseif ($transaksi->status == 'dibayar')
                                    <span class="badge text-bg-info">Dibayar</span>
                                @elseif ($transaksi->status == 'dikonfirmasi')
                                    <span class="badge text-bg-warning">Dikonfirmasi</span>
                                @elseif ($transaksi->status == 'diproses')
                                    <span class="badge text-bg-secondary">Diproses</span>
                                @elseif ($transaksi->status == 'dikirim')
                                    <span class="badge text-bg-success">Dikirim</span>
                                @else
                                    <span class="badge text-bg-danger">Batal</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y H:i') }}</p>
                            <p class="mb-1"><strong>Catatan:</strong> {{ $transaksi->catatan ?: '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Pelanggan</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $transaksi->user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $transaksi->user->email }}</p>
                            <p class="mb-1"><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Produk -->
                    <h6 class="text-muted mb-3">Detail Produk</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Ukuran</th>
                                    <th>Warna</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->produk->nama }}</td>
                                        <td>{{ $detail->produk->katalog->nama ?? '-' }}</td>
                                        <td>{{ $detail->ukuranProduk->ukuran ?? '-' }}</td>
                                        <td>{{ $detail->jenisWarnaProduk->warna ?? '-' }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan & Aksi -->
        <div class="col-md-4">
            <!-- Ringkasan Total -->
            <div class="card">
                <div class="card-header">
                    <h5>Ringkasan Total</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim:</span>
                        <span>Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            @if($transaksi->pembayaran)
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Status:</strong>
                        @if ($transaksi->pembayaran->status == 'pending')
                            <span class="badge text-bg-warning">Pending</span>
                        @elseif ($transaksi->pembayaran->status == 'dibayar')
                            <span class="badge text-bg-success">Dibayar</span>
                        @else
                            <span class="badge text-bg-danger">Gagal</span>
                        @endif
                    </p>
                    <p class="mb-1"><strong>Jumlah:</strong> Rp {{ number_format($transaksi->pembayaran->total_pembayaran, 0, ',', '.') }}</p>
                    @if($transaksi->pembayaran->tanggal_pembayaran)
                    <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->pembayaran->tanggal_pembayaran)->format('d-m-Y H:i') }}</p>
                    @endif
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Belum ada informasi pembayaran</p>
                </div>
            </div>
            @endif

            <!-- Informasi Pengiriman -->
            @if($transaksi->pengiriman)
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Penerima:</strong> {{ $transaksi->pengiriman->nama_penerima }}</p>
                    <p class="mb-1"><strong>No. Resi:</strong> {{ $transaksi->pengiriman->no_resi }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $transaksi->pengiriman->alamat_pengiriman }}</p>
                    <p class="mb-1"><strong>Berat:</strong> {{ $transaksi->pengiriman->berat }} kg</p>
                    @if($transaksi->pengiriman->catatan)
                    <p class="mb-1"><strong>Catatan:</strong> {{ $transaksi->pengiriman->catatan }}</p>
                    @endif
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Belum ada informasi pengiriman</p>
                </div>
            </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="card">
                <div class="card-header">
                    <h5>Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($transaksi->status == 'pending')
                        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dikonfirmasi">
                            <button type="submit" class="btn btn-warning w-100 mb-2">
                                <i class="ti ti-check me-2"></i>Konfirmasi Pesanan
                            </button>
                        </form>
                        @endif

                        @if($transaksi->status == 'dibayar')
                        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="diproses">
                            <button type="submit" class="btn btn-info w-100 mb-2">
                                <i class="ti ti-settings me-2"></i>Proses Pesanan
                            </button>
                        </form>
                        @endif
                        <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#kirimModal">
                                <i class="ti ti-truck me-2"></i>Kirim Pesanan
                        </button>

                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary w-100">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Kirim Pesanan --}}
    <div class="modal fade" id="kirimModal" tabindex="-1" aria-labelledby="kirimModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="d-inline">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="kirimModalLabel">Kirim Pesanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="dikirim">
                        <input type="text" name="no_resi" class="form-control mb-2" placeholder="Nomor Resi" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-truck me-2"></i>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Kirim Pesanan --}}
@endsection

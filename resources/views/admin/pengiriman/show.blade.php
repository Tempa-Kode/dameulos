@extends('layouts.app')

@section('halaman', 'Pengiriman')

@section('judul', 'Detail Pengiriman')

@section('content')
    {{-- Include komponen alert --}}
    @include('components.alert')

    <div class="row">
        <!-- Informasi Pengiriman -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengiriman - {{ $pengiriman->no_resi }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Pengiriman</h6>
                            <p class="mb-1"><strong>No. Resi:</strong> {{ $pengiriman->no_resi }}</p>
                            <p class="mb-1"><strong>Nama Penerima:</strong> {{ $pengiriman->nama_penerima }}</p>
                            <p class="mb-1"><strong>Berat:</strong> {{ $pengiriman->berat }} kg</p>
                            <p class="mb-1"><strong>Ongkir:</strong> Rp {{ number_format($pengiriman->ongkir, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Catatan:</strong> {{ $pengiriman->catatan ?: '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Alamat Pengiriman</h6>
                            <p class="mb-1"><strong>Alamat Pengirim:</strong> {{ $pengiriman->alamat_pengiriman }}</p>
                            <p class="mb-1"><strong>Alamat Penerima:</strong> {{ $pengiriman->alamat_penerima }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Informasi Transaksi -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Transaksi</h6>
                            <p class="mb-1"><strong>Kode Transaksi:</strong> {{ $pengiriman->transaksi->kode_transaksi }}</p>
                            <p class="mb-1"><strong>Status Transaksi:</strong>
                                @if ($pengiriman->transaksi->status == 'pending')
                                    <span class="badge text-bg-secondary">Pending</span>
                                @elseif ($pengiriman->transaksi->status == 'dibayar')
                                    <span class="badge text-bg-info">Dibayar</span>
                                @elseif ($pengiriman->transaksi->status == 'dikonfirmasi')
                                    <span class="badge text-bg-warning">Dikonfirmasi</span>
                                @elseif ($pengiriman->transaksi->status == 'diproses')
                                    <span class="badge text-bg-secondary">Diproses</span>
                                @elseif ($pengiriman->transaksi->status == 'dikirim')
                                    <span class="badge text-bg-success">Dikirim</span>
                                @else
                                    <span class="badge text-bg-danger">Batal</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($pengiriman->transaksi->created_at)->format('d-m-Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Pelanggan</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $pengiriman->transaksi->user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $pengiriman->transaksi->user->email }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Produk -->
                    <h6 class="text-muted mb-3">Detail Produk yang Dikirim</h6>
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
                                @foreach ($pengiriman->transaksi->detailTransaksi as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->produk->nama }}</td>
                                        <td>{{ $detail->produk->katalog->nama ?? '-' }}</td>
                                        <td>{{ $detail->ukuranProduk->nama ?? '-' }}</td>
                                        <td>{{ $detail->jenisWarnaProduk->nama ?? '-' }}</td>
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
            <!-- Ringkasan Transaksi -->
            <div class="card">
                <div class="card-header">
                    <h5>Ringkasan Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($pengiriman->transaksi->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim:</span>
                        <span>Rp {{ number_format($pengiriman->transaksi->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>Rp {{ number_format($pengiriman->transaksi->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Status Pengiriman -->
            <div class="card">
                <div class="card-header">
                    <h5>Status Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon bg-success">
                                <i class="ti ti-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pesanan Dikonfirmasi</h6>
                                <p class="text-muted">Pesanan telah dikonfirmasi dan siap diproses</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon bg-success">
                                <i class="ti ti-package"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pesanan Diproses</h6>
                                <p class="text-muted">Pesanan sedang dikemas dan disiapkan</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $pengiriman->transaksi->status == 'dikirim' ? 'bg-success' : 'bg-secondary' }}">
                                <i class="ti ti-truck"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pesanan Dikirim</h6>
                                <p class="text-muted">Pesanan sedang dalam perjalanan</p>
                                <small class="text-primary">No. Resi: {{ $pengiriman->no_resi }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="card">
                <div class="card-header">
                    <h5>Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('transaksi.show', $pengiriman->transaksi->id) }}" class="btn btn-primary w-100">
                            <i class="ti ti-eye me-2"></i>Lihat Detail Transaksi
                        </a>
                        <button type="button" class="btn btn-warning w-100" onclick="window.print()">
                            <i class="ti ti-printer me-2"></i>Cetak Label Pengiriman
                        </button>
                        <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary w-100">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -19px;
        top: 30px;
        width: 2px;
        height: calc(100% + 10px);
        background: #e9ecef;
    }

    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: white;
    }

    .timeline-content h6 {
        margin: 0 0 5px 0;
        font-size: 14px;
    }

    .timeline-content p {
        margin: 0;
        font-size: 12px;
    }

    .timeline-content small {
        font-size: 11px;
    }
</style>
@endpush

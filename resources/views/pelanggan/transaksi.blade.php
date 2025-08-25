@extends('layouts.guest')

@section('title', 'Transaksi Saya - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option" style="margin-top: 110px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Transaksi Saya</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <span>Transaksi Saya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Transaction Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($transaksi->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i>
                        Anda belum memiliki transaksi apapun.
                        <br>
                        <a href="{{ route('pelanggan.katalog') }}" class="btn btn-primary mt-3">
                            Mulai Belanja
                        </a>
                    </div>
                @else
                    @foreach($transaksi as $item)
                        <div class="shopping__cart__table mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h5 class="mb-0">
                                                <a href="{{ route('pelanggan.checkout.success', $item->kode_transaksi) }}" class="text-white text-decoration-none">
                                                    <i class="fa fa-receipt"></i>
                                                    {{ $item->kode_transaksi }}
                                                </a>
                                                @if ($item->preorder == 1)
                                                    <span class="badge badge-warning ml-2">Pre-Order</span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small>{{ $item->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="text-primary">Detail Produk:</h6>
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item->detailTransaksi as $detail)
                                                        <tr>
                                                            <td>
                                                                <div class="product__cart__item__text">
                                                                    <h6>{{ $detail->produk->nama }}</h6>
                                                                    <p class="text-muted">
                                                                        @if($detail->ukuranProduk)
                                                                            Ukuran: {{ $detail->ukuranProduk->ukuran }}
                                                                        @endif
                                                                        @if($detail->jenisWarnaProduk)
                                                                            | Warna: {{ $detail->jenisWarnaProduk->warna }}
                                                                        @endif
                                                                    </p>
                                                                    @if ($item->status == 'diterima')
                                                                        <a href="{{ route('pelanggan.ulasan.create', ['transaksi_id' => $item->id, 'produk_id' => $detail->produk->id]) }}"
                                                                           class="btn btn-success btn-sm">
                                                                            <i class="fa fa-comments mr-2"></i>
                                                                            Beri Ulasan Produk
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>{{ $detail->jumlah }}</td>
                                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                            <td><strong>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</strong></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="shopping__cart__total">
                                                <h6>Informasi Transaksi</h6>
                                                <ul>
                                                    <li>Status:
                                                        @if($item->status == 'pending')
                                                            <span class="badge badge-warning">Menunggu</span>
                                                        @elseif($item->status == 'dibayar')
                                                            <span class="badge badge-info">Dibayar</span>
                                                        @elseif($item->status == 'dikonfirmasi')
                                                            <span class="badge badge-info">Dikonfirmasi</span>
                                                        @elseif($item->status == 'diproses')
                                                            <span class="badge badge-info">Diproses</span>
                                                        @elseif($item->status == 'dikirim')
                                                            <span class="badge badge-primary">Dikirim</span>
                                                        @elseif($item->status == 'diterima')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @elseif($item->status == 'gagal')
                                                            <span class="badge badge-danger">Dibatalkan</span>
                                                        @endif
                                                        <br>
                                                        @if ($item->status == 'pending' || $item->status == 'dikonfirmasi')
                                                        <small>
                                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="updateStatus('{{ $item->kode_transaksi }}')">
                                                                <i class="fa fa-refresh"></i> Update Status
                                                            </button>
                                                        </small>
                                                        @endif
                                                    </li>
                                                    <li>Subtotal <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></li>
                                                    <li>Ongkir <span>Rp {{ number_format($item->ongkir, 0, ',', '.') }}</span></li>
                                                    <li>Total <span>Rp {{ number_format($item->total, 0, ',', '.') }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    @if($item->alamat_pengiriman)
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h6 class="text-primary">Alamat Pengiriman:</h6>
                                                <p class="mb-0">{{ $item->alamat_pengiriman }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($item->catatan)
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h6 class="text-primary">Catatan:</h6>
                                                <p class="mb-0">{{ $item->catatan }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($item->pembayaran)
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h6 class="text-primary">Status Pembayaran:</h6>
                                                @if($item->pembayaran->status == 'pending')
                                                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                                                @elseif($item->pembayaran->status == 'dibayar')
                                                    <span class="badge badge-success">Sudah Dibayar</span>
                                                @elseif($item->pembayaran->status == 'gagal')
                                                    <span class="badge badge-danger">Gagal</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($item->pengiriman)
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h6 class="text-primary">Informasi Pengiriman:</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Kurir:</strong> J&T Express
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Resi:</strong> {{ $item->pengiriman->no_resi ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($item->status == 'dikirim')
                                        <button data-id="{{ $item->id }}" class="primary-btn mt-2 terima-pesanan">Terima Pesanan</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Transaction Section End -->
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }
    .badge-primary {
        background-color: #007bff;
        color: #fff;
    }
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }
    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    .card-header {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        background-color: #ca1515 !important;
    }
    .card-body {
        padding: 1.5rem;
    }
    .shopping__cart__total {
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 5px;
    }
    .shopping__cart__total h6 {
        color: #1c1c1c;
        font-weight: 700;
        margin-bottom: 25px;
    }
    .shopping__cart__total ul {
        margin-bottom: 0;
    }
    .shopping__cart__total ul li {
        list-style: none;
        font-size: 16px;
        color: #1c1c1c;
        line-height: 40px;
        border-bottom: 1px solid #e1e1e1;
    }
    .shopping__cart__total ul li:last-child {
        border-bottom: none;
        font-weight: 700;
    }
    .shopping__cart__total ul li span {
        float: right;
        font-weight: 700;
        color: #ca1515;
    }
    .table-borderless td,
    .table-borderless th {
        border: none;
        padding: 10px 15px;
    }
    .table-borderless thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #1c1c1c;
    }
    .product__cart__item__text h6 {
        color: #1c1c1c;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .product__cart__item__text p {
        color: #888;
        margin-bottom: 0;
        font-size: 14px;
    }
    .text-primary {
        color: #ca1515 !important;
    }
    .alert {
        padding: 30px;
        border-radius: 5px;
        margin-bottom: 30px;
    }
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }
    .btn {
        border-radius: 0;
        font-weight: 600;
        padding: 12px 30px;
        border: none;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-primary {
        background-color: #ca1515;
        border-color: #ca1515;
    }
    .btn-primary:hover {
        background-color: #a11010;
        border-color: #a11010;
    }
    .btn-outline-primary {
        color: #ca1515;
        border-color: #ca1515;
    }
    .btn-outline-primary:hover {
        background-color: #ca1515;
        border-color: #ca1515;
        color: #fff;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('bukti_transfer');
        if(input){
            input.addEventListener('change', function(e){
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file gambar...';
                const label = input.nextElementSibling;
                if(label) label.innerText = fileName;
            });
        }
    });
</script>
<script>
function updateStatus(kodeTransaksi) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
    button.disabled = true;

    // Send AJAX request - using direct URL instead of route helper
    fetch(`/transaksi/update-status/${kodeTransaksi}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            // Reload page after 2 seconds
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            // Show error message
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Terjadi kesalahan saat mengupdate status'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan jaringan'
        });
    })
    .finally(() => {
        // Reset button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

$('.terima-pesanan').on('click', function() {
    const transaksiId = $(this).data('id');
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin telah menerima pesanan ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, sudah',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to update status
            $.ajax({
                url: `pengiriman/${transaksiId}/terima-pesanan`,
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Terjadi kesalahan saat menerima pesanan'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan jaringan'
                    });
                }
            });
        }
    });
});
</script>
@endpush

@extends('layouts.guest')

@section('title', 'Detail Ulasan - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Detail Ulasan</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <a href="{{ route('pelanggan.ulasan.index') }}">Ulasan Saya</a>
                        <span>Detail Ulasan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Review Detail Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-star"></i>
                            Detail Ulasan Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Product Info -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <img src="{{ asset($ulasan->produk->gambar) }}"
                                    alt="{{ $ulasan->produk->nama }}"
                                    class="img-fluid rounded"
                                    style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $ulasan->produk->nama }}</h5>
                                <p><strong>Harga Produk:</strong> Rp {{ number_format($ulasan->produk->harga, 0, ',', '.') }}</p>
                                <p><strong>Kategori:</strong> {{ $ulasan->produk->katalog->nama ?? 'Tidak ada kategori' }}</p>
                                <p><strong>Transaksi:</strong> {{ $ulasan->transaksi->kode_transaksi }}</p>
                                <p><strong>Tanggal Transaksi:</strong> {{ $ulasan->transaksi->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="review-content">
                            <h6 class="text-primary mb-3">
                                <i class="fa fa-comment"></i>
                                Ulasan Anda
                            </h6>

                            <!-- Rating Display -->
                            <div class="rating-display mb-3">
                                <label class="form-label"><strong>Rating:</strong></label>
                                <div class="stars-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $ulasan->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ml-2 badge badge-primary">{{ $ulasan->rating }}/5</span>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <div class="review-text mb-4">
                                <label class="form-label"><strong>Ulasan:</strong></label>
                                <div class="review-content-box">
                                    {{ $ulasan->ulasan }}
                                </div>
                            </div>

                            <!-- Review Meta -->
                            <div class="review-meta">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fa fa-calendar"></i>
                                            Ulasan dibuat pada: {{ $ulasan->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        @if($ulasan->updated_at != $ulasan->created_at)
                                            <small class="text-muted">
                                                <i class="fa fa-edit"></i>
                                                Terakhir diupdate: {{ $ulasan->updated_at->format('d M Y, H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons text-center mt-4">
                            <a href="{{ route('pelanggan.ulasan.edit', $ulasan) }}" class="btn btn-primary mr-3">
                                <i class="fa fa-edit"></i>
                                Edit Ulasan
                            </a>
                            <a href="{{ route('pelanggan.ulasan.index') }}" class="btn btn-secondary mr-3">
                                <i class="fa fa-arrow-left"></i>
                                Kembali ke Daftar
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fa fa-trash"></i>
                                Hapus Ulasan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Review Detail Section End -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Ulasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('pelanggan.ulasan.destroy', $ulasan) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .card-header {
        background-color: #ca1515 !important;
        border-bottom: 1px solid #dee2e6;
    }
    .card-body {
        padding: 2rem;
    }
    .stars-display {
        font-size: 1.5rem;
    }
    .review-content-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1.5rem;
        color: #555;
        line-height: 1.6;
        min-height: 100px;
    }
    .review-meta {
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    .badge-primary {
        background-color: #ca1515;
        font-size: 0.9rem;
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
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .no-image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 150px;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 0.375rem;
        color: #6c757d;
    }
    .no-image-placeholder i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }
    .text-primary {
        color: #ca1515 !important;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}
</script>
@endpush

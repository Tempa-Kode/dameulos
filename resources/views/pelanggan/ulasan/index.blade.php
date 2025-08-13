@extends('layouts.guest')

@section('title', 'Ulasan Saya - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option" style="margin-top: 110px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Ulasan Saya</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <span>Ulasan Saya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Reviews Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($ulasan->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i>
                        Anda belum memberikan ulasan apapun.
                        <br>
                        <a href="{{ route('pelanggan.transaksi') }}" class="btn btn-primary mt-3">
                            Lihat Transaksi Saya
                        </a>
                    </div>
                @else
                    @foreach($ulasan as $review)
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ asset($review->produk->gambar) }}"
                                             alt="{{ $review->produk->nama }}"
                                             class="img-fluid rounded"
                                             style="width: 100%; height: 120px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-primary">{{ $review->produk->nama }}</h5>
                                                <div class="rating-display mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                    <span class="ml-2 text-muted">({{ $review->rating }}/5)</span>
                                                </div>
                                                <p class="review-text">{{ $review->ulasan }}</p>
                                                <small class="text-muted">
                                                    <i class="fa fa-calendar"></i>
                                                    Ulasan diberikan pada {{ $review->created_at->format('d M Y, H:i') }}
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="action-buttons">
                                                    <a href="{{ route('pelanggan.ulasan.show', $review) }}"
                                                       class="btn btn-outline-primary btn-sm mb-2">
                                                        <i class="fa fa-eye"></i>
                                                        Lihat Detail
                                                    </a>
                                                    <br>
                                                    <a href="{{ route('pelanggan.ulasan.edit', $review) }}"
                                                       class="btn btn-outline-secondary btn-sm mb-2">
                                                        <i class="fa fa-edit"></i>
                                                        Edit Ulasan
                                                    </a>
                                                    <br>
                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $review->id }})">
                                                        <i class="fa fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $ulasan->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Reviews Section End -->

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
                <form id="deleteForm" method="POST" style="display: inline;">
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
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .rating-display {
        font-size: 1.1rem;
    }
    .review-text {
        color: #555;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    .action-buttons .btn {
        width: 120px;
        margin-bottom: 0.5rem;
    }
    .no-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 0.375rem;
        color: #6c757d;
    }
    .no-image-placeholder i {
        font-size: 2rem;
    }
    .text-primary {
        color: #ca1515 !important;
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
    .btn-primary {
        background-color: #ca1515;
        border-color: #ca1515;
    }
    .btn-primary:hover {
        background-color: #a11010;
        border-color: #a11010;
    }
    .alert {
        border-radius: 0.375rem;
        padding: 1rem;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(reviewId) {
    $('#deleteForm').attr('action', `/ulasan/${reviewId}`);
    $('#deleteModal').modal('show');
}

$(document).ready(function() {
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush

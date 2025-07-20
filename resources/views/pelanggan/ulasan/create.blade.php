@extends('layouts.guest')

@section('title', 'Beri Ulasan Produk - Dame Ulos')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Beri Ulasan Produk</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('pelanggan.home') }}">Home</a>
                        <a href="{{ route('pelanggan.transaksi') }}">Transaksi Saya</a>
                        <span>Beri Ulasan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Review Form Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-star"></i>
                            Beri Ulasan Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Product Info -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <img src="{{ asset($produk->gambar) }}"
                                     alt="{{ $produk->nama }}"
                                     class="img-thumbnail rounded">
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $produk->nama }}</h5>
                                <p class="text-muted">
                                    @if($detailTransaksi->ukuranProduk)
                                        Ukuran: {{ $detailTransaksi->ukuranProduk->ukuran }}
                                    @endif
                                    @if($detailTransaksi->jenisWarnaProduk)
                                        | Warna: {{ $detailTransaksi->jenisWarnaProduk->warna }}
                                    @endif
                                </p>
                                <p><strong>Jumlah:</strong> {{ $detailTransaksi->jumlah }}</p>
                                <p><strong>Harga:</strong> Rp {{ number_format($detailTransaksi->harga_satuan, 0, ',', '.') }}</p>
                                <p><strong>Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
                            </div>
                        </div>

                        <!-- Review Form -->
                        <form action="{{ route('pelanggan.ulasan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                            <!-- Rating -->
                            <div class="form-group mb-4">
                                <label for="rating" class="form-label">
                                    <strong>Rating Produk <span class="text-danger">*</span></strong>
                                </label>
                                <div class="rating-stars mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star" data-rating="{{ $i }}">
                                            <i class="fa fa-star"></i>
                                        </span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                                @error('rating')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Klik bintang untuk memberikan rating</small>
                            </div>

                            <!-- Review Text -->
                            <div class="form-group mb-4">
                                <label for="ulasan" class="form-label">
                                    <strong>Ulasan Anda <span class="text-danger">*</span></strong>
                                </label>
                                <textarea name="ulasan" id="ulasan" class="form-control @error('ulasan') is-invalid @enderror"
                                          rows="5" placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                                          required>{{ old('ulasan') }}</textarea>
                                @error('ulasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 10 karakter, maksimal 1000 karakter</small>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mr-3">
                                    <i class="fa fa-paper-plane"></i>
                                    Kirim Ulasan
                                </button>
                                <a href="{{ route('pelanggan.transaksi') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Review Form Section End -->
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
    .rating-stars {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
    }
    .rating-stars .star {
        margin-right: 0.5rem;
        transition: color 0.3s ease;
    }
    .rating-stars .star:hover,
    .rating-stars .star.active {
        color: #ffc107;
    }
    .form-control {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.75rem;
    }
    .form-control:focus {
        border-color: #ca1515;
        box-shadow: 0 0 0 0.2rem rgba(202, 21, 21, 0.25);
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Rating stars functionality
    $('.star').on('click', function() {
        const rating = $(this).data('rating');
        $('#rating').val(rating);

        $('.star').removeClass('active');
        for(let i = 1; i <= rating; i++) {
            $(`.star[data-rating="${i}"]`).addClass('active');
        }
    });

    // Hover effect for stars
    $('.star').on('mouseenter', function() {
        const rating = $(this).data('rating');
        $('.star').removeClass('hover');
        for(let i = 1; i <= rating; i++) {
            $(`.star[data-rating="${i}"]`).addClass('hover');
        }
    });

    $('.rating-stars').on('mouseleave', function() {
        $('.star').removeClass('hover');
    });

    // Set initial rating if exists
    const currentRating = $('#rating').val();
    if(currentRating) {
        for(let i = 1; i <= currentRating; i++) {
            $(`.star[data-rating="${i}"]`).addClass('active');
        }
    }

    // Character counter for textarea
    $('#ulasan').on('input', function() {
        const length = $(this).val().length;
        const maxLength = 1000;
        const remaining = maxLength - length;

        if (!$('.char-counter').length) {
            $(this).after(`<small class="char-counter text-muted"></small>`);
        }

        $('.char-counter').text(`${length}/1000 karakter`);

        if (length > maxLength) {
            $('.char-counter').removeClass('text-muted').addClass('text-danger');
        } else {
            $('.char-counter').removeClass('text-danger').addClass('text-muted');
        }
    });
});
</script>
@endpush

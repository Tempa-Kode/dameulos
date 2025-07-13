@extends('layouts.guest')

@section('title', $produk->nama . ' - Dame Ulos')

@push('styles')
    <style>
        .primary-outline-btn {
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 14px 30px;
            color: #000000;
            background: transparent;
            border: 2px solid #000000;
            letter-spacing: 4px;
            transition: all 0.3s ease;
        }

        .primary-outline-btn:hover {
            color: #ffffff;
            background: #000000;
        }

        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
            overflow: hidden;
        }

        .btn-loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1;
        }

        .btn-loading .btn-text {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-loading.with-text::before {
            left: 20px;
            margin-left: 0;
        }

        .btn-loading.with-text .btn-text {
            opacity: 1;
            padding-left: 30px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Button pulse effect */
        .primary-btn.pulse {
            animation: pulse 0.6s ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Success animation */
        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            transition: all 0.3s ease;
        }

        .btn-success::before {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            color: white;
            z-index: 1;
        }

        /* Shimmer effect for loading */
        .btn-loading.shimmer {
            background: linear-gradient(90deg, #ca1515 25%, #e53e3e 50%, #ca1515 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Disabled state styling */
        .primary-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Custom validation alert */
        .validation-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: none;
            max-width: 400px;
        }

        .alert-content {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(238, 90, 82, 0.3);
            display: flex;
            align-items: center;
            animation: slideInRight 0.3s ease;
        }

        .alert-content i {
            margin-right: 10px;
            font-size: 18px;
        }

        .alert-content span {
            font-weight: 500;
            font-size: 14px;
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Loading overlay effect */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 9998;
            display: none;
        }

        /* Enhance primary button hover effect */
        .primary-btn {
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .primary-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(202, 21, 21, 0.3);
        }

        .primary-btn:active:not(:disabled) {
            transform: translateY(0);
            transition: all 0.1s ease;
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Detail Produk</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('pelanggan.home') }}">Home</a>
                            <a href="{{ route('pelanggan.katalog') }}">Katalog</a>
                            <span>{{ $produk->nama }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__pic__item">
                                <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="product__details__text">
                            <h4>{{ $produk->nama }}</h4>
                            <h3>Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
                            <p>{{ $produk->deskripsi }}</p>

                            @if(isset($produk->ukuran) && $produk->ukuran->count() > 0)
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Ukuran tersedia:</span>
                                    @foreach($produk->ukuran as $ukuran)
                                    <label class="m-1" for="ukuran-{{ $ukuran->id }}">{{ $ukuran->ukuran }}
                                        <input type="radio" id="ukuran-{{ $ukuran->id }}" name="ukuran" value="{{ $ukuran->id }}">
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(isset($produk->jenisWarnaProduk) && $produk->jenisWarnaProduk->count() > 0)
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Warna tersedia:</span>
                                    @foreach($produk->jenisWarnaProduk as $warna)
                                    <label class="m-1" for="warna-{{ $warna->id }}">{{ $warna->warna }}
                                        <input type="radio" id="warna-{{ $warna->id }}" name="warna" value="{{ $warna->id }}">
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" id="jumlah" name="jumlah" min="1" max="{{ $produk->stok }}">
                                    </div>
                                </div>
                                <button id="checkout" class="primary-btn">
                                    <span class="btn-text">Beli Sekarang</span>
                                </button>
                                <a href="#" class="primary-outline-btn"><i class="fa-solid fa-cart-plus"></i></a>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="{{ route('pelanggan.katalogBySlug', $produk->katalog->slug) }}">Kategori: <span>{{ $produk->katalog->nama }}</a>
                            </div>

                            @if(isset($produk->warnaProduk) && $produk->warnaProduk->count() > 0)
                            <div class="product__details__option__color">
                                <span>Family Color:</span>
                                @foreach($produk->warnaProduk as $warna)
                                <label style="background-color: #{{ $warna->kode_warna }}" for="kode-{{ $warna->id }}">
                                    <input type="radio" id="kode-{{ $warna->id }}">
                                </label>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Deskripsi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Ulasan</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $produk->deskripsi }}</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Belum ada ulasan untuk produk ini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Produk Terkait</h3>
                </div>
            </div>
            <div class="row">
                @forelse($produkTerkait as $terkait)
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic" style="height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                            <img src="{{ asset($terkait->gambar) }}" alt="{{ $terkait->nama }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $terkait->nama }}</h6>
                            <a href="{{ route('pelanggan.produkBySlug', $terkait->slug) }}" class="add-cart">Lihat Detail</a>
                            <h5>Rp {{ number_format($terkait->harga, 0, ',', '.') }}</h5>
                            <span class="badge badge-light">{{ $terkait->katalog->nama }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"></div>
                    <div class="alert alert-warning text-center w-100">
                        <strong>Maaf!</strong> Tidak ada produk terkait yang ditemukan.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Related Section End -->
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#checkout').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $buttonText = $button.find('.btn-text');
            const originalText = $buttonText.text();

            const jumlah = $('#jumlah').val();
            const ukuranId = $('input[name="ukuran"]:checked').val();
            const warnaId = $('input[name="warna"]:checked').val();

            // Validation
            if (!jumlah || jumlah < 1) {
                showValidationError('Jumlah produk minimal 1');
                return;
            }

            if (jumlah > {{ $produk->stok }}) {
                showValidationError('Jumlah melebihi stok yang tersedia ({{ $produk->stok }} item)');
                return;
            }

            if (!ukuranId) {
                showValidationError('Silakan pilih ukuran produk.');
                return;
            }

            if (!warnaId) {
                showValidationError('Silakan pilih warna produk.');
                return;
            }

            // Show loading state with animation
            showLoadingState($button, $buttonText);

            // Send AJAX request
            $.ajax({
                url: '{{ route("pelanggan.checkout") }}',
                method: 'POST',
                data: {
                    produk_id: {{ $produk->id }},
                    ukuran_id: ukuranId,
                    warna_id: warnaId,
                    jumlah: jumlah,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showSuccessState($button, $buttonText);

                        // Redirect after showing success animation
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 800);
                    } else {
                        showErrorState($button, $buttonText, originalText);
                        alert(response.message || 'Terjadi kesalahan saat memproses pesanan.');
                    }
                },
                error: function(xhr) {
                    showErrorState($button, $buttonText, originalText);

                    let errorMessage = 'Terjadi kesalahan saat memproses pesanan.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }

                    alert(errorMessage);
                }
            });
        });

        // Add loading overlay to body
        $('body').append('<div class="loading-overlay"></div>');

        // Show overlay during AJAX request
        $(document).ajaxStart(function() {
            $('.loading-overlay').fadeIn(200);
        });

        $(document).ajaxStop(function() {
            $('.loading-overlay').fadeOut(200);
        });

        // Helper functions for button states
        function showLoadingState($button, $buttonText) {
            $button.prop('disabled', true)
                   .addClass('btn-loading shimmer with-text');
            $buttonText.text('Memproses...');

            // Add pulse effect
            $button.addClass('pulse');
            setTimeout(() => $button.removeClass('pulse'), 600);
        }

        function showSuccessState($button, $buttonText) {
            $button.removeClass('btn-loading shimmer with-text')
                   .addClass('btn-success');
            $buttonText.text('Berhasil!');
        }

        function showErrorState($button, $buttonText, originalText) {
            $button.prop('disabled', false)
                   .removeClass('btn-loading shimmer with-text btn-success');
            $buttonText.text(originalText);
        }

        function showValidationError(message) {
            // Create custom alert with animation
            const alertHtml = `
                <div class="validation-alert">
                    <div class="alert-content">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `;

            if ($('.validation-alert').length === 0) {
                $('body').append(alertHtml);
                $('.validation-alert').fadeIn(300);

                setTimeout(() => {
                    $('.validation-alert').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }

        // Quantity controls
        $(document).ready(function() {
            const $jumlahInput = $('#jumlah');
            const maxStock = {{ $produk->stok }};

            // Add quantity controls if they don't exist
            if (!$('.pro-qty .qtybtn').length) {
                // Create minus button
                const $minusBtn = $('<button type="button" class="qtybtn">-</button>');
                $minusBtn.click(function() {
                    let currentVal = parseInt($jumlahInput.val());
                    if (currentVal > 1) {
                        $jumlahInput.val(currentVal - 1);
                    }
                });

                // Create plus button
                const $plusBtn = $('<button type="button" class="qtybtn">+</button>');
                $plusBtn.click(function() {
                    let currentVal = parseInt($jumlahInput.val());
                    if (currentVal < maxStock) {
                        $jumlahInput.val(currentVal + 1);
                    } else {
                        alert('Stok maksimal adalah ' + maxStock + ' item');
                    }
                });

                // Insert buttons
                $('.pro-qty').prepend($minusBtn).append($plusBtn);
            }

            // Validate manual input
            $jumlahInput.on('change keyup', function() {
                let val = parseInt($(this).val());
                if (isNaN(val) || val < 1) {
                    $(this).val(1);
                } else if (val > maxStock) {
                    $(this).val(maxStock);
                    alert('Stok maksimal adalah ' + maxStock + ' item');
                }
            });
        });
    </script>
@endpush

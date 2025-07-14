@extends('layouts.guest')

@section('title', $produk->nama . ' - Dame Ulos')

@push('styles')
    <link rel="stylesheet" href="{{ asset('home/css/app.css') }}">
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
                                <div class="product__details__option__jenwarna">
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
                                <button id="keranjang" class="primary-outline-btn"><i class="fa-solid fa-cart-plus"></i></button>
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

        $(".product__color__select label, .shop__sidebar__size label, .product__details__option__jenwarna label").on('click', function () {
            $(".product__color__select label, .shop__sidebar__size label, .product__details__option__jenwarna label").removeClass('active');
            $(this).addClass('active');
        });

        /*-------------------
                Quantity change
            --------------------- */
            var proQty = $('.pro-qty');
            proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
            proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
            proQty.on('click', '.qtybtn', function () {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $button.parent().find('input').val(newVal);
            });

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

            // Check if product has size options and validate if required
            const hasUkuranOptions = $('input[name="ukuran"]').length > 0;
            if (hasUkuranOptions && !ukuranId) {
                showValidationError('Silakan pilih ukuran produk');
                return;
            }

            // Check if product has color options and validate if required
            const hasWarnaOptions = $('input[name="warna"]').length > 0;
            if (hasWarnaOptions && !warnaId) {
                showValidationError('Silakan pilih warna produk');
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
                    ukuran_id: ukuranId || null,
                    warna_id: warnaId || null,
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

        $('#keranjang').on('click', function(e){
            e.preventDefault();
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

            // Check if product has size options and validate if required
            const hasUkuranOptions = $('input[name="ukuran"]').length > 0;
            if (hasUkuranOptions && !ukuranId) {
                showValidationError('Silakan pilih ukuran produk');
                return;
            }

            // Check if product has color options and validate if required
            const hasWarnaOptions = $('input[name="warna"]').length > 0;
            if (hasWarnaOptions && !warnaId) {
                showValidationError('Silakan pilih warna produk');
                return;
            }

            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            // Send AJAX request
            $.ajax({
                url: '{{ route("pelanggan.keranjang.create") }}',
                method: 'POST',
                data: {
                    produk_id: {{ $produk->id }},
                    ukuran_id: ukuranId || null,
                    warna_id: warnaId || null,
                    jumlah: jumlah,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: "Berhasil ditambahkan ke keranjang"
                        });
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
        })

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
        // $(document).ready(function() {
        //     const $jumlahInput = $('#jumlah');
        //     const maxStock = {{ $produk->stok }};

        //     // Add quantity controls if they don't exist
        //     if (!$('.pro-qty .qtybtn').length) {
        //         // Create minus button
        //         const $minusBtn = $('<button type="button" class="qtybtn">-</button>');
        //         $minusBtn.click(function() {
        //             let currentVal = parseInt($jumlahInput.val());
        //             if (currentVal > 1) {
        //                 $jumlahInput.val(currentVal - 1);
        //             }
        //         });

        //         // Create plus button
        //         const $plusBtn = $('<button type="button" class="qtybtn">+</button>');
        //         $plusBtn.click(function() {
        //             let currentVal = parseInt($jumlahInput.val());
        //             if (currentVal < maxStock) {
        //                 $jumlahInput.val(currentVal + 1);
        //             } else {
        //                 alert('Stok maksimal adalah ' + maxStock + ' item');
        //             }
        //         });

        //         // Insert buttons
        //         $('.pro-qty').prepend($minusBtn).append($plusBtn);
        //     }

        //     // Validate manual input
        //     $jumlahInput.on('change keyup', function() {
        //         let val = parseInt($(this).val());
        //         if (isNaN(val) || val < 1) {
        //             $(this).val(1);
        //         } else if (val > maxStock) {
        //             $(this).val(maxStock);
        //             alert('Stok maksimal adalah ' + maxStock + ' item');
        //         }
        //     });
        // });
    </script>
@endpush

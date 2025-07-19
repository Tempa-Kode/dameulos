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
                                <img src="{{ asset($produk->gambar ?? 'images/no-image.png') }}" alt="{{ $produk->nama }}" id="mainImage">
                            </div>
                        </div>
                        @if($produk->fotoProduk && $produk->fotoProduk->count() > 0)
                            <div class="product__details__pic__slider owl-carousel mt-3">
                                <!-- Gambar utama sebagai slide pertama -->
                                <img src="{{ asset($produk->gambar ?? 'images/no-image.png') }}"
                                     alt="{{ $produk->nama }}"
                                     class="gallery-thumb"
                                     onclick="changeMainImage('{{ asset($produk->gambar ?? 'images/no-image.png') }}')">

                                <!-- Foto produk tambahan -->
                                @foreach($produk->fotoProduk as $foto)
                                    <img src="{{ asset($foto->foto) }}"
                                         alt="Foto Produk {{ $loop->iteration }}"
                                         class="gallery-thumb"
                                         onclick="changeMainImage('{{ asset($foto->foto) }}')">
                                @endforeach
                            </div>
                        @endif
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

                            @if (Auth::check())
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" id="jumlah" name="jumlah" min="1" max="{{ $produk->stok }}">
                                    </div>
                                </div>
                                <button id="checkout" class="primary-btn">
                                    <span class="btn-text">Beli Sekarang</span>
                                </button>
                                <button id="requestWarna" class="primary-outline-btn" data-toggle="modal" data-target="#exampleModal" data-placement="top" title="Request Warna">
                                    <i class="fa-solid fa-palette"></i>
                                </button>
                                <button id="keranjang" class="primary-outline-btn"><i class="fa-solid fa-cart-plus"></i></button>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="{{ route('pelanggan.katalogBySlug', $produk->katalog->slug) }}">Kategori: <span>{{ $produk->katalog->nama }}</a>
                            </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Silahkan login terlebih dahulu untuk melakukan pembelian.
                                </div>
                            @endif

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

    <!-- Modal Request Warna -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Warna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="colorContainer">
                    <div class="color-item" data-index="0">
                        <div class="form-group">
                            <label for="colorPicker_0">Pilih Warna 1:</label>
                            <div class="input-group">
                                <input type="color" name="warna_custom[]" id="colorPicker_0" class="form-control color-picker" value="#000000">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-color" disabled>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Kode Hex: <span class="hex-value">#000000</span></small>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-primary" id="addColor">
                        <i class="fa fa-plus"></i> Tambah Warna
                    </button>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn primary-outline-btn" data-dismiss="modal">Batal</button>
                <button type="button" id="preorder" class="btn primary-btn">Pre-Order</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal Request Warna -->
@endsection

@push('scripts')
    <script src="{{ asset('home/js/ProdukDetail.js') }}"></script>
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

        $('#preorder').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $buttonText = $button.find('.btn-text');
            const originalText = $buttonText.text();

            const jumlah = $('#jumlah').val();
            const ukuranId = $('input[name="ukuran"]:checked').val();
            const warnaId = $('input[name="warna"]:checked').val();
            const kodeWarna = $('.color-picker').map(function() {
                return this.value;
            }).get();

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

            // Show loading state with animation
            showLoadingState($button, $buttonText);

            $.ajax({
                url: '{{ route("pelanggan.checkout") }}',
                method: 'POST',
                data: {
                    produk_id: {{ $produk->id }},
                    ukuran_id: ukuranId || null,
                    warna_id: warnaId || null,
                    jumlah: jumlah,
                    kode_warna: kodeWarna,
                    pre_order: true,
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
        })

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

    </script>

    <script>
        // Function untuk mengganti gambar utama
        function changeMainImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }

        // Initialize galeri jika ada
        $(document).ready(function() {
            @if($produk->fotoProduk && $produk->fotoProduk->count() > 0)
                $('.product__details__pic__slider').owlCarousel({
                    loop: false,
                    margin: 10,
                    nav: true,
                    dots: false,
                    responsive: {
                        0: {
                            items: 3
                        },
                        600: {
                            items: 4
                        },
                        1000: {
                            items: 4
                        }
                    }
                });
            @endif
        });
    </script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('home/css/produkdetail.css') }}">
@endpush

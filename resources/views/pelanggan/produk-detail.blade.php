@php
    use Illuminate\Support\Str;
@endphp

@extends("layouts.guest")

@section("title", $produk->nama . " - Dame Ulos")

@push("styles")
    <link rel="stylesheet" href="{{ asset("home/css/app.css") }}">
@endpush

@section("content")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Detail Produk</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <a href="{{ route("pelanggan.katalog") }}">Katalog</a>
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
                        {{-- <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__pic__item">
                                <img src="{{ asset($produk->gambar ?? "images/no-image.png") }}" alt="{{ $produk->nama }}"
                                    id="mainImage">
                            </div>
                        </div> --}}
                        <div class="product__details__pic__slider owl-carousel mt-3">
                            <!-- Gambar utama sebagai slide pertama -->
                            <img src="{{ asset($produk->gambar ?? "images/no-image.png") }}" alt="{{ $produk->nama }}"
                                class="gallery-thumb"
                                onclick="changeMainImage('{{ asset($produk->gambar ?? "images/no-image.png") }}')">

                            <!-- Foto produk tambahan -->
                            @if ($produk->fotoProduk && $produk->fotoProduk->count() > 0)
                                @foreach ($produk->fotoProduk as $foto)
                                    <img src="{{ asset($foto->foto) }}" alt="Foto Produk {{ $loop->iteration }}"
                                        class="gallery-thumb" onclick="changeMainImage('{{ asset($foto->foto) }}')">
                                @endforeach
                            @endif

                            <!-- Video produk sebagai thumbnail -->
                            @if ($produk->videoProduk && $produk->videoProduk->count() > 0)
                                @foreach ($produk->videoProduk as $video)
                                    @php
                                        $youtubeId = null;
                                        if (!empty($video->link_video)) {
                                            preg_match("/(?:v=|youtu.be\/|embed\/)([\w-]+)/", $video->link_video, $matches);
                                            $youtubeId = $matches[1] ?? null;
                                        }
                                    @endphp
                                    @if ($youtubeId)
                                        <img src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg"
                                            alt="Video Produk {{ $loop->iteration }}" class="gallery-thumb video-thumb"
                                            onclick="changeMainVideo('{{ $youtubeId }}')">
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!-- Tempat gambar utama/video utama -->
                        <div class="tab-pane active mt-3" id="tabs-1" role="tabpanel">
                            <div class="product__details__pic__item" id="mainMediaContainer">
                                <img src="{{ asset($produk->gambar ?? "images/no-image.png") }}" alt="{{ $produk->nama }}"
                                    id="mainImage">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="product__details__text">
                            <h4>{{ $produk->nama }}</h4>
                            <h3>Rp {{ number_format($produk->harga, 0, ",", ".") }}</h3>
                            <p>{{ $produk->deskripsi }}</p>

                            @if (isset($produk->ukuran) && $produk->ukuran->count() > 0)
                                <div class="product__details__option">
                                    <div class="product__details__option__size">
                                        <span>Ukuran tersedia:</span>
                                        @foreach ($produk->ukuran as $ukuran)
                                            <label class="m-1" for="ukuran-{{ $ukuran->id }}">{{ $ukuran->ukuran }}
                                                <input type="radio" id="ukuran-{{ $ukuran->id }}" name="ukuran"
                                                    value="{{ $ukuran->id }}">
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (isset($produk->jenisWarnaProduk) && $produk->jenisWarnaProduk->count() > 0)
                                <div class="product__details__option">
                                    <div class="product__details__option__jenwarna">
                                        <span>Warna tersedia:</span>
                                        @foreach ($produk->jenisWarnaProduk as $warna)
                                            <label class="m-1" for="warna-{{ $warna->id }}">{{ $warna->warna }}
                                                <input type="radio" id="warna-{{ $warna->id }}" name="warna"
                                                    value="{{ $warna->id }}">
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (Auth::check())
                                <div class="product__details__cart__option">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1" id="jumlah" name="jumlah"
                                                min="1" max="{{ $produk->stok }}">
                                        </div>
                                    </div>
                                    <button id="checkout" class="primary-btn">
                                        <span class="btn-text">Beli Sekarang</span>
                                    </button>
                                    <button id="keranjang" class="primary-outline-btn"><i
                                            class="fa-solid fa-cart-plus"></i></button>
                                </div>
                                <div class="product__details__btns__option">
                                    <a href="{{ route("pelanggan.katalogBySlug", $produk->katalog->slug) }}">Kategori:
                                        <span>{{ $produk->katalog->nama }}</a>
                                    <p style="margin-top: 15px">Stok : {{ $produk->stok }}</p>
                                </div>
                                <div class="product__details__btns__option">
                                    <button class="primary-outline-btn" data-toggle="modal" data-target="#exampleModal"><i
                                            class="fa-solid fa-palette mr-2"></i>Request Warna ?</button>
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Silahkan login terlebih dahulu untuk melakukan pembelian.
                                </div>
                            @endif

                            @if (isset($produk->warnaProduk) && $produk->warnaProduk->count() > 0)
                                <div class="product__details__option__color">
                                    <span>Family Color:</span>
                                    @foreach ($produk->warnaProduk as $warna)
                                        <label style="background-color: #{{ $warna->kode_warna }}"
                                            for="kode-{{ $warna->id }}">
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
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                        role="tab">Deskripsi</a>
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
                                        @if ($ulasan && $ulasan->count() > 0)
                                            <!-- Rating Summary -->
                                            <div class="reviews-summary mb-4">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        <div class="rating-overview">
                                                            <h3 class="rating-score text-primary">
                                                                {{ number_format($produk->ulasan->avg("rating"), 1) }}/5
                                                            </h3>
                                                            <div class="stars mb-2">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= floor($produk->ulasan->avg("rating")))
                                                                        <i class="fa fa-star text-warning"></i>
                                                                    @elseif($i <= ceil($produk->ulasan->avg("rating")))
                                                                        <i class="fa fa-star-half-o text-warning"></i>
                                                                    @else
                                                                        <i class="fa fa-star-o text-muted"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <p class="text-muted">{{ $produk->ulasan->count() }} ulasan
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="rating-breakdown">
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                @php
                                                                    $count = $produk->ulasan
                                                                        ->where("rating", $i)
                                                                        ->count();
                                                                    $percentage =
                                                                        $produk->ulasan->count() > 0
                                                                            ? ($count / $produk->ulasan->count()) * 100
                                                                            : 0;
                                                                @endphp
                                                                <div class="rating-bar d-flex align-items-center mb-2">
                                                                    <span class="rating-label">{{ $i }}
                                                                        bintang</span>
                                                                    <div class="progress flex-grow-1 mx-3"
                                                                        style="height: 10px;">
                                                                        <div class="progress-bar bg-warning"
                                                                            style="width: {{ $percentage }}%"></div>
                                                                    </div>
                                                                    <span
                                                                        class="rating-count text-muted">{{ $count }}</span>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reviews List -->
                                            <div class="reviews-list">
                                                <h5 class="mb-4">Semua Ulasan</h5>
                                                @foreach ($ulasan as $review)
                                                    <div class="review-item border-bottom pb-4 mb-4">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="reviewer-info mb-2">
                                                                    <strong>{{ $review->user->name }}</strong>
                                                                    <div class="rating-stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="fa fa-star {{ $i <= $review->rating ? "text-warning" : "text-muted" }}"></i>
                                                                        @endfor
                                                                        <span
                                                                            class="text-muted ml-2">{{ $review->rating }}/5</span>
                                                                    </div>
                                                                    <small
                                                                        class="text-muted">{{ $review->created_at->format("d M Y, H:i") }}</small>
                                                                    @if ($review->updated_at != $review->created_at)
                                                                        <small class="text-muted">(diedit)</small>
                                                                    @endif
                                                                </div>
                                                                <p class="review-text">{{ $review->ulasan }}</p>
                                                            </div>
                                                            <div class="col-md-4 text-right">
                                                                @auth
                                                                    @if ($review->user_id == Auth::id())
                                                                        <div class="review-actions">
                                                                            <a href="{{ route("pelanggan.ulasan.edit", $review) }}"
                                                                                class="btn btn-outline-warning btn-sm">
                                                                                <i class="fa fa-edit"></i> Edit
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger btn-sm"
                                                                                onclick="confirmDeleteReview({{ $review->id }})">
                                                                                <i class="fa fa-trash"></i> Hapus
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                @endauth
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <!-- Pagination -->
                                                @if ($ulasan->hasPages())
                                                    <div class="d-flex justify-content-center">
                                                        {{ $ulasan->appends(request()->query())->fragment("tabs-7")->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fa fa-star-o fa-3x text-muted mb-3"></i>
                                                <p class="note text-muted">Belum ada ulasan untuk produk ini.</p>
                                                <p class="text-muted">Jadilah yang pertama memberikan ulasan!</p>
                                            </div>
                                        @endif
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
                            <div class="product__item__pic"
                                style="height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <img src="{{ asset($terkait->gambar) }}" alt="{{ $terkait->nama }}"
                                    style="max-width: 100%; max-height: 100%; object-fit: cover;">
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $terkait->nama }}</h6>
                                <a href="{{ route("pelanggan.produkBySlug", $terkait->slug) }}" class="add-cart">Lihat
                                    Detail</a>
                                <h5>Rp {{ number_format($terkait->harga, 0, ",", ".") }}</h5>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Warna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3"
                        style="border-left: 4px solid #ffc107; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-clock fa-2x text-warning mr-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1 font-weight-bold">
                                    <i class="fa fa-info-circle"></i> Pre-Order
                                </h6>
                                <p class="mb-0 small">
                                    Pesanan ini merupakan item <strong>pre-order</strong> dengan kostume warna.
                                    Estimasi pengerjaan <strong>7-14 hari kerja</strong> setelah pembayaran dikonfirmasi.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="colorContainer">
                        <div class="color-item" data-index="0">
                            @foreach ($produk->warnaProduk as $warna)
                                <div class="form-group">
                                    <label for="colorPicker_{{ $loop->index }}">Pilih Warna
                                        {{ $loop->iteration }}:</label>
                                    <div class="input-group">
                                        <input type="color" name="warna_custom[]" id="colorPicker_{{ $loop->index }}"
                                            class="form-control color-picker" value="#{{ $warna->kode_warna }}">
                                    </div>
                                    {{-- <small class="form-text text-muted">Kode Hex: <span class="hex-value">#{{ $warna->kode_warna }}</span></small> --}}
                                </div>
                            @endforeach
                        </div>
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

    <!-- Delete Review Confirmation Modal -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReviewModalLabel">Konfirmasi Hapus Ulasan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteReviewForm" method="POST" style="display: inline;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">Hapus Ulasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Request Warna -->
@endsection

@push("scripts")
    <script src="{{ asset("home/js/ProdukDetail.js") }}"></script>
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

        $('#keranjang').on('click', function(e) {
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
            const mainMediaContainer = document.getElementById('mainMediaContainer');
            mainMediaContainer.innerHTML = `<img src="${imageSrc}" alt="Gambar Produk" id="mainImage">`;
        }

        // Function untuk mengganti ke video utama
        function changeMainVideo(youtubeId) {
            const mainMediaContainer = document.getElementById('mainMediaContainer');
            mainMediaContainer.innerHTML =
                `<div class='embed-responsive embed-responsive-16by9 rounded shadow-sm'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/${youtubeId}?autoplay=1' allowfullscreen></iframe></div>`;
        }

        // Initialize galeri jika ada
        $(document).ready(function() {
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
        });
    </script>

    <script>
        // Function untuk konfirmasi hapus ulasan
        function confirmDeleteReview(reviewId) {
            $('#deleteReviewForm').attr('action', `/ulasan/${reviewId}`);
            $('#deleteReviewModal').modal('show');
        }

        // Handle delete review form submission
        $('#deleteReviewForm').on('submit', function(e) {
            e.preventDefault();

            const form = this;
            const actionUrl = $(form).attr('action');

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    $('#deleteReviewModal').modal('hide');

                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Ulasan berhasil dihapus.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload page to refresh reviews
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Terjadi kesalahan saat menghapus ulasan.'
                        });
                    }
                },
                error: function(xhr) {
                    $('#deleteReviewModal').modal('hide');

                    let errorMessage = 'Terjadi kesalahan saat menghapus ulasan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
        });
    </script>
@endpush

@push("styles")
    <link rel="stylesheet" href="{{ asset("home/css/produkdetail.css") }}">
    <style>
        /* Reviews Styling */
        .reviews-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .rating-score {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stars {
            font-size: 1.5rem;
        }

        .rating-breakdown {
            padding-left: 20px;
        }

        .rating-bar {
            min-height: 30px;
        }

        .rating-label {
            width: 80px;
            font-size: 0.9rem;
        }

        .progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
        }

        .progress-bar {
            background-color: #ffc107 !important;
        }

        .rating-count {
            width: 30px;
            text-align: right;
            font-size: 0.9rem;
        }

        .review-item {
            padding: 20px 0;
        }

        .review-item:last-child {
            border-bottom: none !important;
        }

        .reviewer-info strong {
            color: #333;
            font-size: 1.1rem;
        }

        .rating-stars {
            margin: 5px 0;
        }

        .rating-stars .fa {
            font-size: 1rem;
        }

        .review-text {
            color: #555;
            line-height: 1.6;
            margin-top: 10px;
            font-size: 0.95rem;
        }

        .review-actions .btn {
            width: 80px;
            font-size: 0.85rem;
            padding: 5px 10px;
        }

        .review-actions .btn-outline-primary {
            color: #ca1515;
            border-color: #ca1515;
        }

        .review-actions .btn-outline-primary:hover {
            background-color: #ca1515;
            border-color: #ca1515;
        }

        .review-actions .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .text-primary {
            color: #ca1515 !important;
        }

        /* Empty state styling */
        .text-center.py-5 {
            padding: 3rem 0 !important;
        }

        .text-center.py-5 .fa-3x {
            font-size: 3rem !important;
        }

        /* Pagination styling */
        .pagination {
            justify-content: center;
        }

        .page-link {
            color: #ca1515;
            border-color: #dee2e6;
        }

        .page-link:hover {
            background-color: #ca1515;
            border-color: #ca1515;
            color: white;
        }

        .page-item.active .page-link {
            background-color: #ca1515;
            border-color: #ca1515;
        }
    </style>
@endpush

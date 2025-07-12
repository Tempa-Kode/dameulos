@extends('layouts.guest')

@section('title', $produk->nama . ' - Dame Ulos')

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
                                    <label for="ukuran-{{ $ukuran->id }}">{{ $ukuran->ukuran }}
                                        <input type="radio" id="ukuran-{{ $ukuran->id }}" name="ukuran" value="{{ $ukuran->id }}">
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(isset($produk->warna) && $produk->warna->count() > 0)
                            <div class="product__details__option">
                                <div class="product__details__option__color">
                                    <span>Warna tersedia:</span>
                                    @foreach($produk->warna as $warna)
                                    <label style="background: {{ $warna->kode_warna }};" for="warna-{{ $warna->id }}">
                                        <input type="radio" id="warna-{{ $warna->id }}" name="warna" value="{{ $warna->id }}">
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" id="jumlah">
                                    </div>
                                </div>
                                <a href="#" class="primary-btn">Tambahkan ke Keranjang</a>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="{{ route('pelanggan.katalogBySlug', $produk->katalog->slug) }}">Kategori: <span>{{ $produk->katalog->nama }}</a>
                            </div>
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

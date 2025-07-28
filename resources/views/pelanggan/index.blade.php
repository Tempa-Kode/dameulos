@extends('layouts.guest')
@section('title', 'Galeri Dame Ulos')

@section('content')

    @include('components.hero')

    <!-- Best Selling Products Section Begin -->
    <section class="product spad py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Produk Terlaris</span>
                        <h2>Produk Paling Diminati</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-around">
                @forelse($produkTerlaris as $item)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item card p-3">
                            <div class="product__item__pic" style="height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <div class="product__label">
                                <span class="sale">Terlaris</span>
                                 </div>
                                <img src="{{ asset($item->gambar ?? 'images/no-image.png') }}" alt="{{ $item->nama }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $item->nama }}</h6>
                                <a href="{{ route('pelanggan.produkBySlug', $item->slug) }}" class="add-cart">
                                    Lihat Detail
                                </a>
                                <h5>Rp {{ number_format($item->harga, 0, ',', '.') }}</h5>
                                <span class="badge badge-light">{{ $item->katalog->nama ?? 'Tidak ada kategori' }}</span>
                            </div>
                            <span class="badge badge-secondary">Stok : {{ $item->stok ?? 'Stok kosong' }}</span>
                            <a href="{{ route('pelanggan.produkBySlug', $item->slug) }}" class="primary-btn text-center">Beli Sekarang</a>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <div class="text-center">
                            <img src="{{ asset('images/no-products.png') }}" alt="No Products" style="width: 200px; opacity: 0.5;">
                            <h5 class="mt-3 text-muted">Belum ada produk terlaris</h5>
                            <p class="text-muted">Produk akan muncul setelah ada transaksi yang selesai</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Best Selling Products Section End -->

    {{-- Produk --}}
    <section id="produk-section" class="product spad py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Semua Produk</span>
                        <h2>Produk Lengkap Yang Ditawarkan</h2>
                    </div>
                </div>
                <div class="col-12">
                    <form action="#produk-section" method="get">
                        @method('GET')
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 w-100 gap-3 p-3 rounded shadow-sm" style="background: #fff;">
                            <div class="input-group" style="max-width: 350px;">
                                <span class="input-group-text bg-white border-end-0" style="font-size: 1.2rem;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="cari" id="cari" class="form-control border-start-0" placeholder="Cari produk..." value="{{ request('cari') }}">
                            </div>
                            <div class="d-flex align-items-center gap-2" style="min-width: 320px;">
                                <label for="kategori" class="mb-0 me-2 text-muted" style="font-weight: 500;">
                                    <i class="fas fa-filter me-1"></i> Kategori
                                </label>
                                <select name="kategori" id="kategori" class="form-select w-50" onchange="this.form.submit()">
                                    <option value="" selected hidden>Pilih Kategori </option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->slug }}" {{ request('kategori') == $k->slug ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @forelse($produk as $item)
                <div class="col">
                    <div class="product__item card p-3">
                        <div class="product__item__pic" style="height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                            <img src="{{ asset($item->gambar ?? 'images/no-image.png') }}" alt="{{ $item->nama ?? 'gambar' }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $item->nama ?? 'title' }}</h6>
                            <a href="{{ route('pelanggan.produkBySlug', $item->slug ?? '1') }}" class="add-cart">
                                Lihat Detail
                            </a>
                            <h5>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</h5>
                            <span class="badge badge-light">{{ $item->katalog->nama ?? 'Tidak ada kategori' }}</span>
                        </div>
                        <span class="badge badge-secondary">Stok : {{ $item->stok ?? 'Stok kosong' }}</span>
                        <a href="{{ route('pelanggan.produkBySlug', $item->slug) }}" class="primary-btn text-center">Beli Sekarang</a>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="text-center">
                        <img src="{{ asset('images/no-products.png') }}" alt="No Products" style="width: 200px; opacity: 0.5;">
                        <h5 class="mt-3 text-muted">Belum ada produk tersedia</h5>
                        <p class="text-muted">Produk akan segera ditambahkan</p>
                    </div>
                </div>
            @endforelse
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="shop__product__option__left">
                        <p>Menampilkan {{ $produk->firstItem() }}–{{ $produk->lastItem() }} dari {{ $produk->total() }} hasil</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__pagination">
                        @if ($produk->onFirstPage())
                            <a class="active" href="{{ $produk->url(1) }}">1</a>
                        @endif

                        @foreach ($produk->links()->elements[0] as $page => $url)
                            @if ($page != 1 || !$produk->onFirstPage())
                                <a class="{{ $page == $produk->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($produk->hasMorePages())
                            <a href="{{ $produk->nextPageUrl() }}">Next</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Produk --}}
@endsection

@push('styles')
<style>
    .product {
        background: #f8f9fa;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title span {
        color: #ca1515;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 14px;
    }

    .section-title h2 {
        color: #333;
        font-size: 2.5rem;
        margin-top: 10px;
        font-weight: 600;
    }

    .product__item {
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .product__item:hover {
        transform: translateY(-5px);
    }

    .product__item__pic {
        position: relative;
        height: 250px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .product__label {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }

    .product__label .sale {
        background: #ca1515;
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .product__hover {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        list-style: none;
        margin: 0;
        padding: 0;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product__item__pic:hover .product__hover {
        opacity: 1;
    }

    .product__hover li {
        display: inline-block;
        margin: 0 5px;
    }

    .product__hover li a {
        display: block;
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        text-align: center;
        line-height: 45px;
        color: #333;
        transition: all 0.3s ease;
    }

    .product__hover li a:hover {
        background: #ca1515;
        color: white;
        transform: scale(1.1);
    }

    .product__item__text h6 {
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: 600;
    }

    .product__item__text h6 a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product__item__text h6 a:hover {
        color: #ca1515;
    }

    .rating {
        margin-bottom: 10px;
    }

    .rating i {
        color: #ffc107;
        font-size: 14px;
        margin-right: 2px;
    }

    .product__price {
        font-size: 18px;
        font-weight: 600;
        color: #ca1515;
        margin-bottom: 8px;
    }

    .product__sold {
        font-size: 12px;
        color: #666;
    }

    .product__sold small {
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 500;
    }

    /* Empty state styling */
    .text-center img {
        filter: grayscale(1);
        opacity: 0.3;
    }

    @media (max-width: 991px) {
        .section-title h2 {
            font-size: 2rem;
        }

        .product__item__pic {
            height: 200px;
        }
    }

    @media (max-width: 767px) {
        .section-title h2 {
            font-size: 1.8rem;
        }

        .product__item__pic {
            height: 180px;
        }

        .product__hover li a {
            width: 40px;
            height: 40px;
            line-height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Set background images for product items
    $(document).ready(function() {
        $('.set-bg').each(function() {
            var bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
        });
    });
</script>
@endpush

@extends('layouts.guest')

@section('title', 'Katalog Dame Ulos')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Katalog</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('pelanggan.home') }}">Home</a>
                            <span>Katalog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="{{ route('pelanggan.katalog') }}" method="GET">
                                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Kategori</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach ($kategori as $k)
                                                    <li><a href="{{ route('pelanggan.katalogBySlug', $k->slug) }}">{{ $k->nama }} ({{ $k->produk_count }})</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        @if (request('search'))
                            <p>Menampilkan hasil untuk: "{{ request('search') }}"</p>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Menampilkan {{ $produk->firstItem() }}–{{ $produk->lastItem() }} dari {{ $produk->total() }} hasil</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($produk as $item)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic" style="height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $item->nama }}</h6>
                                    <a href="#" class="add-cart">
                                        Lihat Detail
                                    </a>
                                    <h5>Rp {{ number_format($item->harga, 0, ',', '.') }}</h5>
                                    <span class="badge badge-light">{{ $item->katalog->nama }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-12">
                            <div class="alert alert-warning text-center">
                                <strong>Maaf!</strong> Produk tidak ditemukan.
                            </div>
                        @endforelse
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
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection

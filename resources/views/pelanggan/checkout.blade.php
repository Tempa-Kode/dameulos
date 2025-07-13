@extends('layouts.guest')

@section('title', 'Checkout - Dame Ulos')
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
    </style>
@endpush
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Checkout</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('pelanggan.home') }}">Home</a>
                            <a href="{{ route('pelanggan.katalog') }}">Katalog</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                @include('components.alert')

                <form action="#">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="checkout__title">Detail Pengiriman</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nama Depan<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nama Belakang<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Alamat<span>*</span></p>
                                <input type="text" class="checkout__input__add">
                            </div>
                            <div class="checkout__input">
                                <p>Kabupaten/Kota<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Kecamatan<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Kode Pos<span>*</span></p>
                                <input type="text">
                            </div>
                            <button class="primary-outline-btn w-100">
                                <i class="fa-solid fa-truck-fast mr-2"></i>Cek Ongkir
                            </button>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>No Handphone<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Catatan Pesanan</p>
                                <input type="text"
                                placeholder="Contoh: Mohon bungkus dengan rapi (optional)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title text-center">Pesanan Anda</h4>
                                <div class="checkout__order__products">Produk <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach($checkoutData as $item)
                                        <div class="checkout__order__product d-flex justify-content-between align-items-start p-3 mb-3 border-bottom">
                                            <div class="checkout__order__product__info flex-grow-1">
                                                <h6 class="mb-2 font-weight-bold">{{ $item['produk']->nama }}</h6>
                                                <div class="product-details">
                                                    <p class="text-muted mb-1 small">Uk :{{ $item['ukuran']->ukuran }}</p>
                                                    <p class="text-muted mb-1 small">{{ $item['warna']->warna }}</p>
                                                    <p class="text-muted mb-1 small">x{{ $item['jumlah'] }}</p>
                                                    <p class="text-muted mb-0 small">Harga Satuan: Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <div class="product-price text-right">
                                                <strong class="text-primary">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span>Rp {{ number_format($totalHarga, 0, ',', '.') }} </span></li>
                                    <li>Ongkir <span id="ongkir">-</span></li>
                                    <li>Total <span>Rp <span id="grandTotal">{{ number_format($grandTotal, 0, ',', '.') }}</span></span></li>
                                </ul>
                                <button type="submit" class="site-btn w-100">Lakukan Pembayaran</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection

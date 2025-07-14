@extends('layouts.guest')

@section('title', 'Checkout Berhasil - Dame Ulos')

@push('styles')
    <style>
        .checkout-success {
            text-align: center;
            padding: 50px 0;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .success-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin: 30px 0;
            text-align: left;
        }

        .order-details h4 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-info:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 18px;
            color: #ca1515;
        }

        .order-products {
            margin-top: 20px;
        }

        .order-product {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-product:last-child {
            border-bottom: none;
        }

        .order-product img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        .order-product-info {
            flex: 1;
        }

        .order-product-info h6 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .order-product-info span {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 2px;
        }

        .order-product-price {
            font-size: 16px;
            font-weight: 600;
            color: #ca1515;
        }

        .action-buttons {
            margin-top: 30px;
        }

        .btn-primary {
            background: #ca1515;
            border-color: #ca1515;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 5px;
            margin: 0 10px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #b11212;
            border-color: #b11212;
            color: #ffffff;
            text-decoration: none;
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid #ca1515;
            color: #ca1515;
            padding: 10px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 5px;
            margin: 0 10px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #ca1515;
            color: #ffffff;
            text-decoration: none;
        }

        .payment-info {
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .payment-info h5 {
            color: #004085;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .payment-info p {
            color: #004085;
            margin-bottom: 8px;
        }

        .payment-info strong {
            color: #002752;
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
                        <h4>Checkout Berhasil</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('pelanggan.home') }}">Home</a>
                            <a href="{{ route('pelanggan.katalog') }}">Katalog</a>
                            <span>Checkout Berhasil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Success Section Begin -->
    <section class="checkout-success spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-success">
                        <div class="success-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>

                        <h2 class="success-title">Pesanan Berhasil Dibuat!</h2>

                        <p class="success-message">
                            Terima kasih telah berbelanja di Dame Ulos. Pesanan Anda telah berhasil diproses.<br>
                            Lakukan pembayaran agar pesanan Anda segera diproses.
                        </p>

                        <div class="order-details">
                            <h4>Detail Pesanan</h4>

                            <div class="order-info">
                                <span>No. Transaksi:</span>
                                <span><strong>{{ $transaksi->kode_transaksi }}</strong></span>
                            </div>

                            <div class="order-info">
                                <span>Alamat Pengiriman :</span>
                                <span><strong>{{ $transaksi->alamat_pengiriman }}</strong></span>
                            </div>

                            <div class="order-info">
                                <span>Tanggal Pesanan:</span>
                                <span>{{ $transaksi->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <div class="order-info">
                                <span>Status Pesanan:</span>
                                <span class="badge badge-warning">{{ ucfirst($transaksi->status) }}</span>
                            </div>

                            <div class="order-products">
                                <h5>Produk yang Dipesan:</h5>
                                @foreach($transaksi->detailTransaksi as $detail)
                                    <div class="order-product">
                                        <img src="{{ asset($detail->produk->gambar) }}" alt="{{ $detail->produk->nama }}">
                                        <div class="order-product-info">
                                            <h6>{{ $detail->produk->nama }}</h6>
                                            <span>Ukuran: {{ $detail->ukuranProduk->ukuran }}</span>
                                            <span>Warna: {{ $detail->jenisWarnaProduk->warna }}</span>
                                            <span>Satuan: Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                                            <span>Jumlah: {{ $detail->jumlah }}</span>
                                        </div>
                                        <div class="order-product-price">
                                            Rp {{ number_format($detail->total_harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="order-info">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="order-info">
                                <span>Ongkos Kirim:</span>
                                <span>Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                            </div>

                            <div class="order-info">
                                <span>Total Pembayaran:</span>
                                <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('pelanggan.katalog') }}" class="btn-outline-primary">
                                <i class="fa fa-shopping-bag"></i> Lanjut Belanja
                            </a>
                            @if ($transaksi->status == 'pending')
                            <button id="bayar" class="primary-btn">
                                <i class="fa-solid fa-money-bill-wave mr-2"></i>Bayar
                            </button>
                            @endif
                            <a href="{{ route('pelanggan.home') }}" class="btn-primary">
                                <i class="fa fa-home"></i> Kembali ke Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Success Section End -->
@endsection

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

        .payment-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            text-align: left;
            border: 2px solid #ca1515;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-container h4 {
            color: #ca1515;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }

        #snap-container {
            min-height: 400px;
            width: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #order-details-col {
                margin-bottom: 30px;
            }

            .payment-container {
                margin-top: 20px;
            }
        }

        /* Animation for smooth transition */
        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
                <div class="col-lg-12">
                    <div class="checkout-success">
                        <div class="success-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>

                        <h2 class="success-title">Pesanan Berhasil Dibuat!</h2>

                        <p class="success-message">
                            Terima kasih telah berbelanja di Dame Ulos. Pesanan Anda telah berhasil diproses.<br>
                            Lakukan pembayaran agar pesanan Anda segera diproses.
                        </p>

                        <!-- Main Content Row -->
                        <div class="row">
                            <!-- Order Details Column -->
                            <div class="col-lg-12" id="order-details-col">
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
                                                    <span>Ukuran: {{ $detail->ukuranProduk->ukuran ?? '-' }}</span>
                                                    <span>Warna: {{ $detail->jenisWarnaProduk->warna ?? '-' }}</span>
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
                            </div>

                            <!-- Payment Container Column -->
                            <div class="col-lg-4" id="payment-col" style="display: none;">
                                <div class="payment-container">
                                    <h4>Pembayaran</h4>
                                    <div id="snap-container"></div>
                                </div>
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

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script type="text/javascript" >
        $('#bayar').click(function (event) {
            event.preventDefault();

            // Show payment column and adjust layout
            $('#payment-col').show().addClass('slide-in');
            $('#order-details-col').removeClass('col-lg-12').addClass('col-lg-8');

            // Change button text to loading state
            const button = $(this);
            const originalText = button.html();
            button.html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
            button.prop('disabled', true);

            const transaksiId = {{ $transaksi->id }};
            const kodeTransaksi = "{{ $transaksi->kode_transaksi }}";
            const totalPembayaran = {{ $transaksi->total }};

            console.table({
                transaksiId: transaksiId,
                kodeTransaksi: kodeTransaksi,
                totalPembayaran: totalPembayaran
            });

            $.post("{{ route('pembayaran') }}", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                transaksi_id: transaksiId,
                kode_transaksi: kodeTransaksi,
                total_pembayaran: totalPembayaran,
            },
            function (data, status) {
                // Reset button state
                button.html(originalText);
                button.prop('disabled', false);
                console.log('Payment data:', data);

                if(data.snap_token.snap_token){
                    // Initialize Snap payment in the container
                    window.snap.embed(data.snap_token.snap_token, {
                        embedId: 'snap-container',
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            Swal.fire({
                                title: "Pembayaran Berhasil!",
                                text: "Terima kasih, pembayaran Anda telah berhasil diproses.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('pelanggan.transaksi') }}";
                                }
                            });
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            Swal.fire({
                                title: "Pembayaran Tertunda",
                                text: "Pembayaran Anda sedang diproses. Silakan cek status pembayaran secara berkala.",
                                icon: "info",
                                confirmButtonText: "OK"
                            });
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            Swal.fire({
                                title: "Pembayaran Gagal",
                                text: "Terjadi kesalahan saat memproses pembayaran.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Pembayaran Gagal",
                        text: "Terjadi kesalahan saat memproses pembayaran.",
                        icon: "error",
                    });

                    // Hide payment column if error
                    $('#payment-col').hide();
                    $('#order-details-col').removeClass('col-lg-8').addClass('col-lg-12');
                }
            })
            .fail(function() {
                // Reset button state
                button.html(originalText);
                button.prop('disabled', false);

                Swal.fire({
                    title: "Pembayaran Gagal",
                    text: "Terjadi kesalahan saat menghubungi server pembayaran.",
                    icon: "error",
                });

                // Hide payment column if error
                $('#payment-col').hide();
                $('#order-details-col').removeClass('col-lg-8').addClass('col-lg-12');
            });
        });
    </script>
@endpush

@extends('layouts.guest')

@section('title', 'Checkout - Dame Ulos')

@push('styles')
    <style>
        .checkout__form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .checkout__order {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .checkout__order__products {
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .checkout__order__product {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .checkout__order__product img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .checkout__order__product__info {
            flex: 1;
            margin-left: 15px;
        }

        .checkout__order__product__info h6 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .checkout__order__product__info span {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 2px;
        }

        .checkout__order__product__info span {
            font-size: 12px;
            color: #666;
        }

        .checkout__order__subtotal {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .checkout__order__total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 18px;
            color: #ca1515;
            border-top: 2px solid #e1e1e1;
            padding-top: 15px;
        }

        .checkout__input {
            margin-bottom: 20px;
        }

        .checkout__input p {
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .checkout__input input,
        .checkout__input select,
        .checkout__input textarea {
            width: 100%;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            padding: 12px 15px;
            font-size: 14px;
        }

        .checkout__input textarea {
            resize: vertical;
            min-height: 100px;
        }

        .payment-methods {
            margin-top: 20px;
        }

        .payment-method {
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #ca1515;
        }

        .payment-method.active {
            border-color: #ca1515;
            background-color: #fff5f5;
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .site-btn {
            background: #ca1515;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        /* Submit button loading states */
        .site-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .site-btn.btn-loading {
            pointer-events: none;
        }

        .site-btn.btn-loading::before {
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

        .site-btn.btn-loading.with-text::before {
            left: 25px;
            margin-left: 0;
        }

        .site-btn.btn-loading .btn-text {
            padding-left: 35px;
        }

        .site-btn.btn-loading.shimmer {
            background: linear-gradient(90deg, #ca1515 25%, #e53e3e 50%, #ca1515 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
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

        .site-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(202, 21, 21, 0.3);
        }

        .site-btn:active:not(:disabled) {
            transform: translateY(0);
            transition: all 0.1s ease;
        }

        .product-quantity {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .pro-qty {
            display: flex;
            align-items: center;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            overflow: hidden;
        }

        .pro-qty input {
            width: 50px;
            text-align: center;
            border: none;
            padding: 8px;
            font-size: 14px;
        }

        .pro-qty .qtybtn {
            background: #f8f9fa;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            color: #666;
            transition: all 0.3s ease;
        }

        .pro-qty .qtybtn:hover {
            background: #e9ecef;
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

                <form action="{{ route('pelanggan.checkout.process') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Detail Pengiriman</h6>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nama Depan<span>*</span></p>
                                        <input type="text" name="nama_depan" value="{{ old('nama_depan') }}" required>
                                        @error('nama_depan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nama Belakang<span>*</span></p>
                                        <input type="text" name="nama_belakang" value="{{ old('nama_belakang') }}" required>
                                        @error('nama_belakang')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="checkout__input">
                                <p>No. Telepon<span>*</span></p>
                                <input type="tel" name="telepon" value="{{ old('telepon') }}" required>
                                @error('telepon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="checkout__input">
                                <p>Alamat Lengkap<span>*</span></p>
                                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Jalan, No. Rumah, RT/RW" required>
                                @error('alamat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Kota<span>*</span></p>
                                        <input type="text" name="kota" value="{{ old('kota') }}" required>
                                        @error('kota')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Kode Pos<span>*</span></p>
                                        <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" required>
                                        @error('kode_pos')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Catatan Tambahan (Opsional)</p>
                                <textarea name="catatan" placeholder="Catatan khusus untuk pesanan Anda">{{ old('catatan') }}</textarea>
                            </div>

                            <h6 class="checkout__title">Metode Pembayaran</h6>
                            <div class="payment-methods">
                                <div class="payment-method" onclick="selectPayment('transfer')">
                                    <input type="radio" name="metode_pembayaran" value="transfer" id="transfer" required>
                                    <label for="transfer">
                                        <strong>Transfer Bank</strong>
                                        <p class="mb-0">Bayar melalui transfer bank ke rekening kami</p>
                                    </label>
                                </div>
                                <div class="payment-method" onclick="selectPayment('cod')">
                                    <input type="radio" name="metode_pembayaran" value="cod" id="cod" required>
                                    <label for="cod">
                                        <strong>Cash on Delivery (COD)</strong>
                                        <p class="mb-0">Bayar saat barang diterima</p>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Pesanan Anda</h4>

                                <div class="checkout__order__products">
                                    @foreach($checkoutData as $item)
                                        <div class="checkout__order__product">
                                            <div class="checkout__order__product__info">
                                                <h6>{{ $item['produk']->nama }}</h6>
                                                <span>{{ $item['ukuran']->ukuran }}</span>
                                                <span>{{ $item['warna']->warna }}</span>
                                                <span>Jumlah: {{ $item['jumlah'] }}</span>
                                                <span>@ Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</span>
                                            </div>
                                            <div class="product-price ml-2">
                                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="checkout__order__subtotal">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>

                                <div class="checkout__order__subtotal">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                                </div>

                                <div class="checkout__order__total">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>

                                <!-- Hidden inputs for product data -->
                                {{-- <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="ukuran_id" value="{{ request('ukuran_id') }}">
                                <input type="hidden" name="warna_id" value="{{ request('warna_id') }}">
                                <input type="hidden" name="harga" value="{{ $produk->harga }}">
                                <input type="hidden" name="ongkir" value="15000"> --}}

                                <button type="submit" class="site-btn" id="submit-order">
                                    <span class="btn-text">Buat Pesanan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    @push('scripts')
    <script>
        function selectPayment(method) {
            // Remove active class from all payment methods
            document.querySelectorAll('.payment-method').forEach(function(el) {
                el.classList.remove('active');
            });

            // Add active class to selected method
            document.querySelector(`input[value="${method}"]`).closest('.payment-method').classList.add('active');

            // Check the radio button
            document.querySelector(`input[value="${method}"]`).checked = true;
        }

        // Form validation and loading
        document.querySelector('form').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                showValidationAlert('Silakan pilih metode pembayaran');
                return false;
            }

            // Show loading state on submit button
            const submitBtn = e.target.querySelector('#submit-order');
            const buttonText = submitBtn.querySelector('.btn-text');

            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading', 'shimmer', 'with-text');
            buttonText.textContent = 'Memproses Pesanan...';

            // Add loading overlay
            showLoadingOverlay();
        });

        function showValidationAlert(message) {
            // Create custom alert for validation errors
            const alertHtml = `
                <div class="validation-alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
                    <div style="background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 20px rgba(238, 90, 82, 0.3); display: flex; align-items: center; animation: slideInRight 0.3s ease;">
                        <i class="fa fa-exclamation-triangle" style="margin-right: 10px; font-size: 18px;"></i>
                        <span style="font-weight: 500; font-size: 14px;">${message}</span>
                    </div>
                </div>
            `;

            if (!document.querySelector('.validation-alert')) {
                document.body.insertAdjacentHTML('beforeend', alertHtml);

                setTimeout(() => {
                    const alert = document.querySelector('.validation-alert');
                    if (alert) {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateX(100%)';
                        alert.style.transition = 'all 0.3s ease';
                        setTimeout(() => alert.remove(), 300);
                    }
                }, 3000);
            }
        }

        function showLoadingOverlay() {
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.2);
                z-index: 9998;
                display: flex;
                justify-content: center;
                align-items: center;
            `;

            overlay.innerHTML = `
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); text-align: center;">
                    <div style="width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #ca1515; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 15px;"></div>
                    <p style="margin: 0; font-weight: 500; color: #333;">Memproses pesanan Anda...</p>
                </div>
            `;

            document.body.appendChild(overlay);
        }
    </script>
    @endpush
@endsection

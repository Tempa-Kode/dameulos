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

        .checkout__payment {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            background: #f8f9fa;
        }

        .checkout__payment__method {
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            background: white;
            transition: all 0.3s ease;
        }

        .checkout__payment__method:hover {
            border-color: #7fad39;
            box-shadow: 0 2px 5px rgba(127, 173, 57, 0.1);
        }

        .checkout__payment__method input[type="radio"] {
            margin-right: 10px;
        }

        .checkout__payment__method label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin: 0;
            font-weight: 500;
        }

        .checkout__payment__method .payment-icon {
            font-size: 18px;
            margin-right: 8px;
        }

        .checkout__payment__method input[type="radio"]:checked + label {
            color: #7fad39;
        }

        .checkout__payment__method input[type="radio"]:checked + label .payment-icon {
            filter: grayscale(0);
        }

        #checkout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Select2 Styling */
        .select2-container {
            width: 100% !important;
        }

        .select2-selection--single {
            height: 50px !important;
            border: 1px solid #e1e1e1 !important;
            border-radius: 0 !important;
            padding: 0 15px !important;
            font-size: 14px !important;
            background: white !important;
        }

        .select2-selection__rendered {
            line-height: 48px !important;
            color: #333 !important;
        }

        .select2-selection__placeholder {
            color: #999 !important;
        }

        .select2-selection__arrow {
            height: 48px !important;
            top: 1px !important;
            right: 10px !important;
        }

        .select2-dropdown {
            border: 1px solid #e1e1e1 !important;
            border-radius: 0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #e1e1e1 !important;
            border-radius: 0 !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
        }

        .select2-results__option {
            padding: 10px 15px !important;
            font-size: 14px !important;
            border-bottom: 1px solid #f5f5f5 !important;
        }

        .select2-results__option--highlighted {
            background-color: #7fad39 !important;
            color: white !important;
        }

        .select2-results__option--selected {
            background-color: #f8f9fa !important;
            color: #333 !important;
        }

        .select2-result-item__title {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .select2-result-item__description {
            font-size: 12px;
            color: #666;
        }

        .select2-results__option--highlighted .select2-result-item__title,
        .select2-results__option--highlighted .select2-result-item__description {
            color: white;
        }

        .select2-selection--single:focus {
            border-color: #7fad39 !important;
            outline: none !important;
        }

        /* Ongkir Options Styling */
        .ongkir-options {
            margin-top: 8px;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }

        .ongkir-option {
            display: block;
            padding: 4px 0;
            transition: color 0.3s ease;
        }

        .ongkir-option:hover {
            color: #7fad39 !important;
        }

        .ongkir-option.selected {
            font-weight: 600;
        }

        #ongkir {
            position: relative;
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

                <form id="checkout-form" action="{{ route('pelanggan.checkout.process') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="checkout__title">Detail Pengiriman</h6>
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkout__input">
                                        <p>Nama Depan<span>*</span></p>
                                        <input type="text" name="nama_depan" value="{{ old('nama_depan', Auth::user()->name) }}" readonly required>
                                        @error('nama_depan')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Alamat<span>*</span></p>
                                <select name="destination" id="destination" class="form-control d-none" style="width: 100%">
                                    <option value="">Cari tujuan domestik...</option>
                                </select>
                                <input type="text" name="alamat" placeholder="alamat lengkap (cth : Jl. Setia Budi)" required>
                            </div>
                            <div class="checkout__input" style="margin-top: 10px;">
                                <p>Provinsi<span>*</span></p>
                                <input type="text" name="provinsi" id="province_name" value="{{ old('provinsi') }}" required>
                                @error('provinsi')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="checkout__input">
                                <p>Kabupaten/Kota<span>*</span></p>
                                <input type="text" name="kota" id="city_name" value="{{ old('kota') }}" required>
                                @error('kota')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="checkout__input">
                                <p>Kode Pos<span>*</span></p>
                                <input type="text" name="kode_pos" id="zip_code" value="{{ old('kode_pos') }}" required>
                                @error('kode_pos')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>No Handphone<span>*</span></p>
                                        <input type="text" name="telepon" value="{{ old('telepon') }}" required>
                                        @error('telepon')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Catatan Pesanan</p>
                                <input type="text" name="catatan" placeholder="Contoh: Mohon bungkus dengan rapi (optional)" value="{{ old('catatan') }}">
                                @error('catatan')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
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
                                    <li id="ongkir">Ongkir <span>-</span></li>
                                    <li>Total <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span></li>
                                </ul>

                                <!-- Hidden inputs for shipping -->
                                <input type="hidden" name="ongkir_cost" id="ongkir_cost" value="0">
                                <input type="hidden" name="ongkir_service" id="ongkir_service" value="">
                                <input type="hidden" name="destination_id" id="destination_id" value="">

                                <!-- Payment Method Selection -->
                                <div class="checkout__payment">
                                    <h6 class="mb-3">Metode Pembayaran</h6>
                                    <div class="checkout__payment__methods">
                                        <div class="checkout__payment__method">
                                            <input type="radio" id="transfer" name="metode_pembayaran" value="transfer" {{ old('metode_pembayaran', 'transfer') == 'transfer' ? 'checked' : '' }} required>
                                            <label for="transfer">
                                                <span class="payment-icon">💳</span>
                                                Transfer Bank
                                                <small class="d-block text-muted">Bayar melalui transfer bank</small>
                                            </label>
                                        </div>
                                        <div class="checkout__payment__method mt-2">
                                            <input type="radio" id="cod" name="metode_pembayaran" value="cod" {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}>
                                            <label for="cod">
                                                <span class="payment-icon">🚚</span>
                                                Cash on Delivery (COD)
                                                <small class="d-block text-muted">Bayar saat barang diterima</small>
                                            </label>
                                        </div>
                                    </div>
                                    @error('metode_pembayaran')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="site-btn w-100 mt-3" id="checkout-btn">
                                    <span class="btn-text">Lakukan Pembayaran</span>
                                    <span class="btn-loading d-none">
                                        <i class="fa fa-spinner fa-spin"></i> Memproses...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#destination').select2({
                placeholder: 'Cari tujuan domestik...',
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route("proxy.destination") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.label,
                                    city_name: item.city_name,
                                    province_name: item.province_name,
                                    zip_code: item.zip_code
                                };
                            }),
                            pagination: {
                                more: data.data.length === 10
                            }
                        };
                    },
                    cache: true
                }
            });

            // Handle selection change to auto-fill city_name and zip_code
            $('#destination').on('select2:select', function (e) {
                const data = e.params.data;
                $('#province_name').val(data.province_name || '');
                $('#city_name').val(data.city_name || '');
                $('#zip_code').val(data.zip_code || '');
                $('#destination_id').val(data.id);
            });

            // Handle form submission
            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const btn = $('#checkout-btn');
                const btnText = btn.find('.btn-text');
                const btnLoading = btn.find('.btn-loading');

                // Show loading state
                btn.prop('disabled', true);
                btnText.addClass('d-none');
                btnLoading.removeClass('d-none');

                // Submit form
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        // Reset button state
                        btn.prop('disabled', false);
                        btnText.removeClass('d-none');
                        btnLoading.addClass('d-none');

                        let errorMessage = 'Terjadi kesalahan saat memproses pesanan.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join(', ');
                        }

                        alert(errorMessage);
                    }
                });
            });

            // Handle payment method selection
            $('input[name="metode_pembayaran"]').on('change', function() {
                $('.checkout__payment__method').removeClass('selected');
                $(this).closest('.checkout__payment__method').addClass('selected');
            });

            // Auto-fill email for logged-in users
            @auth
                if (!$('input[name="email"]').val()) {
                    $('input[name="email"]').val('{{ auth()->user()->email ?? '' }}');
                }
            @endauth
        });
    </script>
@endpush

@extends('layouts.guest')

@section('title', 'Checkout - Dame Ulos')

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
                            <a href="{{ route('pelanggan.katalog') }}">Belanja</a>
                            <span>Keranjang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keranjang as $item)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h6><a href="{{ route('pelanggan.produkBySlug', $item->produk->slug) }}" class="text-dark text-decoration-none">{{ $item->produk->nama }}</a></h6>
                                            <p class="font-weight-light">Uk : {{ $item->ukuranProduk ? $item->ukuranProduk->ukuran : 'ukuran blm di set' }}</p>
                                            <p class="font-weight-light">Warna : {{ $item->jenisWarnaProduk ? $item->jenisWarnaProduk->warna : 'warna blm di set' }}</p>
                                            <h5>Rp. {{ number_format($item->produk->harga, 0, ',', '.') }}</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <p>x{{ $item->jumlah }}</p>
                                        </div>
                                    </td>
                                    <td class="cart__price">Rp. {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                                    <td class="cart__close"><i class="fa fa-close" data-id={{ $item->id }}></i></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="alert alert-warning w-100" role="alert">
                                                Keranjang belanja Anda kosong.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="{{ route('pelanggan.katalog') }}">Lanjutkan Belanja</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="{{ route('pelanggan.keranjang.index') }}"><i class="fa fa-spinner"></i> Update Keranjang</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__total">
                        <h6>Total Keranjang</h6>
                        <ul>
                            <li>Total <span>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span></li>
                        </ul>
                        @if($keranjang->count() > 0)
                            <a href="{{ route('pelanggan.checkout.from-cart') }}" class="primary-btn">Lanjutkan ke pembayaran</a>
                        @else
                            <p class="text-muted">Keranjang kosong</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Shopping Cart Section End -->

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.cart__close i').on('click', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Hapus produk dari keranjang?",
                    text: "apakah anda yakin untuk menghapus produk ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/keranjang/' + id,
                            type: 'DELETE',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Terjadi kesalahan!",
                                    text: "Gagal menghapus produk dari keranjang.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

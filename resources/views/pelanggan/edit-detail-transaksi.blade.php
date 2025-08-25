@extends("layouts.guest")

@section("title", "Edit Detail Transaksi")

@section("content")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Edit Detail Transaksi</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <a href="{{ route("pelanggan.transaksi") }}">Transaksi</a>
                            <span>Edit Detail</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Edit Detail Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shopping__cart__table">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Edit Detail Transaksi #{{ $transaksi->kode_transaksi }}</h5>
                                <span class="badge badge-{{ $transaksi->status == "dibayar" ? "info" : "warning" }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                @if (session("error"))
                                    <div class="alert alert-danger">
                                        {{ session("error") }}
                                    </div>
                                @endif

                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <strong>Informasi:</strong> Anda dapat mengubah ukuran dan warna produk selama transaksi
                                    masih berstatus "Dibayar" atau "Dikonfirmasi".
                                    Setelah status berubah menjadi "Diproses", detail transaksi tidak dapat diubah lagi.
                                </div>

                                <form action="{{ route("transaksi.update-detail", $transaksi->id) }}" method="POST">
                                    @csrf
                                    @method("PUT")

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Gambar</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Ukuran</th>
                                                <th>Warna</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksi->detailTransaksi as $detail)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $detail->produk->nama }}</strong><br>
                                                        <small class="text-muted">{{ $detail->produk->deskripsi }}</small>
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset($detail->produk->gambar) }}"
                                                            alt="{{ $detail->produk->nama }}"
                                                            style="width: 60px; height: 60px; object-fit: cover;"
                                                            class="rounded">
                                                    </td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>Rp {{ number_format($detail->harga_satuan, 0, ",", ".") }}</td>
                                                    <td>
                                                        <select name="details[{{ $detail->id }}][ukuran_produk_id]"
                                                            class="form-control form-control-sm" required>
                                                            <option value="">Pilih Ukuran</option>
                                                            @foreach ($detail->produk->ukuranProduk as $ukuran)
                                                                <option value="{{ $ukuran->id }}"
                                                                    {{ $detail->ukuran_produk_id == $ukuran->id ? "selected" : "" }}>
                                                                    {{ $ukuran->ukuran }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error("details.{$detail->id}.ukuran_produk_id")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select name="details[{{ $detail->id }}][jenis_warna_produk_id]"
                                                            class="form-control form-control-sm" required>
                                                            <option value="">Pilih Warna</option>
                                                            @foreach ($detail->produk->jenisWarnaProduk as $warna)
                                                                <option value="{{ $warna->id }}"
                                                                    {{ $detail->jenis_warna_produk_id == $warna->id ? "selected" : "" }}>
                                                                    {{ $warna->warna }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error("details.{$detail->id}.jenis_warna_produk_id")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="shopping__cart__total">
                                                <h6>Ringkasan Transaksi</h6>
                                                <ul class="ml-3">
                                                    <li>Subtotal <span>Rp
                                                            {{ number_format($transaksi->subtotal, 0, ",", ".") }}</span>
                                                    </li>
                                                    <li>Ongkos Kirim <span>Rp
                                                            {{ number_format($transaksi->ongkir, 0, ",", ".") }}</span>
                                                    </li>
                                                    <li>Total <span>Rp
                                                            {{ number_format($transaksi->total, 0, ",", ".") }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary site-btn">
                                            <i class="fa fa-save"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route("pelanggan.transaksi") }}" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Edit Detail Section End -->

    <script>
        $(document).ready(function() {
            // Konfirmasi sebelum submit
            $('form').on('submit', function(e) {
                if (!confirm('Apakah Anda yakin ingin menyimpan perubahan detail transaksi ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection

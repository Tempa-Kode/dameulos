@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Data Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex">
                    @can('isAdmin')
                    <a href="{{ route('produk.create') }}" class="btn btn-primary">
                        <span class="pc-micon"><i class="ti ti-circle-plus me-2"></i></span> Tambah Produk
                    </a>
                    @endcan
                    <form action="" method="get">
                        <select name="penjualan" id="penjualan" onchange="this.form.submit()" class="form-select ms-2">
                            <option value="all" {{ request('penjualan') == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="terlaris" {{ request('penjualan') == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                            <option value="terendah" {{ request('penjualan') == 'terendah' ? 'selected' : '' }}>Terendah</option>
                            <option value="stok" {{ request('penjualan') == 'stok' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </form>
                </div>
                <a href="{{ route('produk.report') }}" class="btn btn-success">
                    <span class="pc-micon"><i class="ti ti-file-download me-2"></i></span>
                    Download Report
                </a>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Katalog</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Terjual</th>
                                @can('isAdmin') <th>Aksi</th>@endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->katalog->nama }}</td>
                                    <td>{{ $item->kategoriProduk->nama_kategori ?? "-" }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>x{{ $item->jumlah_terjual }}</td>
                                    @can('isAdmin')
                                    <td>
                                        <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <a href="{{ route('produk.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        <form action="{{ route('produk.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Katalog</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Terjual</th>
                                @can('isAdmin')<th>Aksi</th>@endcan
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

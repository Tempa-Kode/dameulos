@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Data Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @can('isAdmin')
                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                    <span class="pc-micon"><i class="ti ti-circle-plus me-2"></i></span> Tambah Produk
                </a>
                @endcan
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
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                @can('isAdmin') <th>Aksi</th>@endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->katalog->nama }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->stok }}</td>
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
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                @can('isAdmin')<th>Aksi</th>@endcan
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('halaman', 'Kategori')

@section('judul', 'Data Kategori')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            @can('isAdmin')
                <div class="card-header">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        <span class="pc-micon"><i class="ti ti-circle-plus me-2"></i></span> Tambah Kategori
                    </a>
                </div>
            @endcan
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            @can('isAdmin')<th>Aksi</th>@endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                @can('isAdmin')
                                    <td>
                                        <a href="{{ route('kategori.edit', ['kategori' => $item->id]) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('kategori.destroy', ['kategori' => $item->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            @can('isAdmin')<th>Aksi</th>@endcan
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

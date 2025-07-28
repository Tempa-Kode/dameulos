@extends('layouts.app')

@section('halaman', 'Manajer')

@section('judul', 'Data Manajer')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            @can('isAdmin')
            <div class="card-header">
                <a href="{{ route('manajer.create') }}" class="btn btn-primary">
                    <span class="pc-micon"><i class="ti ti-circle-plus me-2"></i></span> Tambah Manajer
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Diinput Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @can('isAdmin')
                                        <a href="{{ route('manajer.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        @endcan
                                        <a href="{{ route('manajer.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        @can('isAdmin')
                                        <form action="{{ route('manajer.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus katalog ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Diinput Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

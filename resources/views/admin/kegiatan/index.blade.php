@extends('layouts.app')

@section('halaman', 'Kegiatan')

@section('judul', 'Data Kegiatan')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            @can('isAdmin')
            <div class="card-header">
                <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
                    <span class="pc-micon"><i class="ti ti-circle-plus me-2"></i></span> Tambah Kegiatan
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
                                <th>Judul Kegiatan</th>
                                <th>Diinput Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <a href="{{ route('kegiatan.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Judul Piagam</th>
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

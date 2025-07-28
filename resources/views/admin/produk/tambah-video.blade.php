@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Tambah Video Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Video</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('video-produk.store', $produk->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <input type="number" name="produk_id" id="produk_id" value="{{ $produk->id }}" hidden>
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input class="form-control"
                               type="text"
                               id="nama"
                               name="nama"
                               value="{{ $produk->nama }}"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label for="link_video" class="form-label">Link Video</label>
                        <input class="form-control @error('link_video') is-invalid @enderror"
                               type="text"
                               id="link_video"
                               name="link_video"
                               value="{{ old('link_video') }}"
                               placeholder="Masukkan link video">
                        @error('link_video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <span class="pc-micon"><i class="ti ti-device-floppy me-2"></i></span>
                        Tambah Video
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Video Produk</h4>
            </div>
            <div class="card-body">
                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Link</th>
                            <th>Diinput Tanggal</th>
                            @can('isAdmin')<th>Aksi</th>@endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($produk->videoProduk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $produk->nama }}</td>
                                <td><a href="{{ $item->link_video }}" target="_blank">Klik untuk ke youtube</a></td>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                @can('isAdmin')
                                    <td>
                                        <form action="{{ route('video-produk.hapus', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
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
                            <th>Nama Produk</th>
                            <th>Link</th>
                            <th>Diinput Tanggal</th>
                            @can('isAdmin')<th>Aksi</th>@endcan
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

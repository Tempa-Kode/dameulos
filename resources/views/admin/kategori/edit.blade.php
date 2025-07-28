@extends('layouts.app')

@section('halaman', 'Kategori')

@section('judul', 'Edit Data Kategori')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Kategori</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')
                <form action="{{ route('kategori.update', ['kategori' => $data->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input class="form-control @error('nama_kategori') is-invalid @enderror"
                               type="text"
                               id="nama_kategori"
                               name="nama_kategori"
                               value="{{ old('nama_kategori', $data->nama_kategori) }}"
                               placeholder="Masukkan nama kategori">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input class="form-control @error('keterangan') is-invalid @enderror"
                               type="text"
                               id="keterangan"
                               name="keterangan"
                               value="{{ old('keterangan', $data->keterangan) }}"
                               placeholder="Masukkan keterangan (opsional)">
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <span class="pc-micon"><i class="ti ti-edit me-2"></i></span>
                        Edit
                    </button>
              </form>
            </div>
        </div>
    </div>
@endsection

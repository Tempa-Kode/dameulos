@extends('layouts.app')

@section('halaman', 'Piagam')

@section('judul', 'Tambah Data Piagam')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Piagam</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('piagam.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="judul" class="form-label">Judul Piagam</label>
                        <input class="form-control @error('judul') is-invalid @enderror"
                               type="text"
                               id="judul"
                               name="judul"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul piagam">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link_katalog" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link_katalog" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <span class="pc-micon"><i class="ti ti-device-floppy me-2"></i></span>
                        Simpan
                    </button>
              </form>
            </div>
        </div>
    </div>
@endsection

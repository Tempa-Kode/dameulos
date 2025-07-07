@extends('layouts.app')

@section('halaman', 'Manajer')

@section('judul', 'Tambah Data Manajer')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Manajer</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('manajer.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Manajer</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama manajer">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Manajer</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email manajer">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_telp" class="form-label">No Telp</label>
                        <input class="form-control @error('no_telp') is-invalid @enderror"
                            type="number"
                            id="no_telp"
                            name="no_telp"
                            value="{{ old('no_telp') }}"
                            placeholder="Masukkan no telp manajer">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                            id="alamat"
                            name="alamat"
                            rows="3"
                            placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                        @error('no_telp')
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

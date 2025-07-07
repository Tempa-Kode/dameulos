@extends('layouts.app')

@section('halaman', 'Katalog')

@section('judul', 'Tambah Data Katalog')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Input Data Katalog</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('katalog.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Katalog</label>
                        <input class="form-control @error('nama') is-invalid @enderror"
                               type="text"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama katalog">
                        @error('nama')
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

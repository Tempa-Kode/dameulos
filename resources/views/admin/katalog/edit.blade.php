@extends('layouts.app')

@section('halaman', 'Katalog')

@section('judul', 'Edit Data Katalog')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Katalog</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('katalog.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Katalog</label>
                        <input class="form-control @error('nama') is-invalid @enderror"
                               type="text"
                               id="nama"
                               name="nama"
                               value="{{ old('nama', $data->nama) }}"
                               placeholder="Masukkan nama katalog">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link_katalog" class="form-label">Link Katalog</label>
                        <input class="form-control @error('link_katalog') is-invalid @enderror"
                               type="text"
                               id="link_katalog"
                               name="link_katalog"
                               value="{{ old('link_katalog', $data->link_katalog) }}"
                               placeholder="Masukkan link katalog">
                        @error('link_katalog')
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

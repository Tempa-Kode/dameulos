@extends('layouts.app')

@section('halaman', 'Admin')

@section('judul', 'Edit Data Admin')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Admin: {{ $admin->name }}</h4>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') ?? $admin->name }}"
                            placeholder="Masukkan nama lengkap admin">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') ?? $admin->email }}"
                            placeholder="Masukkan alamat email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="no_telp" class="form-label">No. Telepon</label>
                        <input class="form-control @error('no_telp') is-invalid @enderror"
                            type="text"
                            id="no_telp"
                            name="no_telp"
                            value="{{ old('no_telp') ?? $admin->no_telp }}"
                            placeholder="Masukkan nomor telepon">
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
                            placeholder="Masukkan alamat lengkap (opsional)">{{ old('alamat') ?? $admin->alamat }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ubah Password</label>
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-1"></i>
                            <small>Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password baru">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input class="form-control"
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <span class="pc-micon"><i class="ti ti-device-floppy me-2"></i></span>
                            Update Admin
                        </button>
                        <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide password confirmation based on password input
            const passwordInput = document.getElementById('password');
            const confirmationGroup = document.querySelector('[for="password_confirmation"]').closest('.mb-3');
            
            passwordInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    confirmationGroup.style.display = 'none';
                } else {
                    confirmationGroup.style.display = 'block';
                }
            });

            // Initial state
            if (passwordInput.value.trim() === '') {
                confirmationGroup.style.display = 'none';
            }
        });
    </script>
@endsection

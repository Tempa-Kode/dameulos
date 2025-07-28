@extends('layouts.app')

@section('halaman', 'Manajer')

@section('judul', 'Detail Manajer')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Detail Manajer: {{ $manajer->name }}</h4>
                <div>
                    @can('isAdmin')
                    <a href="{{ route('manajer.edit', $manajer->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit
                    </a>
                    @endcan
                    <a href="{{ route('manajer.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="row">
                    <!-- Foto Profil -->
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="profile-image mb-3">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 120px; height: 120px;">
                                    <i class="ti ti-user text-white" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <h5 class="mb-1">{{ $manajer->name }}</h5>
                            <p class="text-muted mb-0">Manajer</p>
                            <span class="badge bg-success mt-2">
                                <i class="ti ti-shield-check me-1"></i>Manajer Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Detail Informasi -->
                    <div class="col-md-8">
                        <div class="admin-details">
                            <!-- Informasi Dasar -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Informasi Dasar</h5>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>ID Manajer:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-info">#{{ $manajer->id }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Nama Lengkap:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $manajer->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <i class="ti ti-mail me-1"></i>{{ $manajer->email }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>No. Telepon:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <i class="ti ti-phone me-1"></i>{{ $manajer->no_telp }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Role:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-primary">{{ ucfirst($manajer->role) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Alamat</h5>
                                <div class="address-text">
                                    @if($manajer->alamat)
                                        <p class="text-muted mb-0">
                                            <i class="ti ti-map-pin me-1"></i>{{ $manajer->alamat }}
                                        </p>
                                    @else
                                        <p class="text-muted fst-italic mb-0">Alamat belum diisi.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="additional-info bg-light p-3 rounded">
                                <h5 class="border-bottom pb-2 mb-3">Informasi Akun</h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="ti ti-calendar me-1"></i>
                                            Dibuat: {{ $manajer->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="ti ti-clock me-1"></i>
                                            Diperbarui: {{ $manajer->updated_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            @can('isAdmin')
                            <a href="{{ route('admin.edit', $manajer->id) }}" class="btn btn-warning">
                                <i class="ti ti-edit me-1"></i>Edit Admin
                            </a>
                            @if(Auth::id() != $manajer->id)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="ti ti-trash me-1"></i>Hapus Admin
                                </button>
                            @endif
                            @endcan
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    @if(Auth::id() != $manajer->id)
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus manajer <strong>"{{ $manajer->name }}"</strong>?</p>
                    <p class="text-danger"><small><i class="ti ti-alert-triangle me-1"></i>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('manajer.destroy', $manajer->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .profile-image {
            position: sticky;
            top: 20px;
        }

        .admin-details .border-bottom {
            border-color: #e9ecef !important;
        }

        .additional-info {
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .profile-image {
                position: static;
                margin-bottom: 2rem;
            }
        }
    </style>
@endsection

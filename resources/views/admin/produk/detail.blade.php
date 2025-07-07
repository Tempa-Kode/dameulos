@extends('layouts.app')

@section('halaman', 'Produk')

@section('judul', 'Detail Produk')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Detail Produk: {{ $produk->nama }}</h4>
                <div>
                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="row">
                    <!-- Gambar Produk -->
                    <div class="col-md-5">
                        <div class="product-image-container">
                            @if($produk->gambar)
                                <img src="{{ asset($produk->gambar) }}"
                                    alt="{{ $produk->nama }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; max-height: 400px; object-fit: cover;">
                            @else
                                <div class="no-image-placeholder bg-light rounded d-flex align-items-center justify-content-center"
                                     style="height: 400px;">
                                    <div class="text-center text-muted">
                                        <i class="ti ti-photo-off" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Produk -->
                    <div class="col-md-7">
                        <div class="product-details">
                            <!-- Informasi Dasar -->
                            <div class="mb-4">
                                <h2 class="product-title mb-3">{{ $produk->nama }}</h2>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Katalog:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-info">{{ $produk->katalog->nama }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Harga:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <h4 class="text-success mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h4>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Stok:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $produk->stok }} Unit
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Deskripsi Produk</h5>
                                <div class="description-text">
                                    @if($produk->deskripsi)
                                        <p class="text-muted">{{ $produk->deskripsi }}</p>
                                    @else
                                        <p class="text-muted fst-italic">Tidak ada deskripsi tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Ukuran -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Ukuran Tersedia</h5>
                                <div class="size-list">
                                    @php
                                        $ukuranData = $produk->ukuran ?? collect();
                                    @endphp
                                    @if($ukuranData->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($ukuranData as $ukuran)
                                                <span class="badge bg-secondary fs-6 py-2 px-3">{{ $ukuran->ukuran }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted fst-italic">Tidak ada ukuran tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Warna -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Kode Warna/Family Color</h5>
                                <div class="color-list">
                                    @php
                                        $warnaData = $produk->warnaProduk ?? collect();
                                    @endphp
                                    @if($warnaData->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($warnaData as $warna)
                                                <div class="color-item d-flex align-items-center">
                                                    <div class="color-box me-2 d-flex align-items-center justify-content-center"
                                                         style="width: 60px; height: 30px; background-color: #{{ $warna->kode_warna }}; border: 1px solid #ddd; border-radius: 3px; color: #000; font-size: 10px; font-weight: 500;">
                                                        #{{ $warna->kode_warna }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted fst-italic">Tidak ada warna tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="additional-info">
                                <h5 class="border-bottom pb-2 mb-3">Informasi Tambahan</h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="ti ti-calendar me-1"></i>
                                            Dibuat: {{ $produk->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="ti ti-clock me-1"></i>
                                            Diperbarui: {{ $produk->updated_at->format('d M Y, H:i') }}
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
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">
                                <i class="ti ti-edit me-1"></i>Edit Produk
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="ti ti-trash me-1"></i>Hapus Produk
                            </button>
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk <strong>"{{ $produk->nama }}"</strong>?</p>
                    <p class="text-danger"><small><i class="ti ti-alert-triangle me-1"></i>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: inline;">
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
@endsection

@push('styles')
    <style>
        .product-image-container {
            position: sticky;
            top: 20px;
        }

        .product-title {
            font-weight: 600;
            line-height: 1.3;
        }

        .color-box {
            display: inline-block;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .size-list .badge,
        .color-list .badge {
            font-weight: 500;
        }

        .description-text {
            line-height: 1.6;
        }

        .border-bottom {
            border-color: #e9ecef !important;
        }

        .additional-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
        }

        @media (max-width: 768px) {
            .product-image-container {
                position: static;
                margin-bottom: 2rem;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

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
                                    class="img-fluid rounded shadow-sm mb-3"
                                    style="width: 100%; max-height: 400px; object-fit: cover;">
                            @else
                                <div class="no-image-placeholder bg-light rounded d-flex align-items-center justify-content-center mb-3"
                                     style="height: 400px;">
                                    <div class="text-center text-muted">
                                        <i class="ti ti-photo-off" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada gambar utama</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Galeri Foto & Video Produk -->
                            @if(($produk->fotoProduk && $produk->fotoProduk->count() > 0) || ($produk->videoProduk && $produk->videoProduk->count() > 0))
                                <div class="foto-produk-gallery">
                                    <h6 class="mb-3">Galeri Foto & Video</h6>
                                    <div class="row">
                                        @if($produk->fotoProduk && $produk->fotoProduk->count() > 0)
                                            @foreach($produk->fotoProduk as $foto)
                                                <div class="col-6 mb-2">
                                                    <img src="{{ asset($foto->foto) }}"
                                                         alt="Foto Produk {{ $loop->iteration }}"
                                                         class="img-fluid rounded shadow-sm"
                                                         style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;"
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#fotoModal{{ $foto->id }}">
                                                </div>
                                            @endforeach
                                        @endif
                                        @if($produk->videoProduk && $produk->videoProduk->count() > 0)
                                            @foreach($produk->videoProduk as $video)
                                                @php
                                                    $isYoutube = Str::contains($video->link_video, ['youtube.com', 'youtu.be']);
                                                    $youtubeId = null;
                                                    if ($isYoutube) {
                                                        if (Str::contains($video->link_video, 'watch?v=')) {
                                                            $youtubeId = Str::after($video->link_video, 'watch?v=');
                                                            $youtubeId = Str::before($youtubeId, '&');
                                                        } else {
                                                            $youtubeId = Str::afterLast($video->link_video, '/');
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-6 mb-2">
                                                    <div class="video-thumbnail position-relative rounded shadow-sm" style="width: 100%; height: 120px; overflow: hidden; cursor: pointer; background: #000;" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                                        <div class="ratio ratio-16x9">
                                                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                                                        </div>
                                                        <span class="position-absolute top-50 start-50 translate-middle" style="color: #fff; font-size: 2rem; pointer-events: none;">
                                                            <i class="ti ti-player-play-filled"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
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

                            <!-- Jenis Warna -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">Warna Tersedia</h5>
                                <div class="size-list">
                                    @php
                                        $jenisWarnaData = $produk->jenisWarnaProduk ?? collect();
                                    @endphp
                                    @if($jenisWarnaData->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($jenisWarnaData as $warna)
                                                <span class="badge bg-secondary fs-6 py-2 px-3">{{ $warna->warna }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted fst-italic">Tidak ada warna tersedia.</p>
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
                            <a href="{{ route('video-produk.tambah', $produk->id) }}" class="btn btn-primary">
                                <i class="ti ti-square-plus me-1"></i>Tambah Video
                            </a>
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

                <!-- Section Ulasan Produk -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="ti ti-star me-2"></i>Ulasan Produk
                                    @if($ulasan && $ulasan->count() > 0)
                                        <span class="badge bg-primary ms-2">{{ $ulasan->total() }} ulasan</span>
                                    @endif
                                </h5>
                                @if($produk->ulasan && $produk->ulasan->count() > 0)
                                    <div class="rating-summary text-end">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Rating rata-rata:</span>
                                            <h5 class="mb-0 me-2 text-warning">{{ number_format($produk->ulasan->avg('rating'), 1) }}/5</h5>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($produk->ulasan->avg('rating')))
                                                        <i class="ti ti-star-filled text-warning"></i>
                                                    @elseif($i <= ceil($produk->ulasan->avg('rating')))
                                                        <i class="ti ti-star-half-filled text-warning"></i>
                                                    @else
                                                        <i class="ti ti-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($ulasan && $ulasan->count() > 0)
                                    <!-- Ulasan List -->
                                    <div class="ulasan-list">
                                        @foreach($ulasan as $review)
                                            <div class="ulasan-item border rounded p-3 mb-3" id="ulasan-{{ $review->id }}">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="reviewer-info mb-2">
                                                            <div class="d-flex align-items-center mb-1">
                                                                <h6 class="mb-0 me-3">{{ $review->user->name }}</h6>
                                                                <div class="rating-stars">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="ti ti-star{{ $i <= $review->rating ? '-filled' : '' }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                    @endfor
                                                                    <span class="text-muted ms-2">({{ $review->rating }}/5)</span>
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="ti ti-calendar me-1"></i>{{ $review->created_at->format('d M Y, H:i') }}
                                                                @if($review->updated_at != $review->created_at)
                                                                    <span class="text-info ms-2">(diedit pada {{ $review->updated_at->format('d M Y, H:i') }})</span>
                                                                @endif
                                                            </small>
                                                        </div>
                                                        <div class="review-text">
                                                            <p class="mb-0">{{ $review->ulasan }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <div class="review-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    onclick="confirmDeleteUlasan({{ $review->id }}, '{{ $review->user->name }}')">
                                                                <i class="ti ti-trash me-1"></i>Hapus Ulasan
                                                            </button>
                                                            <small class="text-muted d-block mt-2">
                                                                ID Transaksi: {{ $review->transaksi->kode_transaksi ?? 'N/A' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Pagination -->
                                        @if($ulasan->hasPages())
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $ulasan->appends(request()->query())->links() }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="ti ti-star-off" style="font-size: 3rem; color: #6c757d;"></i>
                                        <h6 class="mt-3 text-muted">Belum Ada Ulasan</h6>
                                        <p class="text-muted mb-0">Produk ini belum memiliki ulasan dari pelanggan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Foto Produk -->
    @if($produk->fotoProduk && $produk->fotoProduk->count() > 0)
        @foreach($produk->fotoProduk as $foto)
            <div class="modal fade" id="fotoModal{{ $foto->id }}" tabindex="-1" aria-labelledby="fotoModalLabel{{ $foto->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fotoModalLabel{{ $foto->id }}">Foto Produk {{ $loop->iteration }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset($foto->foto) }}"
                                 alt="Foto Produk {{ $loop->iteration }}"
                                 class="img-fluid rounded"
                                 style="max-height: 80vh; width: auto;">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal untuk Video Produk -->
    @if($produk->videoProduk && $produk->videoProduk->count() > 0)
        @foreach($produk->videoProduk as $video)
            <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $video->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel{{ $video->id }}">Video Produk {{ $loop->iteration }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <video controls style="max-width: 100%; max-height: 80vh;">
                                <source src="{{ asset($video->video) }}" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

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

    <!-- Modal Konfirmasi Hapus Ulasan -->
    <div class="modal fade" id="deleteUlasanModal" tabindex="-1" aria-labelledby="deleteUlasanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUlasanModalLabel">Konfirmasi Hapus Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus ulasan dari <strong id="reviewerName"></strong>?</p>
                    <p class="text-danger"><small><i class="ti ti-alert-triangle me-1"></i>Tindakan ini tidak dapat dibatalkan dan akan menghapus ulasan secara permanen.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteUlasanForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>Ya, Hapus Ulasan
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

        .foto-produk-gallery h6 {
            font-weight: 600;
            color: #495057;
        }

        .foto-produk-gallery img:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Ulasan Styles */
        .ulasan-item {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .ulasan-item:hover {
            background-color: #e9ecef;
            border-color: #adb5bd !important;
        }

        .rating-stars {
            font-size: 1rem;
        }

        .review-text {
            line-height: 1.6;
            color: #495057;
        }

        .review-actions .btn {
            font-size: 0.875rem;
        }

        .rating-summary .stars {
            font-size: 1.1rem;
        }

        .ulasan-item .reviewer-info h6 {
            color: #212529;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .product-image-container {
                position: static;
                margin-bottom: 2rem;
            }

            .review-actions {
                text-align: left !important;
                margin-top: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDeleteUlasan(ulasanId, reviewerName) {
            document.getElementById('reviewerName').textContent = reviewerName;
            document.getElementById('deleteUlasanForm').action = `/dashboard/produk-ulasan/${ulasanId}`;

            var modal = new bootstrap.Modal(document.getElementById('deleteUlasanModal'));
            modal.show();
        }

        // Handle delete ulasan form submission with AJAX
        document.getElementById('deleteUlasanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const actionUrl = form.action;
            const formData = new FormData(form);

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
            submitBtn.disabled = true;

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide modal
                bootstrap.Modal.getInstance(document.getElementById('deleteUlasanModal')).hide();

                if (data.success) {
                    // Show success alert
                    showAlert('success', data.message);

                    // Remove the review item from DOM with animation
                    const ulasanElement = document.querySelector(`#ulasan-${actionUrl.split('/').pop()}`);
                    if (ulasanElement) {
                        ulasanElement.style.transition = 'opacity 0.5s ease';
                        ulasanElement.style.opacity = '0';
                        setTimeout(() => {
                            ulasanElement.remove();

                            // Check if no more reviews left
                            const remainingReviews = document.querySelectorAll('.ulasan-item');
                            if (remainingReviews.length === 0) {
                                location.reload(); // Reload to show "no reviews" state
                            }
                        }, 500);
                    }
                } else {
                    showAlert('danger', data.message || 'Terjadi kesalahan saat menghapus ulasan.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Terjadi kesalahan jaringan.');

                // Hide modal
                bootstrap.Modal.getInstance(document.getElementById('deleteUlasanModal')).hide();
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        function showAlert(type, message) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="ti ti-${type === 'success' ? 'check' : 'alert-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert alert at the top of card body
            const cardBody = document.querySelector('.card-body');
            cardBody.insertBefore(alertDiv, cardBody.firstChild);

            // Auto hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    </script>
@endpush

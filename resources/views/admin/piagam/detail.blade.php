@extends("layouts.app")

@section('halaman', 'Piagam')

@section('judul', 'Detail Data Piagam')

@section("content")
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);">
                        <h4 class="mb-0 text-white"><i class="ti ti-gift me-2"></i> Detail Piagam</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-5 text-center">
                                @if ($piagam->gambar)
                                    <img src="/{{ $piagam->gambar }}" alt="Gambar Piagam" class="img-thumbnail shadow"
                                        style="max-width: 100%; max-height: 260px; object-fit:cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                        style="height: 260px;">
                                        <span class="text-muted">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h3 class="fw-bold mb-2">{{ $piagam->judul }}</h3>
                                <p class="text-muted mb-3">{{ $piagam->deskripsi }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Tanggal Dibuat</span>
                                        <span>{{ $piagam->created_at ? $piagam->created_at->format("d-m-Y H:i") : "-" }}</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Tanggal Diupdate</span>
                                        <span>{{ $piagam->updated_at ? $piagam->updated_at->format("d-m-Y H:i") : "-" }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

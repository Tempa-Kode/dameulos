@extends("layouts.app")

@section('halaman', 'Promosi')

@section('judul', 'Detail Data Promosi')

@section("content")
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);">
                        <h4 class="mb-0 text-white"><i class="ti ti-gift me-2"></i> Detail Promosi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-5 text-center">
                                @if ($promosi->gambar)
                                    <img src="/{{ $promosi->gambar }}" alt="Gambar Promosi" class="img-thumbnail shadow"
                                        style="max-width: 100%; max-height: 260px; object-fit:cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                        style="height: 260px;">
                                        <span class="text-muted">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h3 class="fw-bold mb-2">{{ $promosi->judul }}</h3>
                                <p class="text-muted mb-3">{{ $promosi->deskripsi }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Tanggal Dibuat</span>
                                        <span>{{ $promosi->created_at ? $promosi->created_at->format("d-m-Y H:i") : "-" }}</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Tanggal Diupdate</span>
                                        <span>{{ $promosi->updated_at ? $promosi->updated_at->format("d-m-Y H:i") : "-" }}</span>
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

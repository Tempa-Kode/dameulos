@extends("layouts.guest")

@section("title", "Keluhan Saya - Dame Ulos")

@section("content")

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Keluhan Saya</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <span>Keluhan Saya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <div class="container">

        <div class="row my-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Keluhan</h5>
                        <a href="{{ route("pelanggan.keluhan.create") }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus mr-1"></i> Buat Keluhan Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($keluhans->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Tiket</th>
                                            <th>Subjek</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Prioritas</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keluhans as $keluhan)
                                            <tr>
                                                <td>
                                                    <strong>{{ $keluhan->kode_tiket }}</strong>
                                                    @if ($keluhan->transaksi_id)
                                                        <br><small class="text-muted">Terkait:
                                                            {{ $keluhan->transaksi->kode_transaksi }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($keluhan->subjek, 50) }}</td>
                                                <td>{{ $keluhan->kategori_label }}</td>
                                                <td><span
                                                        class="badge {{ $keluhan->status_badge }}">{{ $keluhan->status_label }}</span>
                                                </td>
                                                <td><span
                                                        class="badge {{ $keluhan->prioritas_badge }}">{{ $keluhan->prioritas_label }}</span>
                                                </td>
                                                <td>{{ $keluhan->created_at->format("d M Y H:i") }}</td>
                                                <td>
                                                    <a href="{{ route("pelanggan.keluhan.show", $keluhan) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $keluhans->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                <h5>Belum Ada Keluhan</h5>
                                <p class="text-muted">Anda belum memiliki keluhan. Silakan buat keluhan baru jika mengalami
                                    masalah.</p>
                                <a href="{{ route("pelanggan.keluhan.create") }}" class="btn btn-primary">
                                    <i class="fa fa-plus mr-1"></i> Buat Keluhan Baru
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session("success"))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    @if (session("error"))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endsection

@push("styles")
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .table th {
            border-top: none;
            font-weight: 600;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .badge-danger {
            background-color: #dc3545;
        }
    </style>
@endpush

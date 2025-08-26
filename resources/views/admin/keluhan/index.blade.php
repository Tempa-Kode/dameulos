@extends("layouts.app")

@section("halaman", "Keluhan")

@section("judul", "Data keluhan")

@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-ticket-alt mr-2"></i>Manajemen Keluhan
            </h1>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["total"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Buka</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["buka"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["dalam_proses"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cog fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Menunggu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["menunggu_pelanggan"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["selesai"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Urgent</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats["urgent"] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route("admin.keluhan.index") }}">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="buka" {{ request("status") == "buka" ? "selected" : "" }}>Buka</option>
                                <option value="dalam_proses" {{ request("status") == "dalam_proses" ? "selected" : "" }}>
                                    Dalam Proses</option>
                                <option value="menunggu_pelanggan"
                                    {{ request("status") == "menunggu_pelanggan" ? "selected" : "" }}>Menunggu Pelanggan
                                </option>
                                <option value="selesai" {{ request("status") == "selesai" ? "selected" : "" }}>Selesai
                                </option>
                                <option value="ditutup" {{ request("status") == "ditutup" ? "selected" : "" }}>Ditutup
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-control">
                                <option value="">Semua Kategori</option>
                                <option value="produk" {{ request("kategori") == "produk" ? "selected" : "" }}>Produk
                                </option>
                                <option value="pengiriman" {{ request("kategori") == "pengiriman" ? "selected" : "" }}>
                                    Pengiriman</option>
                                <option value="pembayaran" {{ request("kategori") == "pembayaran" ? "selected" : "" }}>
                                    Pembayaran</option>
                                <option value="layanan" {{ request("kategori") == "layanan" ? "selected" : "" }}>Layanan
                                </option>
                                <option value="lainnya" {{ request("kategori") == "lainnya" ? "selected" : "" }}>Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="prioritas" class="form-control">
                                <option value="">Semua Prioritas</option>
                                <option value="rendah" {{ request("prioritas") == "rendah" ? "selected" : "" }}>Rendah
                                </option>
                                <option value="normal" {{ request("prioritas") == "normal" ? "selected" : "" }}>Normal
                                </option>
                                <option value="tinggi" {{ request("prioritas") == "tinggi" ? "selected" : "" }}>Tinggi
                                </option>
                                <option value="urgent" {{ request("prioritas") == "urgent" ? "selected" : "" }}>Urgent
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari kode/subjek/nama..." value="{{ request("search") }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Keluhan Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Keluhan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Kode Tiket</th>
                                <th>Pelanggan</th>
                                <th>Subjek</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Prioritas</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keluhans as $keluhan)
                                <tr class="{{ $keluhan->needsAttention() ? "table-warning" : "" }}">
                                    <td>
                                        <strong>{{ $keluhan->kode_tiket }}</strong>
                                        @if ($keluhan->transaksi_id)
                                            <br><small
                                                class="text-muted">{{ $keluhan->transaksi->kode_transaksi }}</small>
                                        @endif
                                        @if ($keluhan->needsAttention())
                                            <br><span class="badge badge-warning"><i
                                                    class="fas fa-exclamation-triangle"></i> Perlu Perhatian</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $keluhan->user->name }}</strong>
                                        <br><small class="text-muted">{{ $keluhan->user->email }}</small>
                                    </td>
                                    <td>{{ Str::limit($keluhan->subjek, 40) }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $keluhan->kategori_label }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $keluhan->status_badge }}">{{ $keluhan->status_label }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $keluhan->prioritas_badge }}">{{ $keluhan->prioritas_label }}</span>
                                    </td>
                                    <td>{{ $keluhan->created_at->format("d M Y H:i") }}</td>
                                    <td>
                                        <a href="{{ route("admin.keluhan.show", $keluhan) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <h5>Tidak ada keluhan</h5>
                                        <p class="text-muted">Belum ada keluhan yang sesuai dengan filter.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($keluhans->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $keluhans->withQueryString()->links() }}
                    </div>
                @endif
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
@endsection

@push("styles")
    <style>
        .table th {
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

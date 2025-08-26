@extends("layouts.guest")

@section("title", "Detail Keluhan - Dame Ulos")

@section("content")
    <section class="breadcrumb-option" style="margin-top: 110px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Buat Keluhan Baru</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route("pelanggan.home") }}">Home</a>
                            <a href="{{ route("pelanggan.keluhan.index") }}">Keluhan Saya</a>
                            <span>{{ $keluhan->kode_tiket }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">

        <div class="row my-3">
            <div class="col-lg-8">
                <!-- Detail Keluhan -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $keluhan->subjek }}</h5>
                            <span class="badge {{ $keluhan->status_badge }}">{{ $keluhan->status_label }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kode Tiket:</strong> {{ $keluhan->kode_tiket }}
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> {{ $keluhan->created_at->format("d M Y H:i") }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kategori:</strong> {{ $keluhan->kategori_label }}
                            </div>
                            <div class="col-md-6">
                                <strong>Prioritas:</strong> <span
                                    class="badge {{ $keluhan->prioritas_badge }}">{{ $keluhan->prioritas_label }}</span>
                            </div>
                        </div>

                        @if ($keluhan->transaksi_id)
                            <div class="alert alert-info">
                                <strong>Terkait Transaksi:</strong> {{ $keluhan->transaksi->kode_transaksi }}
                            </div>
                        @endif

                        <div class="border-top pt-3">
                            <h6><strong>Pesan Awal:</strong></h6>
                            <p>{{ $keluhan->pesan }}</p>

                            @if ($keluhan->lampiran)
                                <div class="mt-2">
                                    <strong>Lampiran:</strong>
                                    <div class="row mt-2">
                                        @foreach ($keluhan->lampiran as $file)
                                            <div class="col-md-4 mb-2">
                                                <a href="{{ Storage::url($file["path"]) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary btn-block">
                                                    <i class="fa fa-download mr-1"></i>{{ $file["original_name"] }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline Percakapan -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Percakapan</h6>
                    </div>
                    <div class="card-body">
                        @if ($keluhan->balasans->count() > 0)
                            <div class="timeline">
                                @foreach ($keluhan->balasans as $balasan)
                                    @if (!$balasan->is_internal)
                                        <div
                                            class="timeline-item {{ $balasan->dari === "pelanggan" ? "timeline-customer" : "timeline-admin" }}">
                                            <div
                                                class="timeline-marker {{ $balasan->dari === "pelanggan" ? "bg-primary" : "bg-success" }}">
                                            </div>
                                            <div class="timeline-content">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <strong>
                                                        @if ($balasan->dari === "pelanggan")
                                                            <i class="fa fa-user text-primary mr-1"></i>Anda
                                                        @else
                                                            <i class="fa fa-user-shield text-success mr-1"></i>Tim Support
                                                        @endif
                                                    </strong>
                                                    <small
                                                        class="text-muted">{{ $balasan->created_at->format("d M Y H:i") }}</small>
                                                </div>
                                                <div class="message-content">
                                                    {{ $balasan->pesan }}
                                                </div>

                                                @if ($balasan->lampiran)
                                                    <div class="mt-2">
                                                        <strong>Lampiran:</strong>
                                                        <div class="row mt-1">
                                                            @foreach ($balasan->lampiran as $file)
                                                                <div class="col-md-6 mb-1">
                                                                    <a href="{{ Storage::url($file["path"]) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-secondary btn-block">
                                                                        <i
                                                                            class="fa fa-download mr-1"></i>{{ $file["original_name"] }}
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Belum ada percakapan.</p>
                        @endif
                    </div>
                </div>

                <!-- Form Reply -->
                @if ($keluhan->canBeReplied())
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">Balas Keluhan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("pelanggan.keluhan.reply", $keluhan) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="pesan">Pesan Balasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error("pesan") is-invalid @enderror" name="pesan" id="pesan" rows="4"
                                        required placeholder="Tulis balasan Anda...">{{ old("pesan") }}</textarea>
                                    @error("pesan")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="lampiran">Lampiran (Opsional)</label>
                                    <input type="file"
                                        class="form-control-file @error("lampiran.*") is-invalid @enderror"
                                        name="lampiran[]" id="lampiran" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <small class="form-text text-muted">
                                        Maksimal 3 file. Format: JPG, PNG, PDF, DOC, DOCX. Ukuran maksimal: 2MB per file.
                                    </small>
                                    @error("lampiran.*")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane mr-1"></i> Kirim Balasan
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        <i class="fa fa-info-circle mr-2"></i>
                        Keluhan ini sudah {{ $keluhan->status_label }} dan tidak dapat dibalas lagi.
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Info Panel -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Keluhan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><span class="badge {{ $keluhan->status_badge }}">{{ $keluhan->status_label }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Prioritas:</strong></td>
                                <td><span
                                        class="badge {{ $keluhan->prioritas_badge }}">{{ $keluhan->prioritas_label }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td>{{ $keluhan->kategori_label }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $keluhan->created_at->format("d M Y H:i") }}</td>
                            </tr>
                            <tr>
                                <td><strong>Update Terakhir:</strong></td>
                                <td>{{ $keluhan->updated_at->format("d M Y H:i") }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Tips</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Berikan informasi yang jelas dan
                                detail</li>
                            <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Lampirkan bukti jika
                                diperlukan</li>
                            <li class="mb-2"><i class="fa fa-check text-success mr-2"></i>Respon tim support dalam 1x24
                                jam</li>
                            <li><i class="fa fa-check text-success mr-2"></i>Pantau status keluhan secara berkala</li>
                        </ul>
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

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Terdapat Kesalahan!',
                    html: '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
                    confirmButtonText: 'OK'
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

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-marker {
            position: absolute;
            left: -35px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .timeline-item:not(:last-child):before {
            content: '';
            position: absolute;
            left: -29px;
            top: 12px;
            height: calc(100% + 18px);
            width: 2px;
            background: #e3e6f0;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .timeline-customer .timeline-content {
            background: #e3f2fd;
            border-color: #2196f3;
        }

        .timeline-admin .timeline-content {
            background: #e8f5e8;
            border-color: #4caf50;
        }

        .message-content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Badge styles */
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

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
@endpush

@extends("layouts.app")

@section("halaman", "Keluhan")

@section("judul", "Detail keluhan")

@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-ticket-alt mr-2"></i>Detail Keluhan
                    <span class="badge {{ $keluhan->status_badge }} ml-2">{{ $keluhan->status_label }}</span>
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route("admin.keluhan.index") }}">Keluhan</a></li>
                        <li class="breadcrumb-item active">{{ $keluhan->kode_tiket }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <a href="{{ route("admin.keluhan.index") }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
                {{-- @if (!in_array($keluhan->status, ["selesai", "ditutup"]))
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fas fa-cog mr-1"></i>Actions
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" onclick="changeStatus('dalam_proses')">
                                <i class="fas fa-play text-warning mr-2"></i>Dalam Proses
                            </button>
                            <button class="dropdown-item" onclick="changeStatus('menunggu_pelanggan')">
                                <i class="fas fa-clock text-info mr-2"></i>Menunggu Pelanggan
                            </button>
                            <button class="dropdown-item" onclick="changeStatus('selesai')">
                                <i class="fas fa-check text-success mr-2"></i>Selesai
                            </button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item text-danger" onclick="changeStatus('ditutup')">
                                <i class="fas fa-times text-danger mr-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Detail Keluhan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Keluhan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5>{{ $keluhan->subjek }}</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="font-weight-bold" style="width: 150px;">Kode Tiket:</td>
                                        <td>{{ $keluhan->kode_tiket }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pelanggan:</td>
                                        <td>{{ $keluhan->user->name }} ({{ $keluhan->user->email }})</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Kategori:</td>
                                        <td><span class="badge badge-secondary">{{ $keluhan->kategori_label }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Prioritas:</td>
                                        <td><span
                                                class="badge {{ $keluhan->prioritas_badge }}">{{ $keluhan->prioritas_label }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Status:</td>
                                        <td><span
                                                class="badge {{ $keluhan->status_badge }}">{{ $keluhan->status_label }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Dibuat:</td>
                                        <td>{{ $keluhan->created_at->format("d M Y H:i") }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Update Terakhir:</td>
                                        <td>{{ $keluhan->updated_at->format("d M Y H:i") }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($keluhan->transaksi_id)
                            <div class="border-top pt-3 mt-3">
                                <h6 class="font-weight-bold mb-3">
                                    <i class="fas fa-shopping-cart mr-2"></i>Terkait Transaksi
                                </h6>
                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Kode Transaksi:</strong> #{{ $keluhan->transaksi->kode_transaksi }}<br>
                                            <strong>Total:</strong> Rp
                                            {{ number_format($keluhan->transaksi->total_pembayaran, 0, ",", ".") }}<br>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Status:</strong> {{ $keluhan->transaksi->status }}<br>
                                            <strong>Tanggal:</strong>
                                            {{ $keluhan->transaksi->created_at->format("d M Y") }}<br>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-external-link-alt mr-1"></i>Lihat Transaksi
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="border-top pt-3 mt-3">
                            <h6 class="font-weight-bold mb-3">Pesan Awal</h6>
                            <div class="p-3 bg-light rounded">
                                {{ $keluhan->pesan }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Percakapan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Timeline Percakapan</h6>
                    </div>
                    <div class="card-body">
                        @if ($keluhan->balasans->count() > 0)
                            <div class="timeline">
                                @foreach ($keluhan->balasans as $balasan)
                                    <div
                                        class="timeline-item {{ $balasan->dari === "pelanggan" ? "timeline-customer" : "timeline-admin" }}">
                                        <div
                                            class="timeline-marker {{ $balasan->dari === "pelanggan" ? "bg-primary" : "bg-success" }}">
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>
                                                    @if ($balasan->dari === "pelanggan")
                                                        <i
                                                            class="fas fa-user text-primary mr-1"></i>{{ $balasan->user->name }}
                                                    @else
                                                        <i
                                                            class="fas fa-user-shield text-success mr-1"></i>{{ $balasan->user->name }}
                                                        @if ($balasan->is_internal)
                                                            <span class="badge badge-warning ml-2">Internal</span>
                                                        @endif
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
                                                                <a href="{{ Storage::url($file["path"]) }}" target="_blank"
                                                                    class="btn btn-sm btn-outline-secondary btn-block">
                                                                    <i
                                                                        class="fas fa-download mr-1"></i>{{ $file["original_name"] }}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Belum ada percakapan.</p>
                        @endif
                    </div>
                </div>

                <!-- Form Reply -->
                @if ($keluhan->canBeReplied())
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Balas Keluhan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("admin.keluhan.reply", $keluhan) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="pesan">Pesan Balasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error("pesan") is-invalid @enderror" name="pesan" id="pesan" rows="5"
                                        required placeholder="Tulis balasan untuk pelanggan...">{{ old("pesan") }}</textarea>
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

                                {{-- <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_internal" id="is_internal" value="1">
                                    <label class="form-check-label" for="is_internal">
                                        Catatan Internal (Tidak terlihat oleh pelanggan)
                                    </label>
                                </div> --}}

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="auto_status_update"
                                        id="auto_status_update" value="1" checked>
                                    <label class="form-check-label" for="auto_status_update">
                                        Otomatis ubah status ke "Menunggu Pelanggan" setelah balasan dikirim
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-1"></i> Kirim Balasan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="quickStatus">Ubah Status</label>
                            <select class="form-control" id="quickStatus" onchange="quickStatusChange()">
                                <option value="">Pilih Status</option>
                                <option value="buka" {{ $keluhan->status === "buka" ? "disabled" : "" }}>Buka</option>
                                <option value="dalam_proses" {{ $keluhan->status === "dalam_proses" ? "disabled" : "" }}>
                                    Dalam Proses</option>
                                <option value="menunggu_pelanggan"
                                    {{ $keluhan->status === "menunggu_pelanggan" ? "disabled" : "" }}>Menunggu Pelanggan
                                </option>
                                <option value="selesai" {{ $keluhan->status === "selesai" ? "disabled" : "" }}>Selesai
                                </option>
                                <option value="ditutup" {{ $keluhan->status === "ditutup" ? "disabled" : "" }}>Ditutup
                                </option>
                            </select>
                            <small class="text-muted">Status saat ini:
                                <strong>{{ $keluhan->status_label }}</strong></small>
                        </div>

                        <div class="form-group">
                            <label for="quickPriority">Ubah Prioritas</label>
                            <select class="form-control" id="quickPriority" onchange="quickPriorityChange()">
                                <option value="">Pilih Prioritas</option>
                                <option value="urgent" {{ $keluhan->prioritas === "urgent" ? "disabled" : "" }}>Urgent
                                </option>
                                <option value="tinggi" {{ $keluhan->prioritas === "tinggi" ? "disabled" : "" }}>Tinggi
                                </option>
                                <option value="normal" {{ $keluhan->prioritas === "normal" ? "disabled" : "" }}>Normal
                                </option>
                                <option value="rendah" {{ $keluhan->prioritas === "rendah" ? "disabled" : "" }}>Rendah
                                </option>
                            </select>
                            <small class="text-muted">Prioritas saat ini:
                                <strong>{{ $keluhan->prioritas_label }}</strong></small>
                        </div>

                        <div class="border-top pt-3">
                            <button class="btn btn-outline-success btn-sm btn-block" onclick="sendTemplate('thankyou')">
                                <i class="fas fa-smile mr-1"></i>Template: Terima Kasih
                            </button>
                            <button class="btn btn-outline-info btn-sm btn-block mt-2" onclick="sendTemplate('followup')">
                                <i class="fas fa-question-circle mr-1"></i>Template: Follow Up
                            </button>
                            <button class="btn btn-outline-warning btn-sm btn-block mt-2"
                                onclick="sendTemplate('escalate')">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Template: Eskalasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeStatus(newStatus) {
            if (confirm(`Ubah status keluhan menjadi "${newStatus}"?`)) {
                updateStatus({
                    status: newStatus
                });
            }
        }

        function quickStatusChange() {
            const statusSelect = document.getElementById('quickStatus');
            const status = statusSelect.value;
            if (status && confirm(`Ubah status ke "${status}"?`)) {
                updateStatus({
                    status: status
                });
                // Reset select after action
                statusSelect.value = '';
            } else {
                // Reset if cancelled
                statusSelect.value = '';
            }
        }

        function quickPriorityChange() {
            const prioritasSelect = document.getElementById('quickPriority');
            const prioritas = prioritasSelect.value;
            if (prioritas && confirm(`Ubah prioritas ke "${prioritas}"?`)) {
                updateStatus({
                    prioritas: prioritas
                });
                // Reset select after action
                prioritasSelect.value = '';
            } else {
                // Reset if cancelled
                prioritasSelect.value = '';
            }
        }

        function updateStatus(data) {
            // Show loading state
            const statusSelect = document.getElementById('quickStatus');
            const prioritySelect = document.getElementById('quickPriority');

            statusSelect.disabled = true;
            prioritySelect.disabled = true;

            // Add loading text to button if exists
            const actionButtons = document.querySelectorAll('.dropdown-item, .btn-sm');
            actionButtons.forEach(btn => btn.style.opacity = '0.6');

            fetch(`{{ route("admin.keluhan.status", $keluhan) }}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show success message with SweetAlert if available, otherwise use alert
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Status berhasil diperbarui',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            alert(data.message || 'Status berhasil diperbarui');
                            location.reload();
                        }
                    } else {
                        throw new Error(data.message || 'Gagal mengupdate keluhan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Re-enable controls
                    statusSelect.disabled = false;
                    prioritySelect.disabled = false;
                    actionButtons.forEach(btn => btn.style.opacity = '1');

                    // Show error message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: error.message,
                        });
                    } else {
                        alert('Terjadi kesalahan: ' + error.message);
                    }
                });
        }

        function sendTemplate(type) {
            const templates = {
                thankyou: 'Terima kasih telah menghubungi kami. Masalah Anda telah kami selesaikan. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.',
                followup: 'Halo, kami ingin menindaklanjuti keluhan Anda. Apakah masalah yang Anda laporkan sudah teratasi? Silakan beri tahu kami jika masih ada yang perlu kami bantu.',
                escalate: 'Keluhan Anda telah kami eskalasi ke tim yang lebih berpengalaman. Kami akan memberikan update dalam 24 jam ke depan. Terima kasih atas kesabaran Anda.'
            };

            document.getElementById('pesan').value = templates[type];
        }

        // Auto-refresh every 30 seconds to check for new replies
        setInterval(function() {
            // You can implement auto-refresh logic here
        }, 30000);

        // Timeline CSS
        const timelineStyle = `
            <style>
                .timeline { position: relative; padding-left: 20px; }
                .timeline-item { position: relative; margin-bottom: 20px; }
                .timeline-marker {
                    position: absolute;
                    left: -25px;
                    top: 0;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                }
                .timeline-item:not(:last-child):before {
                    content: '';
                    position: absolute;
                    left: -21px;
                    top: 10px;
                    height: calc(100% + 10px);
                    width: 2px;
                    background: #e3e6f0;
                }
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', timelineStyle);
    </script>
@endsection

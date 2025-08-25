@extends("layouts.app")

@section("title", "Update Status Pengembalian Dana")

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Update Status Pengembalian Dana</h5>
                    <a href="{{ route("pengembalian-dana.show", $pengembalianDana->id) }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Singkat -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Informasi Pengembalian Dana</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Kode:</strong> {{ $pengembalianDana->kode_pengembalian }}</p>
                                    <p class="mb-2"><strong>Transaksi:</strong>
                                        {{ $pengembalianDana->transaksi->kode_transaksi }}</p>
                                    <p class="mb-2"><strong>Pelanggan:</strong> {{ $pengembalianDana->user->name }}</p>
                                    <p class="mb-2"><strong>Jumlah:</strong> Rp
                                        {{ number_format($pengembalianDana->jumlah_pengembalian, 0, ",", ".") }}</p>
                                    <p class="mb-2"><strong>Status Saat Ini:</strong>
                                        @if ($pengembalianDana->status == "pending")
                                            <span class="badge text-bg-warning">{{ $pengembalianDana->status_text }}</span>
                                        @elseif($pengembalianDana->status == "diproses")
                                            <span class="badge text-bg-info">{{ $pengembalianDana->status_text }}</span>
                                        @elseif($pengembalianDana->status == "selesai")
                                            <span class="badge text-bg-success">{{ $pengembalianDana->status_text }}</span>
                                        @else
                                            <span class="badge text-bg-danger">{{ $pengembalianDana->status_text }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Update -->
                        <div class="col-md-6">
                            <form action="{{ route("pengembalian-dana.update", $pengembalianDana->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method("PUT")

                                <div class="card">
                                    <div class="card-header">
                                        <h6>Update Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error("status") is-invalid @enderror"
                                                id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="pending"
                                                    {{ old("status", $pengembalianDana->status) == "pending" ? "selected" : "" }}>
                                                    Menunggu Persetujuan</option>
                                                <option value="diproses"
                                                    {{ old("status", $pengembalianDana->status) == "diproses" ? "selected" : "" }}>
                                                    Sedang Diproses</option>
                                                <option value="selesai"
                                                    {{ old("status", $pengembalianDana->status) == "selesai" ? "selected" : "" }}>
                                                    Selesai</option>
                                                <option value="ditolak"
                                                    {{ old("status", $pengembalianDana->status) == "ditolak" ? "selected" : "" }}>
                                                    Ditolak</option>
                                            </select>
                                            @error("status")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Catatan Admin -->
                                        <div class="mb-3">
                                            <label for="catatan_admin" class="form-label">Catatan Admin</label>
                                            <textarea class="form-control @error("catatan_admin") is-invalid @enderror" id="catatan_admin" name="catatan_admin"
                                                rows="4" placeholder="Tambahkan catatan untuk pelanggan...">{{ old("catatan_admin", $pengembalianDana->catatan_admin) }}</textarea>
                                            @error("catatan_admin")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Bukti Transfer -->
                                        <div class="mb-3" id="bukti_transfer_field" style="display: none;">
                                            <label for="bukti_transfer" class="form-label">Bukti Transfer</label>
                                            <input type="file"
                                                class="form-control @error("bukti_transfer") is-invalid @enderror"
                                                id="bukti_transfer" name="bukti_transfer" accept="image/*">
                                            @error("bukti_transfer")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Upload bukti transfer untuk status 'Selesai'. Format:
                                                JPG, PNG. Maksimal 2MB.</small>

                                            @if ($pengembalianDana->bukti_transfer)
                                                <div class="mt-2">
                                                    <small class="text-info">Bukti transfer saat ini:</small><br>
                                                    <a href="{{ Storage::url($pengembalianDana->bukti_transfer) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-eye me-1"></i>Lihat Bukti
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Info Box -->
                                        <div class="alert alert-info">
                                            <h6><i class="ti ti-info-circle me-1"></i>Informasi:</h6>
                                            <ul class="mb-0">
                                                <li><strong>Pending:</strong> Menunggu persetujuan admin</li>
                                                <li><strong>Diproses:</strong> Admin sedang memproses pengembalian</li>
                                                <li><strong>Selesai:</strong> Dana sudah dikembalikan ke pelanggan</li>
                                                <li><strong>Ditolak:</strong> Pengajuan ditolak, transaksi dikembalikan ke
                                                    status semula</li>
                                            </ul>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route("pengembalian-dana.show", $pengembalianDana->id) }}"
                                                class="btn btn-secondary">
                                                <i class="ti ti-arrow-left me-1"></i>Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-check me-1"></i>Update Status
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const buktiTransferField = document.getElementById('bukti_transfer_field');
            const buktiTransferInput = document.getElementById('bukti_transfer');

            function toggleBuktiTransfer() {
                if (statusSelect.value === 'selesai') {
                    buktiTransferField.style.display = 'block';
                    buktiTransferInput.required = true;
                } else {
                    buktiTransferField.style.display = 'none';
                    buktiTransferInput.required = false;
                }
            }

            statusSelect.addEventListener('change', toggleBuktiTransfer);

            // Trigger pada page load
            toggleBuktiTransfer();
        });
    </script>
@endsection

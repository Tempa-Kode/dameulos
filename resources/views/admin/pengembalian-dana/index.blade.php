@extends("layouts.app")

@section("title", "Pengembalian Dana")

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Daftar Pengembalian Dana</h5>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request("status") == "pending" ? "selected" : "" }}>Menunggu
                                        Persetujuan</option>
                                    <option value="diproses" {{ request("status") == "diproses" ? "selected" : "" }}>Sedang
                                        Diproses</option>
                                    <option value="selesai" {{ request("status") == "selesai" ? "selected" : "" }}>Selesai
                                    </option>
                                    <option value="ditolak" {{ request("status") == "ditolak" ? "selected" : "" }}>Ditolak
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>

                    @if ($pengembalianDana->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Pengembalian</th>
                                        <th>Kode Transaksi</th>
                                        <th>Pelanggan</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengembalianDana as $item)
                                        <tr>
                                            <td>{{ $item->kode_pengembalian }}</td>
                                            <td>{{ $item->transaksi->kode_transaksi }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>Rp {{ number_format($item->jumlah_pengembalian, 0, ",", ".") }}</td>
                                            <td>{{ $item->metode_pengembalian_text }}</td>
                                            <td>
                                                @if ($item->status == "pending")
                                                    <span class="badge text-bg-warning">{{ $item->status_text }}</span>
                                                @elseif($item->status == "diproses")
                                                    <span class="badge text-bg-info">{{ $item->status_text }}</span>
                                                @elseif($item->status == "selesai")
                                                    <span class="badge text-bg-success">{{ $item->status_text }}</span>
                                                @else
                                                    <span class="badge text-bg-danger">{{ $item->status_text }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->tanggal_pengajuan->format("d-m-Y H:i") }}</td>
                                            <td>
                                                <a href="{{ route("pengembalian-dana.show", $item->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="ti ti-eye me-1"></i>Detail
                                                </a>
                                                @if ($item->status != "selesai")
                                                    <a href="{{ route("pengembalian-dana.edit", $item->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="ti ti-edit me-1"></i>Edit
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $pengembalianDana->links() }}
                        </div>
                    @else
                        <div class="text-center">
                            <div class="alert alert-info">
                                <h5><i class="ti ti-info-circle"></i> Tidak Ada Data</h5>
                                <p>Belum ada pengajuan pengembalian dana.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

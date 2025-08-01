@extends('layouts.app')

@section('halaman', 'Transaksi')

@section('judul', 'Data Transaksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/plugins/datepicker-bs5.min.css') }}">
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Total</h5>
                            <h3 class="text-primary">{{ $data->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Pending</h5>
                            <h3 class="text-secondary">{{ $data->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Dibayar</h5>
                            <h3 class="text-info">{{ $data->where('status', 'dibayar')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Diproses</h5>
                            <h3 class="text-warning">{{ $data->where('status', 'diproses')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Dikirim</h5>
                            <h3 class="text-success">{{ $data->where('status', 'dikirim')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="text-muted">Batal</h5>
                            <h3 class="text-danger">{{ $data->where('status', 'batal')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <form action="" method="get">
                        <select class="form-select d-inline-block w-auto" name="status" id="statusFilter" onchange="this.form.submit()">
                            <option value="">Pilih Status</option>
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="dibayar">Dibayar</option>
                            <option value="dikonfirmasi">Dikonfirmasi</option>
                            <option value="diproses">Diproses</option>
                            <option value="diterima">diterima</option>
                            <option value="batal">Batal</option>
                        </select>
                    </form>
                </div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#downloadModal">
                    <span class="pc-micon"><i class="ti ti-file-download me-2"></i></span>
                    Download PDF Report
                </button>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive table-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Jlh Transaksi Pelanggan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr
                                    @if (
                                            ($item->status == 'pending') ||
                                            ($item->status == 'dibayar')
                                        )
                                        class="bg-warning text-white"
                                    @endif
                                >
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_transaksi }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>x{{ $item->user->transaksi_count }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge text-bg-secondary">Pending</span>
                                        @elseif ($item->status == 'dibayar')
                                            <span class="badge text-bg-info">Dibayar</span>
                                        @elseif ($item->status == 'dikonfirmasi')
                                            <span class="badge text-bg-warning">Dikonfirmasi</span>
                                        @elseif ($item->status == 'diproses')
                                            <span class="badge text-bg-secondary">Diproses</span>
                                        @elseif ($item->status == 'dikirim')
                                            <span class="badge text-bg-success">Dikirim</span>
                                        @elseif ($item->status == 'diterima')
                                            <span class="badge text-bg-success">Diterima</span>
                                        @else
                                            <span class="badge text-bg-danger">Batal</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="ti ti-eye me-1"></i>Detail
                                        </a>

                                        @can('isAdmin')
                                        @if($item->status == 'dibayar')
                                        <form action="{{ route('transaksi.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="ti ti-settings me-1"></i>Proses
                                            </button>
                                        </form>
                                        @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Jlh Transaksi Pelanggan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Download Report -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Download Laporan Transaksi PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transaksi.download.report') }}" method="GET">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Laporan akan berisi detail transaksi lengkap dengan informasi produk, pelanggan, dan status dalam format PDF yang siap untuk dicetak atau dibagikan.
                        </div>
                        <div class="mb-3 d-none">
                            <label for="status" class="form-label">Filter Status Transaksi</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="dibayar" {{ request()->status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                <option value="dikonfirmasi" {{ request()->status == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="diproses" {{ request()->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ request()->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="dikirim" {{ request()->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="batal" {{ request()->status == 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Pilih rentang tanggal</label>
                            <div class="input-daterange input-group" id="pc-datepicker-5">
                                <input type="date" class="form-control text-left" placeholder="mulai tanggal" name="start">
                                <span class="input-group-text">sampai</span>
                                <input type="date" class="form-control text-end" placeholder="sampai tanggal" name="end">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="downloadBtn">
                            <i class="ti ti-file-download me-2"></i>Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/plugins/datepicker-full.min.js') }}"></script>
<script>
    function filterTable() {
        const filter = document.getElementById('statusFilter').value.toLowerCase();
        const table = document.getElementById('dom-jqry');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const statusCell = rows[i].getElementsByTagName('td')[4]; // Status column
            if (statusCell) {
                const statusText = statusCell.textContent.toLowerCase();
                if (filter === '' || statusText.includes(filter)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }

    // Handle download form submission
    document.querySelector('#downloadModal form').addEventListener('submit', function(e) {
        const downloadBtn = document.getElementById('downloadBtn');
        const originalText = downloadBtn.innerHTML;

        // Show loading state
        downloadBtn.innerHTML = '<i class="ti ti-loader me-2"></i>Membuat PDF...';
        downloadBtn.disabled = true;

        // Auto-hide modal after a delay
        setTimeout(function() {
            $('#downloadModal').modal('hide');
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }, 1000);
    });
</script>
@endpush

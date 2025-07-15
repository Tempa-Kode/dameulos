@extends('layouts.app')

@section('halaman', 'Dashboard')

@section('content')
<!-- KPI Cards -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2 f-w-400 text-white-50">Total Pelanggan</h6>
                        <h4 class="mb-3 text-white">{{ number_format($totalPelanggan) }}</h4>
                        <small class="text-white-50">Registered users</small>
                    </div>
                    <div class="display-4 text-white-50">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2 f-w-400 text-white-50">Pendapatan Bulan Ini</h6>
                        <h4 class="mb-3 text-white">Rp {{ number_format($thisMonthPendapatan, 0, ',', '.') }}</h4>
                        <small class="text-white-50">
                            @if($pendapatanGrowth >= 0)
                                <i class="ti ti-trending-up"></i> +{{ number_format($pendapatanGrowth, 1) }}%
                            @else
                                <i class="ti ti-trending-down"></i> {{ number_format($pendapatanGrowth, 1) }}%
                            @endif
                        </small>
                    </div>
                    <div class="display-4 text-white-50">
                        <i class="ti ti-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2 f-w-400 text-white-50">Transaksi Bulan Ini</h6>
                        <h4 class="mb-3 text-white">{{ number_format($thisMonthTransaksi) }}</h4>
                        <small class="text-white-50">
                            @if($transaksiGrowth >= 0)
                                <i class="ti ti-trending-up"></i> +{{ number_format($transaksiGrowth, 1) }}%
                            @else
                                <i class="ti ti-trending-down"></i> {{ number_format($transaksiGrowth, 1) }}%
                            @endif
                        </small>
                    </div>
                    <div class="display-4 text-white-50">
                        <i class="ti ti-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2 f-w-400 text-white-50">Produk Aktif</h6>
                        <h4 class="mb-3 text-white">{{ number_format($totalJenisProduk) }}</h4>
                        <small class="text-white-50">{{ $totalPengiriman }} pengiriman</small>
                    </div>
                    <div class="display-4 text-white-50">
                        <i class="ti ti-package"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mt-4">
    <!-- Sales Chart -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Tren Pendapatan & Transaksi (6 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Transaction Status -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Status Transaksi</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables Row -->
<div class="row mt-4">
    <!-- Recent Transactions -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Transaksi Terbaru</h5>
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerakhir as $transaksi)
                            <tr>
                                <td>
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="text-primary">
                                        {{ $transaksi->kode_transaksi }}
                                    </a>
                                </td>
                                <td>{{ $transaksi->user->name ?? 'Guest' }}</td>
                                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                <td>
                                    @if ($transaksi->status == 'pending')
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif ($transaksi->status == 'dibayar')
                                        <span class="badge bg-info">Dibayar</span>
                                    @elseif ($transaksi->status == 'dikonfirmasi')
                                        <span class="badge bg-warning">Dikonfirmasi</span>
                                    @elseif ($transaksi->status == 'diproses')
                                        <span class="badge bg-primary">Diproses</span>
                                    @elseif ($transaksi->status == 'dikirim')
                                        <span class="badge bg-success">Dikirim</span>
                                    @elseif ($transaksi->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Batal</span>
                                    @endif
                                </td>
                                <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Produk Terlaris</h5>
            </div>
            <div class="card-body">
                @foreach($produkTerlaris as $produk)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">{{ $produk->nama }}</h6>
                        <small class="text-muted">{{ $produk->detail_transaksi_count }} terjual</small>
                    </div>
                    <div>
                        <span class="badge bg-primary">{{ $produk->detail_transaksi_count }}</span>
                    </div>
                </div>
                @if(!$loop->last)
                    <hr class="my-2">
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Insights Row -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-primary">📈 Insight Pendapatan</h6>
                        <p class="mb-0">
                            @if($pendapatanGrowth > 0)
                                <span class="text-success">Pendapatan meningkat {{ number_format($pendapatanGrowth, 1) }}% dari bulan lalu</span>
                            @elseif($pendapatanGrowth < 0)
                                <span class="text-danger">Pendapatan menurun {{ number_format(abs($pendapatanGrowth), 1) }}% dari bulan lalu</span>
                            @else
                                <span class="text-muted">Pendapatan stabil dari bulan lalu</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-success">🛒 Insight Transaksi</h6>
                        <p class="mb-0">
                            @if($transaksiGrowth > 0)
                                <span class="text-success">Transaksi meningkat {{ number_format($transaksiGrowth, 1) }}% dari bulan lalu</span>
                            @elseif($transaksiGrowth < 0)
                                <span class="text-danger">Transaksi menurun {{ number_format(abs($transaksiGrowth), 1) }}% dari bulan lalu</span>
                            @else
                                <span class="text-muted">Transaksi stabil dari bulan lalu</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-warning">⚠️ Insight Operasional</h6>
                        <p class="mb-0">
                            @if($statusTransaksi['pending'] > 5)
                                <span class="text-warning">{{ $statusTransaksi['pending'] }} transaksi pending perlu perhatian</span>
                            @elseif($statusTransaksi['dikonfirmasi'] > 3)
                                <span class="text-info">{{ $statusTransaksi['dikonfirmasi'] }} transaksi siap diproses</span>
                            @else
                                <span class="text-success">Operasional berjalan lancar</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Predictions & Performance Row -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-info">🔮 Prediksi Akhir Bulan</h6>
                        <p class="mb-1">
                            <small class="text-muted">Estimasi Transaksi:</small><br>
                            <strong>{{ number_format($predictedTransaksi, 0) }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Estimasi Pendapatan:</small><br>
                            <strong>Rp {{ number_format($predictedPendapatan, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-secondary">📊 Performance Harian</h6>
                        <p class="mb-1">
                            <small class="text-muted">Avg Transaksi/Hari:</small><br>
                            <strong>{{ number_format($avgTransaksiPerDay, 1) }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Avg Pendapatan/Hari:</small><br>
                            <strong>Rp {{ number_format($avgPendapatanPerDay, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-left-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-dark">🎯 Rekomendasi Aksi</h6>
                        <p class="mb-0">
                            @if($statusTransaksi['pending'] > 5)
                                <span class="text-danger">Prioritas: Proses {{ $statusTransaksi['pending'] }} pending order</span>
                            @elseif($statusTransaksi['dikonfirmasi'] > 3)
                                <span class="text-warning">Fokus: Proses {{ $statusTransaksi['dikonfirmasi'] }} order dikonfirmasi</span>
                            @elseif($transaksiGrowth < -10)
                                <span class="text-info">Strategi: Tingkatkan promosi produk</span>
                            @else
                                <span class="text-success">Pertahankan: Performa operasional baik</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-primary btn-block">
                            <i class="ti ti-shopping-cart"></i> Kelola Transaksi
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('produk.index') }}" class="btn btn-success btn-block">
                            <i class="ti ti-package"></i> Kelola Produk
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('pengiriman.index') }}" class="btn btn-warning btn-block">
                            <i class="ti ti-truck"></i> Kelola Pengiriman
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('transaksi.download.report') }}" class="btn btn-info btn-block">
                            <i class="ti ti-download"></i> Download Report
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('pengiriman.download.report') }}" class="btn btn-secondary btn-block">
                            <i class="ti ti-file-report"></i> Report Pengiriman
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.index') }}" class="btn btn-dark btn-block">
                            <i class="ti ti-settings"></i> Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .border-left-secondary {
        border-left: 4px solid #6c757d !important;
    }
    .border-left-dark {
        border-left: 4px solid #343a40 !important;
    }
    .btn-block {
        width: 100%;
        margin-bottom: 10px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($monthlyStats)->pluck('month')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(collect($monthlyStats)->pluck('pendapatan')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Transaksi',
                data: {!! json_encode(collect($monthlyStats)->pluck('transaksi')) !!},
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Pendapatan (Rp)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Dibayar', 'Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Batal'],
            datasets: [{
                data: [
                    {{ $statusTransaksi['pending'] }},
                    {{ $statusTransaksi['dibayar'] }},
                    {{ $statusTransaksi['dikonfirmasi'] }},
                    {{ $statusTransaksi['diproses'] }},
                    {{ $statusTransaksi['dikirim'] }},
                    {{ $statusTransaksi['selesai'] ?? 0 }},
                    {{ $statusTransaksi['batal'] }}
                ],
                backgroundColor: [
                    '#6c757d',
                    '#17a2b8',
                    '#ffc107',
                    '#007bff',
                    '#28a745',
                    '#20c997',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endpush

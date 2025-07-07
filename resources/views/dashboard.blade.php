@extends('layouts.app')

@section('halaman', 'Dashboard')

@section('content')
<!-- [ sample-page ] start -->
<div class="col-md-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total Pelanggan</h6>
            <h4 class="mb-3">{{ $totalPelanggan }}</h4>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total Jenis Produk</h6>
            <h4 class="mb-3">{{ $totalJenisProduk }}</h4>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Transaksi Tahun Ini</h6>
            <h4 class="mb-3">{{ $totalTransaksi }}</h4>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Pendapatan Tahun Ini</h6>
            <h4 class="mb-3">{{ $totalPendapatan }}</h4>
        </div>
    </div>
</div>

<div class="col-md-12 col-xl-8">
    <h5 class="mb-3">Transaksi Terakhir</h5>
    <div class="card tbl-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>KODE TRX</th>
                            <th>PELANGGAN</th>
                            <th>ONGKIR</th>
                            <th>STATUS</th>
                            <th class="text-end">TOTAL TRANSAKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Camera Lens</td>
                            <td>40</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-danger f-10 m-r-5"></i>
                                    Rejected
                                </span>
                            </td>
                            <td class="text-end">$40,570</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Laptop</td>
                            <td>300</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-warning f-10 m-r-5"></i>
                                    Pending
                                </span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Mobile</td>
                            <td>355</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-success f-10 m-r-5"></i>
                                    Approved
                                </span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Camera Lens</td>
                            <td>40</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-danger f-10 m-r-5"></i>
                                    Rejected
                                </span>
                            </td>
                            <td class="text-end">$40,570</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Laptop</td>
                            <td>300</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-warning f-10 m-r-5"></i>
                                    Pending
                                </span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Mobile</td>
                            <td>355</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-success f-10 m-r-5"></i>
                                    Approved
                                </span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Camera Lens</td>
                            <td>40</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-danger f-10 m-r-5"></i>
                                    Rejected
                                </span>
                            </td>
                            <td class="text-end">$40,570</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Laptop</td>
                            <td>300</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-circle text-warning f-10 m-r-5"></i>
                                    Pending
                                </span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Mobile</td>
                            <td>355</td>
                            <td><span class="d-flex align-items-center gap-2"><i
                                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="text-muted">84564564</a></td>
                            <td>Mobile</td>
                            <td>355</td>
                            <td><span class="d-flex align-items-center gap-2"><i
                                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                            </td>
                            <td class="text-end">$180,139</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <h5 class="mb-3">Income Overview</h5>
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
            <h3 class="mb-3">$7,650</h3>
            <div id="income-overview-chart"></div>
        </div>
    </div>
</div>

<div class="col-md-12 col-xl-8">
    <h5 class="mb-3">Sales Report</h5>
    <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
            <h3 class="mb-0">$7,650</h3>
            <div id="sales-report-chart"></div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <h5 class="mb-3">Analytics Report</h5>
    <div class="card">
        <div class="list-group list-group-flush">
            <a href="#"
                class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                Finance Growth<span class="h5 mb-0">+45.14%</span></a>
            <a href="#"
                class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                Expenses Ratio<span class="h5 mb-0">0.58%</span></a>
            <a href="#"
                class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Business
                Risk Cases<span class="h5 mb-0">Low</span></a>
        </div>
        <div class="card-body px-2">
            <div id="analytics-report-chart"></div>
        </div>
    </div>
</div>
@endsection

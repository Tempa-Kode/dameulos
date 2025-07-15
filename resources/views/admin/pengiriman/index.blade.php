@extends('layouts.app')

@section('halaman', 'Pengiriman')

@section('judul', 'Data Pengiriman')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex gap-2">
                    <a href="{{ route('pengiriman.download.report') }}" class="btn btn-success">
                        <span class="pc-micon"><i class="ti ti-download me-2"></i></span>
                        Download Report
                    </a>
                    <a href="{{ route('pengiriman.preview.report') }}" class="btn btn-info" target="_blank">
                        <span class="pc-micon"><i class="ti ti-eye me-2"></i></span>
                        Preview Report
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Resi</th>
                                <th>Nama Penerima</th>
                                <th>Kode Transaksi</th>
                                <th>Status Transaksi</th>
                                <th>Ongkir</th>
                                <th>Berat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_resi }}</td>
                                    <td>{{ $item->nama_penerima }}</td>
                                    <td>{{ $item->transaksi->kode_transaksi ?? '-' }}</td>
                                    <td>
                                        @if($item->transaksi)
                                            @if ($item->transaksi->status == 'pending')
                                                <span class="badge text-bg-secondary">Pending</span>
                                            @elseif ($item->transaksi->status == 'dibayar')
                                                <span class="badge text-bg-info">Dibayar</span>
                                            @elseif ($item->transaksi->status == 'dikonfirmasi')
                                                <span class="badge text-bg-warning">Dikonfirmasi</span>
                                            @elseif ($item->transaksi->status == 'diproses')
                                                <span class="badge text-bg-secondary">Diproses</span>
                                            @elseif ($item->transaksi->status == 'dikirim')
                                                <span class="badge text-bg-success">Dikirim</span>
                                            @else
                                                <span class="badge text-bg-danger">Batal</span>
                                            @endif
                                        @else
                                            <span class="badge text-bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                                    <td>{{ $item->berat }} kg</td>
                                    <td>
                                        <a href="{{ route('pengiriman.show', $item->id) }}" class="btn btn-info btn-sm me-1">
                                            <i class="ti ti-eye me-1"></i>Detail
                                        </a>
                                        <a href="{{ route('pengiriman.print.label', $item->id) }}" class="btn btn-warning btn-sm" target="_blank">
                                            <i class="ti ti-printer me-1"></i>Label
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No Resi</th>
                                <th>Nama Penerima</th>
                                <th>Kode Transaksi</th>
                                <th>Status Transaksi</th>
                                <th>Ongkir</th>
                                <th>Berat</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

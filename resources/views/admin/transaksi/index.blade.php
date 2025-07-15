@extends('layouts.app')

@section('halaman', 'Transaksi')

@section('judul', 'Data Transaksi')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-success float-end">
                    <span class="pc-micon"><i class="ti ti-download me-2"></i></span>
                    Download Report
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
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_transaksi }}</td>
                                    <td>{{ $item->user->name }}</td>
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
                                        <form action="{{ route('transaksi.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dikirim">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="ti ti-truck me-1"></i>Kirim
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
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
@endsection

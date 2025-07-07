@extends('layouts.app')

@section('halaman', 'Transaksi')

@section('judul', 'Data Transaksi')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Status</th>
                                <th>Total</th>
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
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif ($item->status == 'dikonfirmasi')
                                            <span class="badge badge-success">Dikonfirmasi</span>
                                        @elseif ($item->status == 'diproses')
                                            <span class="badge badge-danger">Diproses</span>
                                        @elseif ($item->status == 'dikirim')
                                            <span class="badge badge-danger">Dikirim</span>
                                        @else
                                            <span class="badge badge-secondary">Unknown</span>
                                        @endif
                                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
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
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

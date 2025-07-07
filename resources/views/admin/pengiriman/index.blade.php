@extends('layouts.app')

@section('halaman', 'Pengiriman')

@section('judul', 'Data Pengiriman')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-success">
                    <span class="pc-micon"><i class="ti ti-download me-2"></i></span>
                    Download Report
                </button>
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
                                    <td>Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                                    <td>{{ $item->berat }}</td>
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
                                <th>Pelangggan</th>
                                <th>No Resi</th>
                                <th>Ongkir</th>
                                <th>Alamat Pengiriman</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

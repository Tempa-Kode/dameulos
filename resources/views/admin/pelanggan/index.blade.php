@extends('layouts.app')

@section('halaman', 'Pelanggan')

@section('judul', 'Data Pelanggan')

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('pelanggan.report') }}" class="btn btn-success">
                    <span class="pc-micon"><i class="ti ti-download me-2"></i></span>
                    Download Report
                </a>
            </div>
            <div class="card-body">
                {{-- Include komponen alert --}}
                @include('components.alert')

                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Diinput Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('pelanggan.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pelaggan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Diinput Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(adminId, adminName) {
            if (confirm(`Apakah Anda yakin ingin menghapus admin "${adminName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                document.getElementById('delete-form-' + adminId).submit();
            }
        }
    </script>
@endsection

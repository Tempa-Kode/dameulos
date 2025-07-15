<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengiriman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            color: #7f8c8d;
            margin: 5px 0;
            font-size: 16px;
        }
        .header p {
            color: #95a5a6;
            margin: 5px 0;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .summary-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin-bottom: 10px;
            flex: 1;
            margin-right: 10px;
            min-width: 150px;
        }
        .summary-item:last-child {
            margin-right: 0;
        }
        .summary-item h3 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-size: 14px;
        }
        .summary-item p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #3498db;
        }
        .status-summary {
            margin-bottom: 30px;
        }
        .status-summary h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .status-grid {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .status-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            flex: 1;
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
        }
        .status-item:last-child {
            margin-right: 0;
        }
        .status-item h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #7f8c8d;
        }
        .status-item p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .pending { border-left: 4px solid #95a5a6; }
        .dibayar { border-left: 4px solid #17a2b8; }
        .dikonfirmasi { border-left: 4px solid #ffc107; }
        .diproses { border-left: 4px solid #6c757d; }
        .dikirim { border-left: 4px solid #28a745; }
        .batal { border-left: 4px solid #dc3545; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .badge-secondary { background-color: #6c757d; }
        .badge-info { background-color: #17a2b8; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #7f8c8d;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAME ULOS</h1>
        <h2>Laporan Data Pengiriman</h2>
        <p>Periode: {{ now()->format('d F Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
    
    <h3>Detail Data Pengiriman</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Resi</th>
                <th>Penerima</th>
                <th>Kode Transaksi</th>
                <th>Status</th>
                <th>Ongkir</th>
                <th>Berat</th>
                <th>Tanggal</th>
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
                            <span class="badge badge-secondary">Pending</span>
                        @elseif ($item->transaksi->status == 'dibayar')
                            <span class="badge badge-info">Dibayar</span>
                        @elseif ($item->transaksi->status == 'dikonfirmasi')
                            <span class="badge badge-warning">Dikonfirmasi</span>
                        @elseif ($item->transaksi->status == 'diproses')
                            <span class="badge badge-secondary">Diproses</span>
                        @elseif ($item->transaksi->status == 'dikirim')
                            <span class="badge badge-success">Dikirim</span>
                        @else
                            <span class="badge badge-danger">Batal</span>
                        @endif
                    @else
                        <span class="badge badge-secondary">-</span>
                    @endif
                </td>
                <td>Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                <td>{{ $item->berat }} kg</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Dame Ulos</p>
        <p>{{ config('app.name') }} - Tenun Tradisional Berkualitas</p>
    </div>
</body>
</html>

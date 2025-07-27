<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #2c3e50;
        }

        .header h2 {
            font-size: 18px;
            margin: 10px 0;
            color: #34495e;
        }

        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .info-item {
            flex: 1;
        }

        .info-item strong {
            color: #2c3e50;
        }

        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 10px;
        }

        .summary-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
            border: 1px solid #dee2e6;
        }

        .summary-card h3 {
            margin: 0 0 10px 0;
            color: #6c757d;
            font-size: 14px;
        }

        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
            font-size: 9px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-pending {
            background-color: #6c757d;
            color: white;
        }

        .status-dibayar {
            background-color: #17a2b8;
            color: white;
        }

        .status-dikonfirmasi {
            background-color: #ffc107;
            color: black;
        }

        .status-diproses {
            background-color: #6c757d;
            color: white;
        }

        .status-dikirim {
            background-color: #28a745;
            color: white;
        }

        .status-batal {
            background-color: #dc3545;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 110px; vertical-align: top; border: none;">
                    <img src="images/logo-dameulos.png" alt="Dame Ulos Logo" style="width: 100px; height: auto;">
                </td>
                <td style="text-align: center; border: none;">
                    <div style="font-size: 20px; font-weight: bold; color: #2c3e50;">DAME ULOS</div>
                    <h2 style="margin: 0; color: #34495e;">Laporan Produk</h2>
                </td>
            </tr>
        </table>
    </div>

    @if($produkData->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Katalog</th>
                <th width="25%">Nama Produk</th>
                <th width="15%">Harga</th>
                <th width="15%">Stok</th>
                <th width="10%">Jlh Terjual</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $itemCount = 0; @endphp
            @foreach($produkData as $item)
                <tr>
                    <td class="text-center">{{ $no }}</td>
                    <td>{{ $item->katalog->nama }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->stok }}</td>
                    <td class="text-center">{{ $item->jumlah_terjual ?? '-' }}</td>
                </tr>
                @php
                    $no++;
                    $itemCount++;
                @endphp
            @endforeach
        </tbody>
    </table>

    @else
    <div style="text-align: center; padding: 50px; color: #6c757d;">
        <h3>Tidak ada data transaksi untuk status yang dipilih</h3>
    </div>
    @endif

    <div style="margin-top: 60px; display: flex; justify-content: flex-end;">
        <div style="text-align: right;">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 70px;">Manajer Dame Ulos,</p>
            <p style="margin-top: 0; font-weight: bold; text-decoration: underline;">IVAN PRATAMA PANGGABEAN</p>
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem Dame Ulos pada {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>

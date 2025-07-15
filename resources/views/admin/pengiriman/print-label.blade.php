<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Pengiriman - {{ $pengiriman->no_resi }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            color: #333;
        }

        .label-container {
            max-width: 100%;
            margin: 0 auto;
            border: 2px solid #333;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .label-body {
            padding: 20px;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            min-width: 120px;
        }

        .info-value {
            flex: 1;
            text-align: right;
        }

        .address-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .address-box {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }

        .address-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .address-content {
            font-size: 12px;
            line-height: 1.5;
        }

        .barcode-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
            margin: 10px 0;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .products-table th,
        .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .products-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .products-table td:last-child {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin: 15px 0;
            font-size: 12px;
        }

        .tracking-info {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }

        .tracking-number {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 5px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .label-container {
                border: 2px solid #333;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="label-container">
        <!-- Header -->
        <div class="header">
            <h1>DAME ULOS</h1>
            <p>Label Pengiriman</p>
        </div>

        <div class="label-body">
            <!-- Tracking Information -->
            <div class="tracking-info">
                <div class="tracking-number">{{ $pengiriman->no_resi }}</div>
                <div>Nomor Resi Pengiriman</div>
            </div>

            <!-- Address Section -->
            <div class="address-section">
                <div class="address-box">
                    <div class="address-title">📤 PENGIRIM</div>
                    <div class="address-content">
                        <strong>Dame Ulos</strong><br>
                        {{ $pengiriman->alamat_pengiriman }}<br>
                        <strong>Telp:</strong> (0633) 123-4567
                    </div>
                </div>

                <div class="address-box">
                    <div class="address-title">📥 PENERIMA</div>
                    <div class="address-content">
                        <strong>{{ $pengiriman->nama_penerima }}</strong><br>
                        {{ $pengiriman->alamat_penerima }}<br>
                        <strong>Telp:</strong> {{ $pengiriman->transaksi->user->phone ?? '-' }}
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="section">
                <div class="section-title">Informasi Pengiriman</div>
                <div class="info-row">
                    <span class="info-label">Kode Transaksi:</span>
                    <span class="info-value">{{ $pengiriman->transaksi->kode_transaksi }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Kirim:</span>
                    <span class="info-value">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Berat:</span>
                    <span class="info-value">{{ $pengiriman->berat }} kg</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ongkir:</span>
                    <span class="info-value">Rp {{ number_format($pengiriman->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        @if ($pengiriman->transaksi->status == 'dikirim')
                            <strong style="color: #28a745;">DIKIRIM</strong>
                        @else
                            <strong style="color: #ffc107;">SIAP KIRIM</strong>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Product Details -->
            <div class="section">
                <div class="section-title">Detail Produk</div>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Ukuran</th>
                            <th>Warna</th>
                            <th>Qty</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengiriman->transaksi->detailTransaksi as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama }}</td>
                            <td>{{ $detail->ukuranProduk->nama ?? '-' }}</td>
                            <td>{{ $detail->jenisWarnaProduk->nama ?? '-' }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 10px; text-align: right;">
                    <strong>Total: Rp {{ number_format($pengiriman->transaksi->total, 0, ',', '.') }}</strong>
                </div>
            </div>

            <!-- Barcode Section -->
            <div class="barcode-section">
                <div>Kode Tracking</div>
                <div class="barcode-text">{{ $pengiriman->no_resi }}</div>
                <div style="font-size: 10px; color: #666;">
                    Scan atau ketik kode di atas untuk tracking
                </div>
            </div>

            <!-- Important Notes -->
            <div class="important-note">
                <strong>Catatan Penting:</strong><br>
                • Barang sudah dicek dan dikemas dengan baik<br>
                • {{ $pengiriman->catatan ?: 'Tidak ada catatan khusus' }}<br>
                • Hubungi customer service jika ada kendala: (0633) 123-4567
            </div>

            <!-- Footer -->
            <div class="footer">
                <div>Label dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</div>
                <div>Dame Ulos - Tenun Tradisional Berkualitas</div>
            </div>
        </div>
    </div>

    <!-- Print Button (hidden when printing) -->
    <div class="no-print" style="text-align: center; margin: 20px 0;">
        <button onclick="window.print()" style="background-color: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">
            🖨️ Cetak Label
        </button>
        <button onclick="window.close()" style="background-color: #95a5a6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            ✖️ Tutup
        </button>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // };

        // Auto close after printing (optional)
        window.onafterprint = function() {
            // window.close();
        };
    </script>
</body>
</html>

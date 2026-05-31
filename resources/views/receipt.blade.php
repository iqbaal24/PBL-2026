<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Pesanan - {{ $payload['order_number'] }}</title>
    @include('partials.favicon')
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #d9782a;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            vertical-align: top;
            padding-bottom: 5px;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #666;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f9f9f9;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #eee;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .items-table .text-right {
            text-align: right;
        }
        .total-section {
            margin-left: auto;
            margin-top: 20px;
            width: 260px;
        }
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .total-label,
        .total-value {
            display: table-cell;
        }
        .total-label {
            color: #555;
        }
        .total-value {
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            border-top: 2px solid #eee;
            margin-top: 8px;
            padding-top: 8px;
        }
        .grand-total .total-value {
            font-size: 20px;
            font-weight: bold;
            color: #d9782a;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #eee;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Harapan Jaya Digital Printing</h1>
        <p>Jl. Semanggi Barat 5C Jatimulyo</p>
        <p>WhatsApp: 082142117750 | Email: harapanjaya366@gmail.com</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Nomor Pesanan</td>
                <td>: {{ $payload['order_number'] }}</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal Lacak</td>
                <td>: {{ now()->translatedFormat('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="info-label">Status Terakhir</td>
                <td>: <span class="status-badge">{{ $payload['current_status']['label'] }}</span></td>
            </tr>
            <tr>
                <td class="info-label">WhatsApp Pembeli</td>
                <td>: {{ $payload['whatsapp'] }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Spesifikasi</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payload['items'] as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['specification'] ?: '-' }}</td>
                    <td class="text-right">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Subtotal Produk</span>
            <span class="total-value">Rp {{ number_format($payload['item_subtotal'], 0, ',', '.') }}</span>
        </div>
        @if($payload['shipping_fee'] != 0)
            <div class="total-row">
                <span class="total-label">Ongkos Kirim</span>
                <span class="total-value">Rp {{ number_format($payload['shipping_fee'], 0, ',', '.') }}</span>
            </div>
        @endif
        @if($payload['design_fee'] != 0)
            <div class="total-row">
                <span class="total-label">Biaya Desain</span>
                <span class="total-value">Rp {{ number_format($payload['design_fee'], 0, ',', '.') }}</span>
            </div>
        @endif
        <div class="total-row grand-total">
            <span class="total-label">Total Keseluruhan</span>
            <span class="total-value">Rp {{ number_format($payload['total_price'], 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih telah mempercayakan kebutuhan cetak Anda kepada kami.</p>
        <p>Nota ini adalah dokumen digital resmi dari sistem tracking Harapan Jaya Digital Printing.</p>
    </div>
</body>
</html>

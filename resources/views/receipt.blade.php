<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Pesanan - {{ $payload['order_number'] }}</title>
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
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
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
                <th>Varian</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($payload['items'] as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['variant_name'] ?: '-' }}</td>
                    <td class="text-right">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
                @php $grandTotal += $item['subtotal']; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p>Total Pembayaran:</p>
        <p class="total-amount">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih telah mempercayakan kebutuhan cetak Anda kepada kami.</p>
        <p>Nota ini adalah dokumen digital resmi dari sistem tracking Harapan Jaya Digital Printing.</p>
    </div>
</body>
</html>

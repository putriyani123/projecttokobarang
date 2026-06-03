<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - GlowBeauty</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            color: #2d1b22;
            background: #fff;
            padding: 30px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ff2e7e;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #ff2e7e;
            margin-bottom: 4px;
        }
        .header p {
            color: #888;
            font-size: 11px;
        }
        .header .date-range {
            margin-top: 8px;
            font-size: 11px;
            color: #555;
            font-weight: 600;
        }

        .summary-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .summary-card {
            flex: 1;
            background: linear-gradient(135deg, #fff1f7 0%, #ffe8f0 100%);
            border: 1px solid #ffc0d6;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }
        .summary-card .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .summary-card .value {
            font-size: 18px;
            font-weight: 700;
            color: #ff2e7e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead th {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }
        thead th:first-child { border-radius: 8px 0 0 0; }
        thead th:last-child { border-radius: 0 8px 0 0; }
        tbody tr { border-bottom: 1px solid #f0e0e8; }
        tbody tr:nth-child(even) { background: #fdf5f8; }
        tbody tr:hover { background: #fff0f5; }
        tbody td {
            padding: 10px 12px;
            font-size: 11px;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 600; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-paid { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .badge-shipped { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .badge-delivered { background: #e0e7ff; color: #3730a3; border: 1px solid #a5b4fc; }
        .badge-completed { background: #d1fae5; color: #047857; border: 1px solid #34d399; }
        .badge-failed { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .items-list {
            font-size: 10px;
            color: #666;
            line-height: 1.6;
        }
        .items-list .item-name { font-weight: 600; color: #333; }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ffe0ec;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #999;
        }

        /* Print Controls */
        .print-controls {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 12px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .print-controls span {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
        }
        .print-controls .btn-group { display: flex; gap: 10px; }
        .print-controls button {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-print {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
        }
        .btn-print:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(255,46,126,0.4); }
        .btn-back {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2) !important;
        }
        .btn-back:hover { background: rgba(255,255,255,0.2); }

        @media print {
            .print-controls { display: none !important; }
            body { padding: 15px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            thead th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .summary-card { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <!-- Print Controls Bar -->
    <div class="print-controls">
        <span>📄 Preview Laporan Transaksi</span>
        <div class="btn-group">
            <button class="btn-back" onclick="window.history.back()">← Kembali</button>
            <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        </div>
    </div>

    <div style="margin-top: 60px;">
        <!-- Header -->
        <div class="header">
            <h1>💎 GlowBeauty</h1>
            <p>Laporan Riwayat Transaksi</p>
            <div class="date-range">Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="label">Total Transaksi</div>
                <div class="value">{{ $transactions->count() }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Transaksi Lunas</div>
                <div class="value">{{ $transactions->whereIn('status', ['paid','shipped','delivered','completed'])->count() }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($transactions->whereIn('status', ['paid','shipped','delivered','completed'])->sum('total_price'), 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th style="width:30px;">No</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th class="text-center">Status</th>
                    <th>Tanggal</th>
                    <th>No. Resi</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $index => $trx)
                <tr>
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-bold" style="font-size:10px;">{{ $trx->midtrans_order_id ?? 'TRX-'.$trx->id }}</td>
                    <td>{{ $trx->user->name ?? 'Guest' }}</td>
                    <td>
                        <div class="items-list">
                            @foreach($trx->items as $item)
                                <div>
                                    <span class="item-name">{{ $item->product->name ?? 'Produk dihapus' }}</span>
                                    <span>({{ $item->qty }}x @ Rp {{ number_format($item->price, 0, ',', '.') }})</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $statusMap = [
                                'paid' => ['label' => 'Lunas', 'class' => 'badge-paid'],
                                'pending' => ['label' => 'Menunggu', 'class' => 'badge-pending'],
                                'shipped' => ['label' => 'Dikirim', 'class' => 'badge-shipped'],
                                'delivered' => ['label' => 'Terkirim', 'class' => 'badge-delivered'],
                                'completed' => ['label' => 'Selesai', 'class' => 'badge-completed'],
                                'failed' => ['label' => 'Gagal', 'class' => 'badge-failed'],
                            ];
                            $s = $statusMap[$trx->status] ?? ['label' => $trx->status, 'class' => 'badge-pending'];
                        @endphp
                        <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                    </td>
                    <td style="font-size:10px;">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td style="font-size:10px;">{{ $trx->tracking_number ?? '-' }}</td>
                    <td class="text-right font-bold" style="color:#ff2e7e;">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #fff1f7; border-top: 2px solid #ff2e7e;">
                    <td colspan="7" class="text-right font-bold" style="padding: 12px; font-size: 12px; color: #333;">GRAND TOTAL</td>
                    <td class="text-right font-bold" style="padding: 12px; font-size: 14px; color: #ff2e7e;">Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div>© {{ date('Y') }} GlowBeauty — Laporan ini dibuat secara otomatis</div>
            <div>Halaman 1</div>
        </div>
    </div>

</body>
</html>

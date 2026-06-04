<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan #{{ $transaction->midtrans_order_id ?? $transaction->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px;}
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Invoice Pesanan</h2>
        <p>GlowBeauty</p>
    </div>

    <div class="details">
        <p><strong>ID Transaksi:</strong> {{ $transaction->midtrans_order_id ?? 'TRX-'.$transaction->id }}</p>
        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
        <p><strong>Status:</strong> {{ strtoupper($transaction->status) }}</p>
        <br>
        <p><strong>Nama Pemesan:</strong> {{ $transaction->user->name ?? 'Guest' }}</p>
        <p><strong>Alamat Pengiriman:</strong> 
            @if($transaction->address)
                {{ $transaction->user->name ?? 'Guest' }} (-)<br>
                {{ $transaction->address->detail_address ?? '' }}, {{ $transaction->address->village ?? '' }}, {{ $transaction->address->district ?? '' }}, {{ $transaction->address->city ?? '' }}, {{ $transaction->address->province ?? '' }}
            @else
                Tidak ada informasi alamat.
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
            <tr>
                <td>
                    {{ $item->product->name ?? 'Produk dihapus' }}
                    @if($item->box_color || $item->greeting_card || $item->custom_message)
                        <br>
                        <small>
                            @if($item->box_color) Box: {{ $item->box_color }} | @endif
                            @if($item->greeting_card) Kartu: {{ $item->greeting_card }} | @endif
                            @if($item->custom_message) Pesan: "{{ $item->custom_message }}" @endif
                        </small>
                    @endif
                </td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">Total Belanja</td>
                <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>

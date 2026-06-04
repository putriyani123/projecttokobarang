<table>
    <tr>
        <th colspan="4" style="text-align: center; font-weight: bold; font-size: 14px;">Invoice Pesanan #{{ $transaction->midtrans_order_id ?? $transaction->id }}</th>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td><strong>Tanggal</strong></td>
        <td colspan="3">{{ $transaction->created_at->format('d M Y H:i') }}</td>
    </tr>
    <tr>
        <td><strong>Status</strong></td>
        <td colspan="3">{{ strtoupper($transaction->status) }}</td>
    </tr>
    <tr>
        <td><strong>Nama Pemesan</strong></td>
        <td colspan="3">{{ $transaction->user->name ?? 'Guest' }}</td>
    </tr>
    <tr>
        <td><strong>Alamat Pengiriman</strong></td>
        <td colspan="3">
            @if($transaction->address)
                {{ $transaction->user->name ?? 'Guest' }} (-) - 
                {{ $transaction->address->detail_address ?? '' }}, {{ $transaction->address->village ?? '' }}, {{ $transaction->address->district ?? '' }}, {{ $transaction->address->city ?? '' }}, {{ $transaction->address->province ?? '' }}
            @else
                Tidak ada informasi alamat.
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th style="font-weight: bold; border: 1px solid #000;">Produk</th>
        <th style="font-weight: bold; border: 1px solid #000;">Harga Satuan</th>
        <th style="font-weight: bold; border: 1px solid #000;">Qty</th>
        <th style="font-weight: bold; border: 1px solid #000;">Subtotal</th>
    </tr>
    @foreach($transaction->items as $item)
    <tr>
        <td style="border: 1px solid #000;">
            {{ $item->product->name ?? 'Produk dihapus' }}
            @if($item->box_color || $item->greeting_card || $item->custom_message)
                (
                @if($item->box_color) Box: {{ $item->box_color }}, @endif
                @if($item->greeting_card) Kartu: {{ $item->greeting_card }}, @endif
                @if($item->custom_message) Pesan: "{{ $item->custom_message }}" @endif
                )
            @endif
        </td>
        <td style="border: 1px solid #000;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
        <td style="border: 1px solid #000;">{{ $item->qty }}</td>
        <td style="border: 1px solid #000;">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold; border: 1px solid #000;">Total Belanja</td>
        <td style="font-weight: bold; border: 1px solid #000;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
    </tr>
</table>

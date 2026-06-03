<h1>Riwayat Transaksi</h1>

@foreach($data as $trx)
    <div>
        <p>Total: Rp {{ $trx->total_price }}</p>
        <p>Status: {{ $trx->status }}</p>
    </div>
@endforeach
<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>

    <style>
        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        table, th, td{
            border:1px solid #ffc2d1;
        }

        th, td{
            padding:10px;
        }

        th {
            background-color: #fff0f3;
            color: #ff2e7e;
        }
    </style>
</head>
<body>

<h2>Data Transaksi</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $trx)
        <tr>
            <td>{{ $trx->id }}</td>
            <td>{{ $trx->status }}</td>
            <td>Rp {{ number_format($trx->total_price) }}</td>
            <td>{{ $trx->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
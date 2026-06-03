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
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #ffc2d1;
        }

        th, td{
            padding:10px;
            text-align:left;
        }

        th {
            background-color: #fff0f3;
            color: #ff2e7e;
        }

        h2{
            text-align:center;
        }
    </style>
</head>
<body>

<h2>Laporan Transaksi</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user->name ?? '-' }}</td>
            <td>Rp {{ number_format($transaction->total_price) }}</td>
            <td>{{ $transaction->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
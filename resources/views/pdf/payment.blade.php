<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Laporan Pembayaran</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Order</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->order_id }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td>{{ $payment->payment_status }}</td>
            <td>{{ $payment->payment_date }}</td>
            <td>Rp {{ number_format($payment->amount,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

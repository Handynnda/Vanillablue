<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Order</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Laporan Order</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Paket</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer->name ?? '-' }}</td>
            <td>{{ $order->bundling->name_bundling ?? '-' }}</td>
            <td>{{ $order->book_date }}</td>
            <td>{{ $order->order_status }}</td>
            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

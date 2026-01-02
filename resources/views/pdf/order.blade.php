<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Order VanillaBlue</title>
    <style>
        /* RESET & DASAR */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
        .header-container {
            width: 100%;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-left h1 {
            margin: 0;
            color: #2d3748; /* Warna Biru Gelap */
            font-size: 18pt;
            text-transform: uppercase;
        }
        .header-left p {
            margin: 2px 0;
            font-size: 9pt;
            color: #718096;
        }
        .header-right {
            text-align: right;
            float: right;
            margin-top: -50px; /* Hack float untuk DOMPDF */
        }
        .report-title {
            font-size: 14pt;
            font-weight: bold;
            color: #2d3748;
        }

        /* TABEL DATA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        
        /* Header Tabel */
        th {
            background-color: #2d3748; /* Warna Tema */
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }

        /* Zebra Striping (Baris Genap beda warna) */
        tr:nth-child(even) {
            background-color: #f7fafc;
        }

        /* KOLOM KHUSUS */
        .col-right { text-align: right; }
        .col-center { text-align: center; }
        
        /* BADGE STATUS */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-success, .status-paid { background-color: #c6f6d5; color: #22543d; } /* Hijau */
        .status-pending { background-color: #fefcbf; color: #744210; } /* Kuning */
        .status-cancel, .status-failed { background-color: #fed7d7; color: #822727; } /* Merah */

        /* FOOTER & TOTAL */
        .footer-summary {
            margin-top: 20px;
            width: 100%;
            text-align: right;
        }
        .total-box {
            display: inline-block;
            background: #edf2f7;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .grand-total {
            font-size: 12pt;
            font-weight: bold;
            color: #2d3748;
        }

        /* TANDA TANGAN */
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .sign-column {
            width: 30%;
            float: right;
            text-align: center;
        }
        .sign-line {
            margin-top: 70px;
            border-bottom: 1px solid #333;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="header-left">
            <h1>VanillaBlue Studio</h1>
            <p>Jalan Jenderal Sudirman No. 175 Awirarangan, Kuningan</p>
            <p>Email: vanillabluephotography@gmail.com | WA: 0812-3456-7890</p>
        </div>
        <div class="header-right">
            <div class="report-title">LAPORAN ORDER</div>
            <p>Dicetak: {{ date('d/m/Y H:i') }}</p>
            <p>Oleh: {{ auth()->user()->name ?? 'Admin' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%" class="col-center">No</th>
                <th style="width: 20%">Customer</th>
                <th style="width: 20%">Paket</th>
                <th style="width: 15%">Tanggal Booking</th>
                <th style="width: 15%" class="col-center">Status</th>
                <th style="width: 25%" class="col-right">Total Harga</th>
            </tr>
        </thead>
 <tbody>
        @php $grandTotal = 0; @endphp
        
        @forelse ($orders as $index => $order)
        <tr>
            {{-- Tampilkan semua data (termasuk unpaid) --}}
            <td class="col-center">{{ $index + 1 }}</td>
            <td>
                <strong>{{ $order->customer->name ?? 'Guest' }}</strong><br>
                <small style="color:#718096">ID: #{{ $order->id }}</small>
            </td>
            <td>{{ $order->bundling->name_bundling ?? '-' }}</td>
            <td>
                {{ \Carbon\Carbon::parse($order->book_date)->format('d/m/Y') }}
                <br>
                <small>{{ \Carbon\Carbon::parse($order->book_date)->format('H:i') }} WIB</small>
            </td>
            <td class="col-center">
                @php
                    $statusClass = 'badge';
                    $status = strtolower($order->order_status);
                    
                    if($status == 'success' || $status == 'paid') {
                        $statusClass .= ' status-success';
                    } elseif($status == 'pending') {
                        $statusClass .= ' status-pending';
                    } else {
                        $statusClass .= ' status-cancel';
                    }
                @endphp
                <span class="{{ $statusClass }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </td>
            <td class="col-right">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                
                {{-- Opsi tambahan: Beri tanda kecil jika tidak dihitung --}}
                @if(strtolower($order->order_status) == 'unpaid')
                    <br><small style="color: red; font-style: italic;">(Tidak dihitung)</small>
                @endif
            </td>
        </tr>

        {{-- LOGIKA UTAMA: Hanya tambahkan ke Grand Total jika BUKAN unpaid --}}
        @if(strtolower($order->order_status) != 'unpaid')
            @php $grandTotal += $order->total_price; @endphp
        @endif

        @empty
        <tr>
            <td colspan="6" class="col-center" style="padding: 20px;">Tidak ada data order pada periode ini.</td>
        </tr>
        @endforelse
    </tbody>
    </table>

    <div class="footer-summary">
        <div class="total-box">
            <span>Total Pendapatan:</span><br>
            <span class="grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="signature-section">
        <div class="sign-column">
            <p>Mengetahui,<br>Owner</p>
            <div class="sign-line"></div>
        </div>
    </div>

</body>
</html>
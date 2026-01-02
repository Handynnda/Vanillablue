<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran VanillaBlue</title>
    <style>
        /* DASAR */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* HEADER FIX: Menghilangkan tabrakan garis */
        .header-table {
            width: 100%;
            /* Garis bawah dipindahkan ke sini agar tidak menimpa teks */
            border-bottom: 2px solid #2d3748; 
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .header-table td {
            vertical-align: bottom;
            border: none !important; /* Memastikan tidak ada border internal td */
            padding: 0;
        }
        .studio-info h1 {
            margin: 0;
            color: #2d3748;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .studio-info p {
            margin: 2px 0;
            font-size: 8pt;
            color: #718096;
        }
        .report-info {
            text-align: right;
        }
        .report-info .report-title {
            font-size: 14pt;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .report-info p {
            margin: 0;
            font-size: 8.5pt;
            line-height: 1.4;
        }

        /* TABEL DATA */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            background-color: #2d3748;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            padding: 10px 8px;
            text-align: left;
            border: none;
        }
        .data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .col-right { text-align: right; }
        .col-center { text-align: center; }
        
        /* BADGE STATUS */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-success { background-color: #c6f6d5; color: #22543d; }
        .status-waiting { background-color: #fefcbf; color: #744210; }
        .status-failed { background-color: #fed7d7; color: #822727; }

        /* FOOTER TOTAL */
        .footer-summary {
            margin-top: 20px;
        }
        .total-box {
            float: right;
            background: #edf2f7;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: right;
            min-width: 200px;
        }
        .total-label { font-size: 8pt; color: #4a5568; }
        .grand-total { font-size: 12pt; font-weight: bold; color: #2d3748; display: block; }

        /* TANDA TANGAN (KOSONG UNTUK TULIS TANGAN) */
        .signature-wrapper {
            margin-top: 50px;
            width: 100%;
        }
        .sign-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .sign-space { margin-top: 80px; } /* Ruang kosong untuk ttd */
        .sign-line { 
            border-bottom: 1px solid #333; 
            width: 180px; 
            margin: 0 auto; 
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="studio-info">
                <h1>VANILLABLUE STUDIO</h1>
                <p>Jalan Jenderal Sudirman No. 175 Awirarangan, Kuningan</p>
                <p>Email: vanillabluephotography@gmail.com | WA: 0812-3456-7890</p>
            </td>
            <td class="report-info">
                <div class="report-title">LAPORAN PEMBAYARAN</div>
                @if(isset($startDate) && isset($endDate))
                    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                @endif
                <p>Dicetak: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="col-center" style="width: 5%;">NO</th>
                <th style="width: 25%;">INFO PEMBAYARAN</th>
                <th style="width: 15%;">METODE</th>
                <th style="width: 20%;">TANGGAL BAYAR</th>
                <th class="col-center" style="width: 15%;">STATUS</th>
                <th class="col-right" style="width: 20%;">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            @php $totalUangMasuk = 0; @endphp
            @forelse($payments as $index => $payment)
            <tr>
                <td class="col-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $payment->payment_code ?? 'N/A' }}</strong><br>
                    <span style="color: #718096; font-size: 8pt;">Order ID: #{{ $payment->order_id }}</span>
                </td>
                <td>{{ strtoupper(str_replace('_', ' ', $payment->payment_method)) }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                <td class="col-center">
                    @php
                        $status = strtolower($payment->payment_status);
                        $badgeClass = 'badge';

                        if ($status === 'confirmed') {
                            $badgeClass .= ' status-success';
                        } elseif ($status === 'waiting') {
                            $badgeClass .= ' status-waiting';
                        } elseif ($status === 'rejected') {
                            $badgeClass .= ' status-failed';
                        }
                    @endphp
                    <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                </td>
                <td class="col-right">
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </td>
            </tr>
            @php 
                if (strtolower($payment->payment_status) === 'confirmed') {
                    $totalUangMasuk += $payment->amount;
                }
            @endphp
            @empty
            <tr>
                <td colspan="6" class="col-center" style="padding: 30px;">Tidak ada data pembayaran pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-summary">
        <div class="total-box">
            <span class="total-label">Total Pendapatan (Verified):</span>
            <span class="grand-total">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</span>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="signature-wrapper">
        <div class="sign-box">
            <p>Mengetahui,<br>Owner VanillaBlue</p>
            <div class="sign-space"></div>
            <div class="sign-line"></div>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
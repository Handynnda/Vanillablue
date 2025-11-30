<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="{{ asset('assets/css/stylePayment.css') }}?v={{ filemtime(public_path('assets/css/stylePayment.css')) }}">
</head>

<body>
    @include('header')
    <div class="payment-page">
        <div class="payment-wrapper">
            <div class="payment-header">
                <h2>Pembayaran</h2>
                <p>Silakan lengkapi data pembayaran Anda</p>
            </div>

            <div class="order-summary">
                <div class="item">
                    <span>Paket</span>
                    <strong>{{ $order->bundling_id }}</strong>
                </div>
                <div class="item">
                    <span>Tanggal</span>
                    <strong>{{ $order->book_date }}</strong>
                </div>
                <div class="item">
                    <span>Jam</span>
                    <strong>{{ $order->book_time }}</strong>
                </div>
                <div class="item">
                    <span>Lokasi</span>
                    <strong>{{ $order->location === 'indoor' ? 'Indoor (Photo Studio)' : 'Outdoor' }}</strong>
                </div>
                <div class="item">
                    <span>Total</span>
                    <strong>Rp {{ number_format($order->total_price,0,',','.') }}</strong>
                </div>
                <div class="item">
                    <span>Status Order</span>
                    <strong>{{ $order->order_status }}</strong>
                </div>
            </div>

            @if(session('error'))
            <div class="booking-error" style="margin-bottom:20px">{{ session('error') }}</div>
            @endif

            <form action="{{ route('payment.store') }}" method="POST" class="payment-form"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="field">
                    <label for="amount">Jumlah (Otomatis)</label>
                    <input type="number" id="amount" name="amount" value="{{ $order->total_price }}" readonly>
                </div>

                <div class="field">
                    <label for="payment_date">Tanggal Pembayaran</label>
                    <input type="date" id="payment_date" name="payment_date"
                        value="{{ old('payment_date', date('Y-m-d')) }}" required>
                </div>

                <div class="field">
                    <label for="payment_method">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="bank_a" {{ old('payment_method')==='bank_a' ? 'selected' : '' }}>BANK A</option>
                        <option value="bank_b" {{ old('payment_method')==='bank_b' ? 'selected' : '' }}>BANK B</option>
                        <option value="bank_c" {{ old('payment_method')==='bank_c' ? 'selected' : '' }}>BANK C</option>
                    </select>
                    <div class="method-hint">Pilih bank tujuan transfer.</div>
                </div>

                <div class="field full">
                    <label for="proof_image">Bukti Transfer (Opsional)</label>
                    <input type="file" id="proof_image" name="proof_image" accept="image/*">
                </div>

                <div class="actions">
                    <button type="submit">KIRIM PEMBAYARAN</button>
                </div>
            </form>

            <div class="payment-note">Pembayaran akan diverifikasi terlebih dahulu. Simpan bukti transfer Anda.</div>
        </div>
    </div>
    @include('footer')
</body>
</html>
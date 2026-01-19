<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pembayaran - Vanillablue Photostudio</title>

    <link rel="stylesheet" href="{{ asset('assets/css/stylePayment.css') }}?v={{ filemtime(public_path('assets/css/stylePayment.css')) }}">

    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
</head>

<body>
@include('header')

<div class="payment-page">
    <div class="payment-wrapper">

        <div class="payment-header">
            <h2>Pembayaran</h2>
            <p>Pembayaran Vanillablue Photostudio</p>
        </div>

        <div class="order-summary">
            <div class="item">
                <span>Order ID</span>
                <strong>{{ $order->id }}</strong>
            </div>

            <div class="item">
                <span>Paket</span>
                <strong>{{ $order->bundling->name_bundling }}</strong>
            </div>

            <div class="item">
                <span>Tanggal</span>
                <strong>{{ \Carbon\Carbon::parse($order->book_date)->translatedFormat('d F Y') }}</strong>
            </div>

            <div class="item">
                <span>Jam</span>
                <strong>{{ $order->book_time }}</strong>
            </div>

            <div class="item">
                <span>Lokasi</span>
                <strong>{{ $order->location === 'indoor' ? 'Indoor (Photo Studio)' : 'Outdoor' }}</strong>
            </div>

            <div class="item total-highlight">
                <span>Total Pembayaran</span>
                <strong>Rp {{ number_format($order->total_price,0,',','.') }}</strong>
            </div>
        </div>

        @if(session('error'))
            <div class="section-card" style="border-color:#fecaca; background:#fff1f2;">
                <div class="section-title" style="color:#991b1b;">
                    ❌ Terjadi Kesalahan
                </div>
                <p class="section-subtitle" style="margin:0; color:#b91c1c;">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <div class="section-card">
            <div class="section-title">
                💳 Metode Pembayaran yang Tersedia
            </div>

            <p class="section-subtitle">
                Berikut adalah metode pembayaran yang tersedia saat checkout.
            </p>

            <div class="methods-grid">
                <div class="method-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/100px-Gopay_logo.svg.png" alt="GoPay">
                    <span>GoPay</span>
                </div>

                <div class="method-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/100px-Logo_dana_blue.svg.png" alt="DANA">
                    <span>DANA</span>
                </div>

                <div class="method-item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYNwo4nu3FX4ZVVahdlgBKSIo3CuJxGxdE6A&s" alt="Transfer Bank">
                    <span>Transfer Bank</span>
                </div>

                <div class="method-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/100px-QRIS_logo.svg.png" alt="QRIS">
                    <span>QRIS</span>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="agreement-box">
                <input type="checkbox" id="agreement" name="agreement">

                <label for="agreement">
                    <strong>Saya memahami dan menyetujui bahwa:</strong><br>
                    • DP tidak dapat dikembalikan.<br>
                    • DP dinyatakan hangus apabila jadwal pemotretan terlewat tanpa kehadiran atau konfirmasi ulang.<br>
                    • Pembayaran akan diproses melalui Midtrans dengan batas waktu 24 jam.
                </label>
            </div>
        </div>

        <div class="actions">
            <button type="button" id="pay-button" class="pay-btn" disabled>
                <span id="btn-text">BAYAR SEKARANG</span>

                <span id="btn-loading" style="display:none;">
                    <svg class="spinner" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="30 70"></circle>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>

        <div class="payment-note">
            <div class="secure-line">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Pembayaran aman melalui <strong>Midtrans</strong>
            </div>

            <p>Transaksi akan otomatis kedaluwarsa setelah 24 jam jika tidak diselesaikan.</p>
        </div>

    </div>
</div>

@include('footer')

<div id="statusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:16px; max-width:400px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.3); text-align:center;">
        <div id="modal-icon" style="font-size:48px; margin-bottom:16px;">✅</div>
        <h3 id="modal-title" style="margin:0 0 12px; font-size:20px; font-weight:700;"></h3>
        <p id="modal-message" style="margin:0 0 24px; color:#6b7280;"></p>
        <button type="button" onclick="closeStatusModal()" style="padding:12px 30px; background:#3b82f6; color:white; border:none; border-radius:10px; cursor:pointer; font-weight:700; font-size:14px;">
            OK
        </button>
    </div>
</div>

<script>
    const orderId = "{{ $order->id }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const payButton = document.getElementById('pay-button');
    const agreementCheckbox = document.getElementById('agreement');

    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    agreementCheckbox.addEventListener('change', function () {
        payButton.disabled = !this.checked;
    });

    payButton.addEventListener('click', async function () {
        if (!agreementCheckbox.checked) {
            showStatusModal('warning', '⚠️', 'Perhatian', 'Mohon centang persetujuan terlebih dahulu');
            return;
        }

        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        payButton.disabled = true;

        try {
            const response = await fetch('{{ route("midtrans.snap-token") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ order_id: orderId })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Gagal membuat transaksi');
            }

            window.snap.pay(data.snap_token, {
                onSuccess: async function (result) {
                    try {
                        await fetch('{{ route("midtrans.update-status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: orderId,
                                transaction_status: result.transaction_status || 'settlement',
                                transaction_id: result.transaction_id || null,
                                payment_type: result.payment_type || null
                            })
                        });
                    } catch (e) {}

                    window.location.href = '{{ route("home") }}?payment_success=true&payment_id=' + orderId;
                },

                onPending: async function (result) {
                    try {
                        await fetch('{{ route("midtrans.update-status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: orderId,
                                transaction_status: 'pending',
                                transaction_id: result.transaction_id || null,
                                payment_type: result.payment_type || null
                            })
                        });
                    } catch (e) {}

                    showStatusModal('pending', '⏳', 'Pembayaran Pending', 'Silakan selesaikan pembayaran Anda. Anda akan diarahkan ke halaman utama.');

                    setTimeout(() => {
                        window.location.href = '{{ route("home") }}?payment_success=true&payment_id=' + orderId;
                    }, 3000);
                },

                onError: function () {
                    showStatusModal('error', '❌', 'Pembayaran Gagal', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                    resetButton();
                },

                onClose: function () {
                    resetButton();
                }
            });

        } catch (error) {
            showStatusModal('error', '❌', 'Error', error.message || 'Terjadi kesalahan. Silakan coba lagi.');
            resetButton();
        }
    });

    function resetButton() {
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        payButton.disabled = !agreementCheckbox.checked;
    }

    function showStatusModal(type, icon, title, message) {
        const modal = document.getElementById('statusModal');
        const iconEl = document.getElementById('modal-icon');
        const titleEl = document.getElementById('modal-title');
        const messageEl = document.getElementById('modal-message');

        iconEl.textContent = icon;
        titleEl.textContent = title;
        messageEl.textContent = message;

        if (type === 'success') {
            titleEl.style.color = '#059669';
        } else if (type === 'error') {
            titleEl.style.color = '#dc2626';
        } else if (type === 'pending') {
            titleEl.style.color = '#d97706';
        } else {
            titleEl.style.color = '#374151';
        }

        modal.style.display = 'flex';
    }

    function closeStatusModal() {
        document.getElementById('statusModal').style.display = 'none';
    }

    document.getElementById('statusModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeStatusModal();
        }
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - Vanillablue Photostudio</title>

    <link rel="stylesheet"
        href="{{ asset('assets/css/stylePayment.css') }}?v={{ filemtime(public_path('assets/css/stylePayment.css')) }}">
    
    <!-- Midtrans Snap JS -->
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

        {{-- RINGKASAN ORDER --}}
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
                <strong>
                    {{ \Carbon\Carbon::parse($order->book_date)->translatedFormat('d F Y') }}
                </strong>
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
            <div class="booking-error" style="margin-bottom:20px">
                {{ session('error') }}
            </div>
        @endif

        {{-- METODE PEMBAYARAN INFO --}}
        <div class="payment-methods-info" style="background: #f0f9ff; padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #0ea5e9;">
            <h4 style="margin: 0 0 12px; color: #0369a1; font-size: 16px;">💳 Metode Pembayaran yang Tersedia</h4>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/100px-Gopay_logo.svg.png" alt="GoPay" style="height: 24px;">
                    <span>GoPay</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/100px-Logo_dana_blue.svg.png" alt="DANA" style="height: 24px;">
                    <span>DANA</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_OVO.svg/100px-Logo_OVO.svg.png" alt="OVO" style="height: 24px;">
                    <span>OVO</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/100px-QRIS_logo.svg.png" alt="QRIS" style="height: 24px;">
                    <span>QRIS</span>
                </div>
            </div>
        </div>

        {{-- CHECKBOX PERSETUJUAN --}}
        <div class="field full" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: flex-start; gap: 10px; padding: 15px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px;">
                <input type="checkbox" id="agreement" name="agreement" style="margin-top: 3px; width: 18px; height: 18px; cursor: pointer;">
                <label for="agreement" style="font-size: 13px; line-height: 1.6; color: #856404; cursor: pointer; margin: 0;">
                    <strong>Saya memahami dan menyetujui bahwa:</strong><br>
                    • DP tidak dapat dikembalikan.<br>
                    • DP dinyatakan hangus apabila jadwal pemotretan terlewat tanpa kehadiran atau konfirmasi ulang.<br>
                    • Pembayaran akan diproses melalui Midtrans dengan batas waktu 24 jam.
                </label>
            </div>
        </div>

        {{-- TOMBOL BAYAR --}}
        <div class="actions">
            <button type="button" id="pay-button" class="pay-btn" disabled>
                <span id="btn-text">BAYAR SEKARANG</span>
                <span id="btn-loading" style="display: none;">
                    <svg class="spinner" viewBox="0 0 24 24" style="width: 20px; height: 20px; animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="30 70"></circle>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>

        <div class="payment-note">
            <div style="display: flex; align-items: center; gap: 8px; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Pembayaran aman melalui <strong>Midtrans</strong>
            </div>
            <p style="margin-top: 8px; font-size: 12px; color: #6b7280;">
                Transaksi akan otomatis kedaluwarsa setelah 24 jam jika tidak diselesaikan.
            </p>
        </div>

    </div>
</div>

@include('footer')

{{-- MODAL STATUS --}}
<div id="statusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; max-width:400px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.3); text-align: center;">
        <div id="modal-icon" style="font-size: 48px; margin-bottom: 16px;">✅</div>
        <h3 id="modal-title" style="margin:0 0 12px; font-size:20px; font-weight:700;"></h3>
        <p id="modal-message" style="margin:0 0 24px; color:#6b7280;"></p>
        <button type="button" onclick="closeStatusModal()" style="padding:12px 30px; background:#3b82f6; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
            OK
        </button>
    </div>
</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .pay-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        padding: 16px 48px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 220px;
    }
    
    .pay-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
    }
    
    .pay-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }
    
    .total-highlight {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        padding: 16px !important;
        border-radius: 8px;
        border: 2px solid #0ea5e9;
    }
    
    .total-highlight strong {
        color: #0369a1;
        font-size: 1.2em;
    }
    
    .spinner {
        animation: spin 1s linear infinite;
    }
</style>

<script>
    const orderId = "{{ $order->id }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const payButton = document.getElementById('pay-button');
    const agreementCheckbox = document.getElementById('agreement');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    // Enable button when agreement is checked
    agreementCheckbox.addEventListener('change', function() {
        payButton.disabled = !this.checked;
    });

    // Pay button click handler
    payButton.addEventListener('click', async function() {
        if (!agreementCheckbox.checked) {
            showStatusModal('warning', '⚠️', 'Perhatian', 'Mohon centang persetujuan terlebih dahulu');
            return;
        }

        // Show loading state
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        payButton.disabled = true;

        try {
            // Request Snap Token from server
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

            // Open Snap popup
            window.snap.pay(data.snap_token, {
                onSuccess: async function(result) {
                    console.log('Payment Success:', result);
                    
                    // Update payment status via API (fallback for webhook)
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
                    } catch (e) {
                        console.warn('Failed to update status via API:', e);
                    }
                    
                    // Redirect to home with success message
                    window.location.href = '{{ route("home") }}?payment_success=true&payment_id=' + orderId;
                },
                onPending: async function(result) {
                    console.log('Payment Pending:', result);
                    
                    // Update payment status via API
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
                    } catch (e) {
                        console.warn('Failed to update status via API:', e);
                    }
                    
                    showStatusModal('pending', '⏳', 'Pembayaran Pending', 'Silakan selesaikan pembayaran Anda. Anda akan diarahkan ke halaman utama.');
                    setTimeout(() => {
                        window.location.href = '{{ route("home") }}?payment_success=true&payment_id=' + orderId;
                    }, 3000);
                },
                onError: function(result) {
                    console.log('Payment Error:', result);
                    showStatusModal('error', '❌', 'Pembayaran Gagal', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                    resetButton();
                },
                onClose: function() {
                    console.log('Snap popup closed');
                    resetButton();
                }
            });

        } catch (error) {
            console.error('Error:', error);
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

        // Set title color based on type
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

    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStatusModal();
        }
    });
</script>

</body>
</html>

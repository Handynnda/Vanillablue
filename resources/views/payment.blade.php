<!DOCTYPE html>
<html lang="id">
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

        {{-- RINGKASAN ORDER --}}
        <div class="order-summary">
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
            <div class="booking-error" style="margin-bottom:20px">
                {{ session('error') }}
            </div>
        @endif

        {{-- FORM PEMBAYARAN --}}
        <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data" class="payment-form">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            {{-- JUMLAH DP --}}
            <div class="field">
                <label>Jumlah (DP minimal 50%)</label>
                <input
                    type="text"
                    id="amount"
                    name="amount"
                    data-total="{{ $order->total_price }}"
                    autocomplete="off"
                    placeholder="Contoh: 100.000"
                    required
                >

                <small id="amount-error-min" style="color:#dc2626; display:none;">
                    Minimal pembayaran 50% dari total.
                </small>

                <small id="amount-error-max" style="color:#dc2626; display:none;">
                    Jumlah pembayaran melebihi total harga.
                </small>
            </div>

            {{-- TANGGAL PEMBAYARAN --}}
            <div class="field">
                <label>Tanggal Pembayaran</label>
                <input
                    type="date"
                    id="payment_date"
                    name="payment_date"
                    value="{{ old('payment_date', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                    readonly
                >
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="field">
                <label>Metode Pembayaran</label>

                <select id="payment_method" name="payment_method" class="payment-select" required>
                    <option value="">-- Pilih Bank --</option>
                    <option value="bank_a">BCA</option>
                    <option value="bank_b">DANA</option>
                    <option value="bank_c">BRI</option>
                </select>

        <div id="bank-info" class="bank-info">
            <span id="bank-rek"></span>
                <img src="{{ asset('assets/images/copy.png') }}" class="copy-icon" onclick="copyRek()">
            
        </div>

            </div>

            {{-- BUKTI TRANSFER --}}
            <div class="field full">
                <label>Bukti Transfer</label>
                <input type="file" name="proof_image" accept="image/*" required>
            </div>

            {{-- CHECKBOX PERSETUJUAN --}}
            <div class="field full" style="margin-top: 20px;">
                <div style="display: flex; align-items: flex-start; gap: 10px; padding: 15px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px;">
                    <input type="checkbox" id="agreement" name="agreement" style="margin-top: 3px; width: 18px; height: 18px; cursor: pointer;" required>
                    <label for="agreement" style="font-size: 13px; line-height: 1.6; color: #856404; cursor: pointer; margin: 0;">
                        <strong>Saya memahami dan menyetujui bahwa:</strong><br>
                        • DP tidak dapat dikembalikan.<br>
                        • DP dinyatakan hangus apabila jadwal pemotretan terlewat tanpa kehadiran atau konfirmasi ulang.
                    </label>
                </div>
            </div>

            <div class="actions">
                <button type="button" id="submit-btn" onclick="showConfirmation()">KIRIM PEMBAYARAN</button>
            </div>
        </form>

        <div class="payment-note">
            Pembayaran akan diverifikasi terlebih dahulu. Simpan bukti transfer Anda.
        </div>

    </div>
</div>

@include('footer')

{{-- MODAL KONFIRMASI --}}
<div id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 20px; color:#dc2626; font-size:20px; font-weight:700; text-align:center;">⚠️ Konfirmasi Pembayaran</h3>
        
        <div style="background:#fff3cd; padding:15px; border-radius:8px; margin-bottom:20px; border-left:4px solid #ffc107;">
            <p style="margin:0 0 10px; font-size:14px; line-height:1.7; color:#856404;">
                <strong>Dengan melakukan pembayaran, Anda memahami dan menyetujui bahwa:</strong>
            </p>
            <ul style="margin:10px 0 0 20px; font-size:13px; line-height:1.8; color:#856404;">
                <li>DP tidak dapat dikembalikan.</li>
                <li>DP dinyatakan hangus apabila jadwal pemotretan terlewat tanpa kehadiran atau konfirmasi ulang.</li>
            </ul>
        </div>

        <p style="margin:0 0 25px; font-size:14px; color:#374151; text-align:center;">
            Apakah Anda yakin ingin melanjutkan pembayaran?
        </p>

        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" onclick="closeModal()" style="padding:12px 30px; background:#6b7280; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
                Batal
            </button>
            <button type="button" onclick="submitPayment()" style="padding:12px 30px; background:#3b82f6; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    const amountInput = document.getElementById('amount');
    const errorMin = document.getElementById('amount-error-min');
    const errorMax = document.getElementById('amount-error-max');
    const submitBtn = document.getElementById('submit-btn');

    const bankSelect = document.getElementById('payment_method');
    const bankInfo = document.getElementById('bank-info');
    const bankRek = document.getElementById('bank-rek');

    const totalPrice = parseInt(amountInput.dataset.total);
    const minPayment = totalPrice * 0.5;

    const bankData = {
        bank_a: '0013 5169 2303',
        bank_b: '0857 9720 8591',
        bank_c: '555666777'
    };

    function formatRupiah(value) {
        return value
            .replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    amountInput.addEventListener('input', function () {
        const raw = this.value.replace(/\./g, '');
        const numeric = parseInt(raw || 0);

        this.value = formatRupiah(raw);

        errorMin.style.display = 'none';
        errorMax.style.display = 'none';
        submitBtn.disabled = false;

        if (numeric < minPayment) {
            errorMin.style.display = 'block';
            submitBtn.disabled = true;
        } else if (numeric > totalPrice) {
            errorMax.style.display = 'block';
            submitBtn.disabled = true;
        }
    });

    bankSelect.addEventListener('change', function () {
        if (bankData[this.value]) {
            bankRek.innerText = bankData[this.value];
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }
    });

    function copyRek() {
        if (!bankRek.innerText) return;
        navigator.clipboard.writeText(bankRek.innerText);
        alert('Nomor rekening disalin');
    }

    function showConfirmation() {
        // Validasi form sebelum menampilkan modal
        const form = document.querySelector('.payment-form');
        const agreementCheck = document.getElementById('agreement');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (!agreementCheck.checked) {
            alert('Mohon centang persetujuan terlebih dahulu');
            return;
        }

        // Cek validasi amount
        const raw = amountInput.value.replace(/\./g, '');
        const numeric = parseInt(raw || 0);
        
        if (numeric < minPayment || numeric > totalPrice) {
            alert('Jumlah pembayaran tidak valid');
            return;
        }

        // Tampilkan modal
        const modal = document.getElementById('confirmModal');
        modal.style.display = 'flex';
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        modal.style.display = 'none';
    }

    function submitPayment() {
        const form = document.querySelector('.payment-form');
        form.submit();
    }

    // Tutup modal jika klik di luar box
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

</body>
</html>

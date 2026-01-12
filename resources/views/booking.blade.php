<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - VanillaBlue Studio</title>
    <link rel="stylesheet"
        href="{{ asset('assets/css/styleBooking.css') }}?v={{ filemtime(public_path('assets/css/styleBooking.css')) }}">
    <style>
        /* Desain Grid untuk Jam agar Estetik */
        .time-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(85px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .time-slot {
            padding: 12px 5px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #ffffff;
            color: #1e293b;
        }

        .time-slot:hover:not(.full) {
            border-color: #3b82f6;
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .time-slot.selected {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);
        }

        .time-slot.full {
            background-color: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
            cursor: not-allowed;
            font-size: 12px;
            opacity: 0.8;
        }

        .time-slot.full small {
            display: block;
            font-size: 10px;
            font-weight: bold;
        }

        #time-placeholder {
            grid-column: 1 / -1;
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
        }

        /* Sembunyikan input asli tapi tetap fungsional */
        #jam-hidden {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    @include('header')
    <div class="booking-page">
        <div class="booking-header">
            <h2>Booking</h2>
            <p>Lengkapi data untuk melakukan pemesanan</p>
        </div>
        <div class="booking-card">

            {{-- POPUP SUKSES --}}
            @if(session('success'))
            <div class="booking-popup-overlay" id="successPopup">
                <div class="booking-popup">
                    <h4>Sukses</h4>
                    <p>{{ session('success') }}</p>
                    <a href="{{ url('/home') }}">OK</a>
                </div>
            </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca;">
                <strong>Gagal:</strong> {{ session('error') }}
            </div>
            @endif

            <div class="package-title">{{ $paket->name_bundling }}</div>

            <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                @csrf
                <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                <div class="field-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', Auth::user()->name ?? '') }}" required>

                </div>

                <div class="field-group">
                    <label for="no_wa">Nomor WhatsApp</label>
                    <input type="text" id="no_wa" name="no_wa" value="{{ old('no_wa', Auth::user()->phone ?? '') }}" required>

                </div>

                <div class="field-group">
                    <label for="tanggal">Tanggal Pemotretan</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="field-group full">
                    <label>Pilih Jam Tersedia</label>
                    <div id="time-grid" class="time-grid">
                        <div id="time-placeholder">Silakan pilih tanggal terlebih dahulu untuk melihat ketersediaan jam.</div>
                    </div>
                    <input type="text" id="jam-hidden" name="jam" value="{{ old('jam') }}" required>
                </div>

                <div class="field-group lokasi">
                    <label for="tipe">Lokasi Pemotretan</label>
                    <select id="tipe" name="tipe" required>
                        <option value="indoor" {{ old('tipe')==='indoor' ? 'selected' : '' }}>Indoor (Photo Studio)</option>
                        <option value="outdoor" {{ old('tipe')==='outdoor' ? 'selected' : '' }}>Outdoor</option>
                    </select>
                </div>

                <div class="field-group full">
                    <label for="note">Catatan / Permintaan Khusus (Opsional)</label>
                    <textarea id="note" name="note" placeholder="Contoh: Permintaan lokasi (outdoor), tema pemotretan, dll">{{ old('note') }}</textarea>
                </div>

                <div class="booking-actions">
                    <button type="submit">BOOKING SEKARANG</button>
                </div>
            </form>
        </div>
    </div>
    @include('footer')

    <script>
        // Data booking dari database (dikirim oleh Controller)
        const bookedSlots = @json($bookedSlots);

        const tanggalInput = document.getElementById('tanggal');
        const timeGrid = document.getElementById('time-grid');
        const jamHidden = document.getElementById('jam-hidden');

        // Daftar Jam Operasional Studio
        const timeOptions = [
            "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", 
            "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", 
            "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00"
        ];

        tanggalInput.addEventListener('change', function() {
            const selectedDate = this.value;
            if (selectedDate) {
                renderTimeSlots(selectedDate);
            }
        });

        function renderTimeSlots(date) {
            timeGrid.innerHTML = '';

            const today = new Date().toISOString().split('T')[0];
            const now = new Date();
            const nowTime = now.getHours().toString().padStart(2, '0') + ':' +
                            now.getMinutes().toString().padStart(2, '0');

            const tipe = document.getElementById('tipe').value;

            timeOptions.forEach(time => {
                const slotDiv = document.createElement('div');
                slotDiv.classList.add('time-slot');
                slotDiv.innerText = time;

                const bookings = bookedSlots.filter(slot =>
                    slot.book_date === date &&
                    slot.book_time.substring(0,5) === time
                );

                const isSameLocationBooked = bookings.some(b => b.location === tipe);
                const isPastTime = date === today && time <= nowTime;

                if (isSameLocationBooked || isPastTime) {
                    slotDiv.classList.add('full');
                    slotDiv.innerHTML = `${time}<small>${isPastTime ? 'TERLEWAT' : 'PENUH'}</small>`;
                } else {
                    slotDiv.onclick = function () {
                        document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
                        this.classList.add('selected');
                        jamHidden.value = time;
                    };
                }

                timeGrid.appendChild(slotDiv);
            });
        }

        document.getElementById('tipe').addEventListener('change', function () {
            jamHidden.value = '';
            if (tanggalInput.value) {
                renderTimeSlots(tanggalInput.value);
            }
        });

        function getCurrentTime() {
            const now = new Date();
            return now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0');
        }


        // Jalankan otomatis jika tanggal sudah terisi (misal saat validasi gagal)
        if (tanggalInput.value) {
            renderTimeSlots(tanggalInput.value);
        }
    </script>
</body>

</html>
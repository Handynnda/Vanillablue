@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/styleBooking.css') }}?v={{ filemtime(public_path('assets/css/styleBooking.css')) }}">
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
            <div class="booking-error">{{ session('error') }}</div>
        @endif

        {{-- JUDUL PAKET --}}
        <div class="package-title">{{ $paket->name_bundling }}</div>

        {{-- FORM BOOKING --}}
        <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">

            <div class="field-group">
              <label for="nama">Nama</label>
              <input type="text" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
            </div>
            <div class="field-group">
              <label for="no_wa">Nomor WhatsApp</label>
              <input type="text" id="no_wa" name="no_wa" placeholder="Nomor WhatsApp" value="{{ old('no_wa') }}" required>
            </div>
            <div class="field-group">
              <label for="jam">Jam</label>
              <input type="time" id="jam" name="jam" value="{{ old('jam') }}" required>
            </div>
            <div class="field-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
            </div>
            <div class="field-group">
              <label for="tipe">Lokasi Pemotretan</label>
              <select id="tipe" name="tipe" required>
                <option value="indoor" {{ old('tipe')==='indoor' ? 'selected' : '' }}>Indoor (Photo Studio)</option>
                <option value="outdoor" {{ old('tipe')==='outdoor' ? 'selected' : '' }}>Outdoor</option>
              </select>
            </div>
            <div class="field-group full">
              <label for="note">Catatan / Permintaan Khusus (Opsional)</label>
              <textarea id="note" name="note" placeholder="Contoh: Tema pastel, bawa properti sendiri, dll">{{ old('note') }}</textarea>
            </div>
            <div class="booking-actions">
              <button type="submit">BOOKING</button>
            </div>
        </form>
  </div>
</div>
@endsection

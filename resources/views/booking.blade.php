@extends('layouts.app')

@section('content')
<div style="height: 100vh; background: #f7f7f7; display:flex; flex-direction:column; justify-content:center; align-items:center;">

    <h2 style="font-size: 28px; font-weight:700; color:#1f1f1f; margin-bottom: 25px;">
        Booking
    </h2>

    <div style="
        width: 80%;
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 35px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    ">
      
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:5px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="
        background: #c6c6c6;
        padding: 15px;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
        font-weight: 600;
        margin-bottom: 25px;
    ">
        {{ $paket->name_bundling }}
    </div>

        {{-- FORM --}}
        <form action="{{ route('booking.store') }}" method="POST" style="width: 206%">
            @csrf
              <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <div>
              {{-- Nama dan No WhatsApp --}}
              <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                  <input type="text" name="nama" placeholder="Nama" required
                      style="flex:1; padding: 12px; border: 1px solid #cdd5e0; border-radius: 4px;">
                  <input type="text" name="no_wa" placeholder="Nomor WhatsApp" required
                      style="flex:1; padding: 12px; border: 1px solid #cdd5e0; border-radius: 4px;">
              </div>

              {{-- Waktu dan Tanggal --}}
              <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <input type="time" name="jam" required
                    value=""
                    placeholder="Pilih jam"
                    style="flex:1; padding: 12px; border: 1px solid #cdd5e0; border-radius: 4px;">
                <input type="date" name="tanggal" required
                    value=""
                    placeholder="Pilih tanggal"
                    style="flex:1; padding: 12px; border: 1px solid #cdd5e0; border-radius: 4px;">
                    <select name="tipe" required
                        style="width: 100%; padding: 12px; border: 1px solid #cdd5e0; border-radius: 4px; background: #eceaea;">
                        <option value="indoor">Indoor</option>
                        <option value="outdoor">Outdoor</option>
                    </select>
              </div>

              {{-- Submit Button --}}
              <div style="text-align:center;">
                  <button type="submit"
                      style="background: #1f1f1f; color: white; padding: 10px 35px; border-radius: 4px; border: none; font-size: 14px; letter-spacing: 1px;">
                      BOOKING
                  </button>
              </div>
            </div>
        </form>
    </div>
</div>
@endsection
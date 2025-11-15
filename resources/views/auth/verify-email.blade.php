@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/styleVerifyemail.css') }}">
<div class="verify-container">
    <h2>Verifikasi Email Diperlukan</h2>
    <p>Kami telah mengirimkan link verifikasi ke alamat email kamu.<br>
    Silakan cek email dan klik tautan untuk mengaktifkan akunmu.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>

    <p style="margin-top: 20px;">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="color:#00BFFF; text-decoration:none;">Keluar</a>
    </p>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>
@endsection
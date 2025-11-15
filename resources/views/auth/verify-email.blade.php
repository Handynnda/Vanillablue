@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<style>
    .verify-container {
        text-align: center;
        color: #fff;
    }
    .verify-container h2 {
        font-size: 26px;
        margin-bottom: 15px;
        color: #00BFFF;
    }
    .verify-container p {
        font-size: 15px;
        margin-bottom: 25px;
    }
    .verify-container form {
        display: flex;
        justify-content: center;
    }
    .verify-container button {
        background-color: #00BFFF;
        color: #fff;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 600;
    }
    .verify-container button:hover {
        background-color: #0099cc;
    }
</style>

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
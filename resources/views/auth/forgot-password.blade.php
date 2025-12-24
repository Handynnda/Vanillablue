@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<section class="auth-section">
<link rel="stylesheet" href="{{ asset('assets/css/styleForgetpass.css') }}">
  <div>
    <h2>Lupa Password</h2>

    @if(session('status')) 
      <div style="background: #00BFFF; padding: 8px; border-radius: 4px; text-align:center;">{{ session('status') }}</div> 
    @endif

    <form method="POST" action="{{ route('otp.send') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit" class="btn-submit">Kirim Kode OTP
</button>
    </form>

    <p class="login-text">
      <a href="{{ route('login') }}">Kembali ke Login</a>
    </p>
  </div>
</section>
@endsection
@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<section class="auth-section">
<link rel="stylesheet" href="{{ asset('assets/css/styleForgetpass.css') }}">
<div>
<form method="POST">
  @csrf
  <H1>masukan kode OTP</H1>
  <input type="text" name="otp" placeholder="Kode OTP" required>
  <button type="submit" class="btn-submit2">Verifikasi</button>
</form>

<form method="POST" action="{{ route('otp.resend') }}">
    @csrf
    <button type="submit" class ="btn-submit3" id="resendBtn" disabled> Kirim ulang kode OTP (<span id="timer">60</span>s)</button>
</form>
</div>
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

</section>
@endsection

@section('scripts')
<script>
    let timeLeft = 10;
    const resendBtn = document.getElementById('resendBtn');
    const timerSpan = document.getElementById('timer');

    const countdown = setInterval(() => {
        timeLeft--;
        timerSpan.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false;
            resendBtn.textContent = 'Kirim ulang kode OTP';
        }
    }, 1000);
</script>
@endsection
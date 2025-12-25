@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<section class="auth-section">
<link rel="stylesheet" href="{{ asset('assets/css/styleResetpass.css') }}">

  <div>
    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="email" value="{{ session('email') }}">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password Baru" required>
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
      <button type="submit" class="btn-submit">Reset Password</button>
    </form>

    <p class="login-text">
      <a href="{{ route('login') }}">Kembali ke Login</a>
    </p>
  </div>
</section>
@endsection

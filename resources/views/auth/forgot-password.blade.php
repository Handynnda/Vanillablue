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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="masukan Email terdaftar" required>
        <button class="btn-submit2" type="submit">
            Kirim link reset password
        </button>
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif
    </form>

    <p class="login-text">
      <a href="{{ route('login') }}">Kembali ke Login</a>
    </p>

  </div>
</section>
@endsection
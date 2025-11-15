@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<section class="auth-section">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f0f0;
      margin: 0;
    }

    .auth-section {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 80px 20px;
    }

    .auth-container {
      width: 100%;
      max-width: 500px;
      background: linear-gradient(135deg, #4a5a7c, #2a3b53);
      padding: 40px 30px;
      border-radius: 24px;
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .auth-container h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 30px;
      letter-spacing: 1px;
      text-align: center;
    }

    .auth-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .auth-container input {
      padding: 10px;
      border: none;
      background-color: #e0e0e0;
      border-radius: 4px;
      transition: 0.3s;
      color: #000;
    }

    .auth-container input:focus {
      border: 2px solid #00BFFF;
      outline: none;
      background-color: #fff;
    }

    .btn-submit {
      margin-top: 15px;
      background-color: #00BFFF;
      color: #fff;
      font-weight: 600;
      padding: 12px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
      width: 100%;
    }

    .btn-submit:hover {
      background-color: #0099cc;
    }

    .login-text {
      text-align: center;
      font-size: 13px;
      color: #ddd;
      margin-top: 10px;
    }

    .login-text a {
      color: #00BFFF;
      text-decoration: none;
      font-weight: 600;
    }

  </style>

  <div>
    <h2>Lupa Password</h2>

    @if(session('status')) 
      <div style="background: #00BFFF; padding: 8px; border-radius: 4px; text-align:center;">{{ session('status') }}</div> 
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit" class="btn-submit">Kirim Link Reset Password</button>
    </form>

    <p class="login-text">
      <a href="{{ route('login') }}">Kembali ke Login</a>
    </p>
  </div>
</section>
@endsection
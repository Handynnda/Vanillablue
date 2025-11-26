<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk | VanillaBlue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/styleLogin.css') }}">
</head>

<body>
  @if(session('error'))
    <div style="color: red; background: #ffeaea; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
  @endif
  
  <div class="popup-container">
    <!-- LEFT -->
    <div class="popup-left">
      <img src="assets/images/studiologo.jpg" alt="VanillaBlue Logo">
    </div>

    <!-- RIGHT -->
    <div class="popup-right">
      <a href="home" class="close-btn"><i class="bi bi-x-lg"></i></a>

      <h3>SELAMAT<br><span style="font-weight: 300;">DATANG</span></h3>

      <form action="{{ route('login') }}" method="POST" style="width: 100%;">
        @csrf
        <div class="input-box">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-box">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" placeholder="Kata Sandi" required>
        </div>
        
        @if (session('error'))
          <p style="color: red; text-align:center;">{{ session('error') }}</p>
        @endif

        <button type="submit" class="btn-login">MASUK</button>

        <div class="bottom-links">
          
          <a href="{{ route('register') }}">Belum Punya Akun?</a>
          <a href="{{ route('password.request') }}">Lupa Kata Sandi</a>
        </div>

        <p class="text-center mt-3">ATAU</p>

        <button type="button" class="btn-google" onclick="window.location='{{ route('login.google') }}'">
          <img src="assets/images/googleicon.png" alt=""> GOOGLE
        </button>


        <div class="socials">
          <p>FOLLOW</p>
          <a href="https://www.instagram.com/vanillablue_photostudio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@vanillabluephotostudio?is_from_webapp=1&sender_device=pc"><i class="bi bi-tiktok"></i></a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

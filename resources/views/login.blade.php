<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk | VanillaBlue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Latar belakang halaman */
    body {
      background: url('assets/images/bg-login.jpg') center/cover no-repeat fixed;
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Lapisan gelap blur di belakang popup */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(8px);
      z-index: 0;
    }

    /* Kontainer utama (popup) */
    .popup-container {
      position: relative;
      z-index: 1;
      display: flex;
      width: 850px;
      max-width: 95%;
      border-radius: 20px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 8px 40px rgba(0,0,0,0.4);
      animation: popupIn 0.4s ease-out;
    }

    @keyframes popupIn {
      from { opacity: 0; transform: scale(0.9) translateY(30px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Kiri (logo) */
    .popup-left {
      flex: 1;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .popup-left img {
      width: 80%;
      max-width: 280px;
      object-fit: contain;
    }

    /* Kanan (form login) */
    .popup-right {
      flex: 1;
      background: linear-gradient(160deg, #0b132b, #1c2541);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 2rem 2.5rem;
      position: relative;
    }

    /* Tombol close */
    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      color: #fff;
      font-size: 1.3rem;
      text-decoration: none;
      transition: 0.2s;
    }
    .close-btn:hover { color: #ff5c5c; }

    /* Judul */
    .popup-right h3 {
      font-weight: 700;
      text-align: center;
      margin-bottom: 1rem;
    }

    /* Input */
    .popup-right .input-box {
      position: relative;
      width: 100%;
      margin-bottom: 15px;
    }

    .popup-right .input-box i {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #999;
    }

    .popup-right .input-box input {
      width: 100%;
      padding: 10px 10px 10px 35px;
      border-radius: 8px;
      border: none;
      outline: none;
      font-size: 14px;
    }

    /* Tombol login */
    .btn-login {
      width: 100%;
      background: #007bff;
      color: #fff;
      border: none;
      padding: 10px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: #005eff;
    }

    /* Link bawah */
    .bottom-links {
      display: flex;
      justify-content: space-between;
      margin-top: 8px;
      font-size: 0.9rem;
    }

    .bottom-links a {
      color: #fff;
      text-decoration: none;
    }

    .bottom-links a:hover {
      text-decoration: underline;
    }

    /* Google login */
    .btn-google {
      background: #fff;
      color: #333;
      font-weight: 600;
      border-radius: 8px;
      border: none;
      width: 100%;
      margin-top: 12px;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-google img {
      width: 20px;
      margin-right: 8px;
    }

    /* Social icons */
    .socials {
      text-align: center;
      margin-top: 15px;
    }

    .socials a {
      color: #fff;
      font-size: 1.3rem;
      margin: 0 5px;
      transition: 0.3s;
    }

    .socials a:hover {
      color: #00bfff;
    }

    /* Responsif */
    @media (max-width: 768px) {
      .popup-container {
        flex-direction: column;
        width: 90%;
      }
      .popup-left {
        padding: 20px;
      }
    }
  </style>
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

        <button type="button" class="btn-google">
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

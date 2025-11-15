@include ('header')

<link rel="stylesheet" href="register.css">

<section class="register-section">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f0f0;
      margin: 0;
    }

    .register-section {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 80px 20px;
    }

    .register-container {
      width: 100%;
      max-width: 950px;
      background: linear-gradient(135deg, #4a5a7c, #2a3b53);
      padding: 40px 50px;
      border-radius: 8px;
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .register-container h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }

    .register-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 40px;
    }

    .register-form label {
      display: block;
      font-size: 13px;
      margin-bottom: 5px;
    }

    .register-form input {
      width: 100%;
      padding: 10px;
      border: none;
      background-color: #e0e0e0;
      border-radius: 4px;
      transition: 0.3s;
      color: #000;
    }

    .register-form input:focus {
      border: 2px solid #00BFFF;
      outline: none;
      background-color: #fff;
    }

    .btn-daftar {
      grid-column: 2 / 1;
      margin-top: 20px;
      background-color: #00BFFF;
      color: #fff;
      font-weight: 600;
      padding: 12px 0;
      width: 150px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }

    .btn-daftar:hover {
      background-color: #0099cc;
    }

    .login-text {
      text-align: right;
      font-size: 13px;
      color: #ddd;
      margin-top: 10px;
    }

    .login-text a {
      color: #00BFFF;
      text-decoration: none;
      font-weight: 600;
    }

    .social-follow {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    margin-top: 30px;
    }

    .social-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    }

    .social-wrapper span {
    font-weight: 500;
    font-size: 14px;
    color: #fff;
    }

    .social-icons {
    display: flex;
    gap: 10px;
    }

    .social-icons img {
    width: 22px;
    height: 22px;
    filter: brightness(0) invert(1);
    transition: 0.3s;
    }

    .social-icons img:hover {
    transform: scale(1.1);
    filter: brightness(1) invert(0);
    }

    @media (max-width: 768px) {
      .register-form {
        grid-template-columns: 1fr;
      }
      .login-text {
        text-align: left;
      }
    }

  </style>

  <div class="register-container">
    <h2>DAFTAR</h2>
    <form action="{{ route('register') }}" method="POST" class="register-form">
      @csrf
      <div>
        <label for="name">Username</label>
        <input type="text" name="name" id="name" required>
      </div>
      <div>
        <label for="phone">Nomor Kontak</label>
        <input type="text" name="phone" id="phone" required>
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
      </div>
      <div>
        <label for="address">Alamat</label>
        <input type="text" name="address" id="address" required>
      </div>
      <div>
        <label for="password">Sandi</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div>
        <label for="password_confirmation">Ulangi Kata Sandi</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
      </div>

      <button type="submit" class="btn-daftar">Daftar</button>

      <p class="login-text">Sudah Punya Akun? <a href="{{ route('login') }}">Login</a></p>

      <div class="social-follow">
        <div class="social-wrapper">
            <span>FOLLOW</span>
            <div class="social-icons">
            <a href="https://www.instagram.com/vanillablue_photostudio/"><img src="assets/images/instagram.png" alt="Instagram"></a>
            <a href="https://www.tiktok.com/@vanillablue"><img src="assets/images/tiktok.png" alt="TikTok"></a>
            </div>
        </div>
      </div>
    </form>
  </div>
</section>

@include ('footer')
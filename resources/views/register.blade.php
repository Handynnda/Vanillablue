@include ('header')

<section class="register-section">
<link rel="stylesheet" href="{{ asset('assets/css/styleRegister.css') }}">

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
@include ('header')

<section class="register-section">
    <link rel="stylesheet" href="{{ asset('assets/css/styleRegister.css') }}">

    <div class="register-container">
        <h2>DAFTAR</h2>
        @if (session('success'))
        <div class="alert alert-success"
            style="margin:8px 0; color:#14532d; background:#dcfce7; padding:10px; border-radius:6px;">
            {{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger"
            style="margin:8px 0; color:#7f1d1d; background:#fee2e2; padding:10px; border-radius:6px;">
            {{ session('error') }}</div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger"
            style="margin:8px 0; color:#7f1d1d; background:#fee2e2; padding:10px; border-radius:6px;">
            <ul style="margin:0 0 0 18px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('register') }}" method="POST" class="register-form">
            @csrf
            <div>
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="phone">Nomor Kontak</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>
            <div>
                <label for="password">Sandi</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="password_confirmation">Ulangi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="btn-daftar-wrapper">
                <button type="submit" class="btn-daftar">Daftar</button>
            </div>

            <div class="atau-wrapper">
                <p class="atau">ATAU</p>
            </div>

            <div class="btn-google-wrapper">
                <button type="button" class="btn-google" onclick="window.location='{{ route('login.google') }}'">
                    <img src="assets/images/googleicon.png" alt=""> GOOGLE
                </button>
            </div>

            <p class="login-text">Sudah Punya Akun? <a href="{{ route('login') }}">Login</a></p>

            <div class="social-follow">
                <div class="social-wrapper">
                    <span>FOLLOW</span>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/vanillablue_photostudio/"><img
                                src="assets/images/instagram.png" alt="Instagram"></a>
                        <a href="https://www.tiktok.com/@vanillablue"><img src="assets/images/tiktok.png"
                                alt="TikTok"></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@include ('footer')
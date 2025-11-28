@include('header')

<section class="register-section">
<link rel="stylesheet" href="{{ asset('assets/css/styleRegister.css') }}">
  <div class="register-container">
    <h2>Lengkapi Pendaftaran</h2>
    @if (session('success'))
      <div class="alert alert-success" style="margin:8px 0; color:#14532d; background:#dcfce7; padding:10px; border-radius:6px;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger" style="margin:8px 0; color:#7f1d1d; background:#fee2e2; padding:10px; border-radius:6px;">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger" style="margin:8px 0; color:#7f1d1d; background:#fee2e2; padding:10px; border-radius:6px;">
        <ul style="margin:0 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ route('register.complete.post') }}" method="POST" class="register-form">
      @csrf
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" value="{{ $email ?? '' }}" disabled>
      </div>
      <div>
        <label for="name">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name', $name ?? '') }}" required>
      </div>
      <div>
        <label for="phone">Nomor Kontak</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
      </div>
      <button type="submit" class="btn-daftar">Simpan & Masuk</button>
    </form>
  </div>
</section>

@include('footer')

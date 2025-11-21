@include ('header')
<link rel="stylesheet" href="{{ asset('assets/css/styleGaleri.css') }}">
<section class="galeri-detail">
  <div class="container">
    <h1>{{ $title ?? 'Galeri Foto' }}</h1>
    <p class="subtitle">{{ $subtitle ?? 'Koleksi foto terbaik dari Vanillablue Photostudio' }}</p>

    @if(isset($images) && $images->count())
      <div class="grid-galeri">
      @foreach($images as $img)
        <a href="{{ $img }}" target="_blank" class="galeri-item">
          <img src="{{ $img }}" loading="lazy" alt="{{ $enumCategory ?? $title ?? 'Galeri' }}">
        </a>
      @endforeach
      </div>
    @else
      <div class="grid-galeri">
        <img src="{{ asset('assets/images/baby/baby1.jpg') }}" alt="fallback 1">
        <img src="{{ asset('assets/images/baby/baby2.jpg') }}" alt="fallback 2">
        <img src="{{ asset('assets/images/baby/baby3.jpg') }}" alt="fallback 3">
      </div>
    @endif

    <a href="/{{ '#galeri' }}" class="back-button">← Kembali ke Galeri Utama</a>
  </div>
</section>

<section class="harga-section">
  <h2>List Harga Foto LAINNYA</h2>

  <div class="harga-list">
    <div class="harga-card">
      <p class="kategori">LAINNYA</p>
      <ul>
        <li>15 menit</li>
        <li>All file google drive</li>
        <li>10 edit</li>
      </ul>
      <p class="harga">IDR 200.000</p>
      <a href="/booking" class="btn-booking">BOOKING</a>
    </div>
  </div>
</section>

<section class="update-section">
  <div class="update-box">
    <h3>Jangan Sampe Ketinggalan<br>Update Terbaru Kami !</h3>
    <p>Follow sosial media kami untuk melihat koleksi terbaru dan tips fotografi.</p>
    <div class="update-btns">
      <a href="https://www.tiktok.com/@vanillabluephotostudio?is_from_webapp=1&sender_device=pc" target="_blank" class="btn-sosmed tiktok">TIKTOK</a>
      <a href="https://www.instagram.com/vanillablue_photostudio/" target="_blank" class="btn-sosmed instagram">INSTAGRAM</a>
    </div>
  </div>
</section>

@include ('footer')

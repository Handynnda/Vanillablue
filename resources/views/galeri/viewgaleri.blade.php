@include ('header')

<link rel="stylesheet" href="{{ asset('assets/css/styleGaleri.css') }}?v={{ filemtime(public_path('assets/css/styleGaleri.css')) }}">
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
    <a href='/home' class="back-button">← Kembali ke Galeri Utama</a>
  </div>
</section>

    <section class="pricing-cards">
      <div class="container">
        <div class="cards-container">
          @if(isset($packages) && count($packages))
            @foreach($packages as $p)
              <div class="card">
                <h3><b>{{ $p['name'] }}</b></h3>
                @if(!empty($p['description']))
                  <ul>
                    @foreach($p['description'] as $d)
                      <li>{{ $d }}</li>
                    @endforeach
                  </ul>
                @else
                  <p class="text-muted">Deskripsi belum tersedia.</p>
                @endif
                <p class="price">Rp {{ number_format($p['price'], 0, ',', '.') }}</p>
                <a href="{{ route('booking', ['id' => $p['id']]) }}" class="btn-booking">BOOKING</a>
              </div>
            @endforeach
          @else
            <div class="card">
              <h3>{{ $enumCategory ?? 'Kategori' }}</h3>
              <p class="text-muted">Belum ada paket untuk kategori ini.</p>
              <p class="price">Rp -</p>
              <a href="#" class="btn-booking disabled" style="pointer-events:none;opacity:.6;">BOOKING</a>
            </div>
          @endif
        </div>
      </div>
    </section>

    <section class="social-updates">
      <div class="container">
        <div class="social-card">
            <h2>Jangan Sampe Ketinggalan Update Terbaru Kami!</h2>
            <p>Follow sosial media kami untuk melihat koleksi terbaru!</p>
          <div class="social-buttons">
            <a href="https://www.tiktok.com/@vanillabluephotostudio?is_from_webapp=1&sender_device=pc" class="btn-social btn-tiktok" target="_blank" rel="noopener">TIKTOK</a>
            <a href="https://www.instagram.com/vanillablue_photostudio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="btn-social btn-instagram" target="_blank" rel="noopener">INSTAGRAM</a>
          </div>
        </div>
      </div>
    </section>
  </main>
@include ('footer')

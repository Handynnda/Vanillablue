<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>List Harga • VanillaBlue Photostudio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/styleListharga.css') }}">
  <style>
    .hidden { display: none; }
    .category-nav a.active { font-weight: bold; border-bottom: 2px solid #000; }
    .cards-container { display: flex; gap: 1rem; overflow-x: auto; scroll-behavior: smooth; }
    .card { min-width: 250px; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; flex-shrink: 0; }
    html, body { font-family: 'Poppins', Arial, sans-serif !important; }
  </style>
</head>
<body>
  @include('header')

  <main class="pricing-page">
    <section class="pricing-header">
      <div class="container">
        <h1 class="text-header"><b>List Harga Di VanillaBlue Photostudio</b></h1>
        <nav class="category-nav" role="tablist" aria-label="Kategori Paket">
          @foreach($categories as $c)
            <a href="?category={{ $c['slug'] }}"
               role="tab"
               aria-selected="{{ $c['slug'] === $activeSlug ? 'true' : 'false' }}"
               class="{{ $c['slug'] === $activeSlug ? 'active' : '' }}"
               data-target="{{ $c['slug'] }}">{{ $c['label'] }}</a>
          @endforeach
        </nav>
      </div>
    </section>

    <section class="pricing-cards">
      <div class="container">
        <div class="slider-wrapper">
          <button class="slider-btn prev">&#10094;</button>
          <div class="cards-container" id="cards-container">
            @forelse($bundlings as $b)
              <div class="card">
                <h3><b>{{ $b->name_bundling }}</b></h3>
                <ul>
                  @foreach($b->desc_items as $d)
                    <li>{{ $d }}</li>
                  @endforeach
                </ul>
                <p class="price">Rp {{ number_format($b->price_bundling,0,',','.') }}</p>
                <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
              </div>
            @empty
              <div class="card">
                <h3>{{ collect($categories)->firstWhere('slug',$activeSlug)['label'] ?? 'category' }}</h3>
                <p class="text-muted mb-3" style="min-height:40px;">Segera</p>
                <p class="price">Rp -</p>
                <a href="#" class="btn-booking disabled" style="pointer-events:none;opacity:.6;text-decoration:none;color:#000;">BOOKING</a>
              </div>
            @endforelse
          </div>
          <button class="slider-btn next">&#10095;</button>
        </div>
      </div>
    </section>

    <section class="social-updates">
      <div class="container">
        <div class="social-card">
            <h2>Jangan Sampe Ketinggalan Update Terbaru Kami!</h2>
            <p>Follow sosial media kami untuk melihat koleksi terbaru!</p>
          <div class="social-buttons">
            <!-- replaced nested button+a with single anchor buttons -->
            <a href="https://www.tiktok.com/@vanillabluephotostudio?is_from_webapp=1&sender_device=pc" class="btn-social btn-tiktok" target="_blank" rel="noopener">TIKTOK</a>
            <a href="https://www.instagram.com/vanillablue_photostudio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="btn-social btn-instagram" target="_blank" rel="noopener">INSTAGRAM</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  @include('footer')

  <script>
    // Slider horizontal tetap
    const container = document.getElementById('cards-container');
    const prev = document.querySelector('.slider-btn.prev');
    const next = document.querySelector('.slider-btn.next');
    const scrollStep = 300;
    next?.addEventListener('click', () => container.scrollBy({ left: scrollStep, behavior: 'smooth' }));
    prev?.addEventListener('click', () => container.scrollBy({ left: -scrollStep, behavior: 'smooth' }));
  </script>
</body>
</html>

@include('header')
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">

<main class="pricing-page">
  <section class="pricing-header">
    <div class="container">
      <h1>Lis Harga Di VanillaBlue Photostudio</h1>
      <nav class="category-nav">
        <a href="#">Baby & Kids</a>
        <a href="#">Birthday</a>
        <a href="#">Maternity</a>
        <a href="#">Prewed</a>
        <a href="#" class="active">Graduation</a>
        <a href="#">Family</a>
        <a href="#">Group</a>
        <a href="#">Couple</a>
        <a href="#">Personal</a>
        <a href="#">Pas Foto</a>
        <a href="#">Print & Frame</a>
      </nav>
    </div>
  </section>


{{-- card untuk photo --}}
  {{-- <section class="pricing-banner" style="text-align:center; margin-bottom:40px;">
      <div class="banner-grid" 
          style="display:grid; grid-template-columns: repeat(3, 1fr); gap:10px; max-width: 800px; margin: 0 auto; justify-items:center;">
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
          <div class="card">
              <img src="assets/images/birthday.jpg" alt="birthday" 
                  style="max-width:100%; height:auto; border-radius:15px;">
          </div>
      </div>

      <p style="margin-top:15px; font-size:1rem; color:#555;">
          Berikut paket Graduation dari VanillaBlue Photostudio
      </p>
  </section> --}}


  <section class="pricing-cards">
    <div class="container">
      <div class="slider-wrapper">
        <button class="slider-btn prev">&#10094;</button>
        <div class="cards-container">
          <div class="card">
            <h3>GRADUATION A</h3>
            <ul>
              <li>15 menit, All file google drive</li>
              <li>10 edit</li>
              <li>max 4 orang</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">Rp 250.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>
          <div class="card">
            <h3>GRADUATION B</h3>
            <ul>
              <li>15 menit, All file google drive</li>
              <li>10 edit</li>
              <li>max 10 orang</li>
              <li>cetak 10R p2</li>
            </ul>
            <p class="price">Rp 350.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>
          <div class="card">
            <h3>GRADUATION C</h3>
            <ul>
              <li>15 menit, All file google drive</li>
              <li>10 edit</li>
              <li>max 10 orang</li>
              <li>Cetak 12R + Frame</li>
            </ul>
            <p class="price">Rp 550.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
      </div>
    </div>
  </section>

  <section class="social-updates">
    <div class="container">
      <div class="social-card" 
           style="border: 1px solid #ddd; 
                  border-radius: 15px; 
                  padding: 20px; 
                  text-align: center; 
                  box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
                  max-width: 830px; 
                  margin: 0 auto;">
          <h2>Jangan Sampe Ketinggalan Update Terbaru Kami!</h2>
          <p>Follow sosial media kami untuk melihat koleksi terbaru!</p>
        <div class="social-buttons">
          <a href="https://www.tiktok.com/@vanillabluephotostudio?is_from_webapp=1&sender_device=pc" class="btn-social">TIKTOK</a>
          <a href="https://www.instagram.com/vanillablue_photostudio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="btn-social">INSTAGRAM</a>
        </div>
      </div>
    </div>
  </section>
</main>

@include('footer')

<!-- === SLIDER SCRIPT === -->
<script>
  const container = document.querySelector('.cards-container');
  const prev = document.querySelector('.slider-btn.prev');
  const next = document.querySelector('.slider-btn.next');

  const scrollStep = 300;

  next.addEventListener('click', () => {
    container.scrollBy({ left: scrollStep, behavior: 'smooth' });
  });

  prev.addEventListener('click', () => {
    container.scrollBy({ left: -scrollStep, behavior: 'smooth' });
  });
</script>
@include('header')
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">

<style>
    .hidden { 
      display: none;
    }
    .category-nav a.active {
        font-weight: bold;
        border-bottom: 2px solid #000;
    }
</style>

<main class="pricing-page">
//dibuat jadi 1 pages
  <section class="pricing-header">
    <div class="container">
      <h1>Lis Harga Di VanillaBlue Photostudio</h1>
      <nav class="category-nav">
        <a href="#" data-target="baby">Baby & Kids</a>
        <a href="#" data-target="birthday">Birthday</a>
        <a href="#" data-target="maternity">Maternity</a>
        <a href="#" data-target="prewed">Prewed</a>
        <a href="#" data-target="graduation" class="active">Graduation</a>
        <a href="#" data-target="family">Family</a>
        <a href="#" data-target="group">Group</a>
        <a href="#" data-target="couple">Couple</a>
        <a href="#" data-target="personal">Personal</a>
        <a href="#" data-target="pasfoto">Pas Foto</a>
        <a href="#" data-target="printf" >Print & Frame</a>
        {{-- <div>
          <a href="baby">Baby & Kids</a>
          <a href="birthday">Birthday</a>
          <a href="#">Maternity</a>
          <a href="prewed">Prewed</a>
          <a href="graduation" class="active">Graduation</a>
          <a href="family">Family</a>
          <a href="#">Group</a>
          <a href="couple">Couple</a>
          <a href="#">Personal</a>
          <a href="#">Pas Foto</a>
          <a href="#">Print & Frame</a>
        </div> --}}
      </nav>
    </div>
  </section>

            {{-- section page --}}
          {{-- graduation section --}}
  <section class="pricing-cards hidden" id="graduation">
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
              <li>&nbsp;</li>
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
              <li>&nbsp;</li>
              <li>&nbsp;</li>
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
              <li>&nbsp;</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">Rp 550.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>          
          <div class="card">
            <h3>GRADUATION D</h3>
            <ul>
              <li>15 menit, All file google drive</li>
              <li>10 edit</li>
              <li>max 10 orang</li>
              <li>Cetak 12R + Frame</li>
              <li>&nbsp;</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">Rp 550.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>
          <div class="card">
            <h3>GRADUATION E</h3>
            <ul>
              <li>15 menit, All file google drive</li>
              <li>10 edit</li>
              <li>max 10 orang</li>
              <li>Cetak 12R + Frame</li>
              <li>&nbsp;</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">Rp 550.000</p>
            <a href="booking" class="btn-booking" style="text-decoration:none; color:#000;">BOOKING</a>
          </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
      </div>
    </div>
  </section>
            {{-- baby section --}}
  <section class="pricing-cards hidden" id="baby">
  <div class="container">
    <div class="slider-wrapper">
      <button class="slider-btn prev">&#10094;</button>
      <div class="cards-container">
        <div class="card">
          <h3>BABY & KIDS</h3>
          <ul>
            <li>15 menit</li>
            <li>All file google drive</li>
            <li>10 edit</li>
            <li>&nbsp;</li>
            <li>&nbsp;</li>
            <li>&nbsp;</li>
          </ul>
          <p class="price">IDR 200.000</p>
          <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
        </div>
      </div>
      <button class="slider-btn next">&#10095;</button>
    </div>
  </div>
  </section>
            {{-- birthday section --}}
    <section class="pricing-cards hidden" id="birthday">
    <div class="container">
      <div class="slider-wrapper">
        <button class="slider-btn prev">&#10094;</button>
        <div class="cards-container">
          <div class="card">
              <h3>BIRTHDAY</h3>
              <ul>
                <li>20 menit</li>
                <li>All file google drive</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
              </ul>
              <p class="price">IDR 300.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
          </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
      </div>
    </div>
    </section>
            {{-- couple section --}}
    <section class="pricing-cards hidden" id="couple">
    <div class="container">
      <div class="slider-wrapper">
        <button class="slider-btn prev">&#10094;</button>
        <div class="cards-container">
          <div class="card">
            <h3>COUPLE</h3>
              <ul>
                <li>15 menit</li>
                <li>All file google drive</li>
                <li>10 edit</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
              </ul>
              <p class="price">IDR 200.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
          </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
      </div>
    </div>
    </section>
            {{-- family section --}}
    <section class="pricing-cards hidden" id="family">
    <div class="container">
      <div class="slider-wrapper">
        <button class="slider-btn prev">&#10094;</button>
        <div class="cards-container">
          <div class="card">
            <h3>FAMILY A</h3>
            <ul>
              <li>15 menit</li>
              <li>All file google drive</li>
              <li>10 edit</li>
              <li>Berlaku untuk 1 kostum</li>
              <li>Max 5 orang</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">IDR 250.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
          </div>
          <div class="card">
            <h3>FAMILY B</h3>
            <ul>
              <li>15 menit</li>
              <li>All file google drive</li>
              <li>10 edit</li>
              <li>Berlaku untuk 1 kostum</li>
              <li>Max 10 orang</li>
              <li>Cetak 10rp + frame 1</li>
            </ul>
            <p class="price">IDR 400.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
          </div>
          <div class="card">
            <h3>FAMILY C</h3>
            <ul>
              <li>15 menit</li>
              <li>All file google drive</li>
              <li>10 edit</li>
              <li>Berlaku untuk 1 kostum</li>
              <li>Max 10 orang</li>
              <li>Cetak 16rp + frame 1</li>
            </ul>
            <p class="price">IDR 600.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
          </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
      </div>
    </div>
    </section>
            {{-- prewed section --}}
    <section class="pricing-cards hidden" id="prewed">
    <div class="container">
      <div class="slider-wrapper">
        <button class="slider-btn prev">&#10094;</button>
        <div class="cards-container">
          <div class="card">
            <h3>PRE-WEDDING</h3>
            <ul>
              <li>30 menit</li>
              <li>All file google drive</li>
              <li>10 edit</li>
              <li>Berlaku untuk 1 kostum</li>
              <li>&nbsp;</li>
              <li>&nbsp;</li>
            </ul>
            <p class="price">IDR 500.000</p>
            <a href="booking" class="btn-booking" style="text-decoration: none; color: #000;">BOOKING</a>
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
// === SLIDER SCRIPT ===
const container = document.querySelector('.cards-container');
const prev = document.querySelector('.slider-btn.prev');
const next = document.querySelector('.slider-btn.next');

const scrollStep = 300;

next?.addEventListener('click', () => {
  container.scrollBy({ left: scrollStep, behavior: 'smooth' });
});

prev?.addEventListener('click', () => {
  container.scrollBy({ left: -scrollStep, behavior: 'smooth' });
});

document.querySelectorAll('.category-nav a').forEach(menu => {
  menu.addEventListener('click', function(e) {
    e.preventDefault();

    // SEMBUNYIKAN SEMUA SECTION
    document.querySelectorAll('.pricing-cards')
      .forEach(section => section.classList.add('hidden'));

    // TAMPILKAN SECTION SESUAI TARGET
    const target = this.getAttribute('data-target');
    const showSection = document.getElementById(target);
    if (showSection) showSection.classList.remove('hidden');

    // ACTIVE MENU
    document.querySelectorAll('.category-nav a')
      .forEach(a => a.classList.remove('active'));
    this.classList.add('active');
  });
});

// TAMPILKAN DEFAULT (Graduation)
document.getElementById("graduation").classList.remove("hidden");

</script>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VanillaBlue Photostudio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=camera,check_circle,heart_smile" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    html, body { font-family: 'Poppins', Arial, sans-serif !important; }
  </style>
</head>
<body>
  @include('header')

  <!-- HERO SECTION -->
  <section id="home" class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>MENGABADIKAN MOMEN DAN<br>MEREKAM MOMEN BAHAGIA</h1>
      <p><b>VanillaBlue Photostudio</b> mengubah momen berharga dalam hidup Anda menjadi warisan visual yang indah. Dapatkan hasil foto dengan sentuhan artistik dan kualitas premium.</p>
      <a href="/listharga" class="btn btn-primary">JADWALKAN SESI FOTO ANDA</a>
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="about">
    <h2 style="font-weight:bold" data-aos="fade-up">Siapa Sih VanillaBlue Studio?</h2>
    <div class="about-content">
      <div class="about-text" data-aos="fade-up">
        <p>VanillaBlue Studio adalah sebuah studio yang didirikan pada tanggal 02 April 2015. 
        Visi dari studio ini adalah <b>“Merekam Momen Bahagia”.</b></p>
        <p>Studio Vanillablue menjalankan misinya dengan fokus pada beberapa hal utama:</p>
        <ul>
          <li>Menyediakan layanan fotografi dan videografi berkualitas tinggi untuk menangkap setiap ekspresi, tawa, dan air mata kebahagiaan dengan detail yang autentik dan indah.</li>
          <li>Mengubah momen spesial menjadi karya visual yang artistik, memiliki nilai sentimental, dan dapat dikenang sepanjang masa oleh setiap klien.</li>
          <li>Membangun hubungan yang hangat dan profesional dengan klien, memastikan proses sesi pemotretan atau perekaman berjalan nyaman, personal, dan berkesan.</li>
          <li>Terus mengembangkan teknik, peralatan, dan gaya visual agar hasil akhir selalu relevan, segar, dan melebihi harapan klien.</li>
        </ul>
        <p>Kami hadir untuk memberikan pelayanan fotografi profesional dan personal agar hasil foto sesuai harapan Anda.</p>
      </div>
      <div class="about-logo" data-aos="fade-up">
        <img src="assets/images/studiologo.jpg" alt="VanillaBlue Studio Logo">
      </div>
    </div>
  </section>

  <!-- WHY SECTION -->
<section class="why">
  <h2 style="font-weight:bold" data-aos="fade-up">Mengapa Vanillablue Merupakan<br>Pilihan Anda?</h2>
  <div class="why-cards">
    <div class="why-card" data-aos="fade-up">
      <div class="icon-wrap">
        <span class="material-symbols-outlined">camera</span>
      </div>
      <h3>Sentuhan Artistik<br>Profesional</h3>
      <p>Kami memastikan Anda merasa nyaman dan rileks selama sesi foto. Pelayanan ramah dan konsultasi konsep yang mendalam agar hasil sesuai dengan impian Anda.</p>
    </div>

    <div class="why-card" data-aos="fade-up">
      <div class="icon-wrap">
        <span class="material-symbols-outlined">heart_smile</span>
      </div>
      <h3>Pengalaman Sesi yang<br>Personal</h3>
      <p>Kami memastikan Anda merasa nyaman dan rileks selama sesi foto. Pelayanan ramah dan konsultasi konsep yang mendalam agar hasil sesuai dengan impian Anda.</p>
    </div>

    <div class="why-card" data-aos="fade-up">
      <div class="icon-wrap">
        <span class="material-symbols-outlined">check_circle</span>
      </div>
      <h3>Kualitas Premium,<br>Tepat Waktu</h3>
      <p>Kami menghargai waktu Anda. Dapatkan kualitas editing terbaik dengan proses pengerjaan yang transparan dan penyerahan hasil foto yang selalu tepat waktu sesuai janji.</p>
    </div>
  </div>
</section>


  <!-- GALERI SECTION -->
<section id="galeri" class="galeri-section">
  <h2 data-aos="fade-up" data-aos-duration="800">Beberapa Hasil Karya Kami</h2>

  <div class="galeri-container">
    <a href="{{ url('/galeri/baby') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/baby.jpg" alt="Foto Baby" loading="lazy" decoding="async">
      <p>Foto Baby</p>
    </a>
    <a href="{{ url('/galeri/birthday') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/birthday.jpg" alt="Foto Birthday" loading="lazy" decoding="async">
      <p>Foto Birthday</p>
    </a>
    <a href="{{ url('/galeri/prewed') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/prewed.jpg" alt="Foto Prewed" loading="lazy" decoding="async">
      <p>Foto Prewed</p>
    </a>
    <a href="{{ url('/galeri/couple') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/couple.jpg" alt="Foto Couple" loading="lazy" decoding="async">
      <p>Foto Couple</p>
    </a>
    <a href="{{ url('/galeri/family') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/family.jpg" alt="Foto Family" loading="lazy" decoding="async">
      <p>Foto Family</p>
    </a>
    <a href="{{ url('/galeri/graduation') }}" class="galeri-item" data-aos="fade-up">
      <img src="assets/images/graduation.jpg" alt="Foto Graduation" loading="lazy" decoding="async">
      <p>Foto Graduation</p>
    </a>
  </div>
  <a href="#" class="lihat-lainnya">Hasil Lainnya...</a>
</section>

<!-- SECTION LIST HARGA -->
<section id="listharga" class="py-5">
    <div class="container">
      <div class="social-card" data-aos="fade-up">
        <div>
          <h5>Klik Harga Paket-Paket di Vanillablue Photostudio</h5>
          <a href="listharga" class="btn btn-warning">Lihat Harga</a>
        </div>
      </div>
    </div>
  </section>

  <!-- LOKASI SECTION -->
<section id="lokasi" class="lokasi-section">
  <h1 style="font-weight:bold; text-align:center; margin-bottom: 45px;" data-aos="fade-up">Lokasi Vanillablue Studio</h1>
  <!-- FOTO LOKASI -->
  <div class="lokasi-foto" data-aos="fade-up">
    <img src="assets/images/studio.jpg" alt="Foto Studio VanillaBlue" loading="lazy" decoding="async">
  </div>
  <div class="lokasi-gmaps">  
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.1978044302223!2d108.48985800000001!3d-6.985965399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f143b5fefcb33%3A0x65c508f374d025ee!2sSTUDIO%20VANILLABLUE!5e0!3m2!1sid!2sid!4v1763273648052!5m2!1sid!2sid" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
      </iframe>
  </div>
</section>    

<!-- Bagian Kontak -->
<section id="kontak" class="kontak-section py-5 bg-white">
  <div class="container">
    <div class="row g-1 social-card text-center text-md-start justify-content-between">
      <div class="col-md-3" data-aos="fade-up" style="margin-left:0;">
        <h5 class="fw-bold">Alamat</h5>
        <p>Jl. Jendral Sudirman no 175, Awirarangan, Kuningan</p>
      </div>
      <div class="col-md-3 text-center" data-aos="fade-up">
        <h5 class="fw-bold">Jam Buka</h5>
        <p>Buka Setiap Hari<br>Pukul 09.00 – 18.00 WIB<br>Hanya Libur di hari tertentu</p>
      </div>
      <div class="col-md-3 text-md-end" data-aos="fade-up" style="margin-right:0px;">
        <h5 class="fw-bold">Kontak – Sosial Media</h5>
        <ul class="kontak-list">
          <li><i class="bi bi-instagram"></i> <span>vanillablue_photostudio</span></li>
          <li><i class="bi bi-whatsapp"></i> <span>+62 813-8391-9991</span></li>
          <li><i class="bi bi-envelope"></i> <span>vanillabluephotography@gmail.com</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>


  <!-- BANNER KONTAK -->
  <div class="banner-kontak text-white">
    <img src="assets/images/family.jpg" alt="Foto Family" class="banner-bg" loading="lazy" decoding="async">
    <div class="banner-overlay"></div>
    <div class="banner-content">
      <h2><b>BELUM NEMU APA YANG<br>KAMU CARI ?</b></h2>
      <p>Jangan khawatir, kamu bisa kontak kami untuk konsultasi lebih lanjut.</p>
      <a href="https://wa.me/6281338919991" class="btn btn-warning fw-bold px-4">Whatsapp</a>
    </div>
  </div>

  @include('footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true, easing: 'ease-out' });
  </script>
</body>
</html>
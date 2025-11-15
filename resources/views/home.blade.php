<!DOCTYPE html>
<html lang="id">
@include('header')
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VanillaBlue Photostudio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>

  <!-- HERO SECTION -->
  <section id="home" class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>MENGABADIKAN MOMEN DAN<br>MENCIPTAKAN KENANGAN YANG KEKAL</h1>
      <p><b>VanillaBlue Photostudio</b> mengubah momen berharga dalam hidup Anda menjadi warisan visual yang indah. Dapatkan hasil foto dengan sentuhan artistik dan kualitas premium.</p>
      <a href="/listharga" class="btn btn-primary">JADWALKAN SESI FOTO ANDA</a>
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="about">
    <h2 style="font-weight:bold">Siapa Sih VanillaBlue Studio?</h2>
    <div class="about-content">
      <div class="about-text">
        <p>VanillaBlue Studio adalah sebuah studio yang didirikan pada tanggal 02 April 2015. 
        Visi dari studio ini adalah “Merekam Momen Bahagia”.</p>
        <p>Studio Vanillablue menjalankan misinya dengan fokus pada beberapa hal utama:</p>
        <ul>
          <li><b>Mengabadikan Emosi Sejati:</b> Menyediakan layanan fotografi dan videografi berkualitas tinggi untuk menangkap setiap ekspresi, tawa, dan air mata kebahagiaan dengan detail yang autentik dan indah.</li>
          <li><b>Menciptakan Kenangan Abadi:</b> Mengubah momen spesial menjadi karya visual yang artistik, memiliki nilai sentimental, dan dapat dikenang sepanjang masa oleh setiap klien.</li>
          <li><b>Pengalaman Menyenangkan:</b> Membangun hubungan yang hangat dan profesional dengan klien, memastikan proses sesi pemotretan atau perekaman berjalan nyaman, personal, dan berkesan.</li>
          <li><b>Inovasi dan Kualitas:</b> Terus mengembangkan teknik, peralatan, dan gaya visual agar hasil akhir selalu relevan, segar, dan melebihi harapan klien.</li>
        </ul>
        <p>Kami hadir untuk memberikan pelayanan fotografi profesional dan personal agar hasil foto sesuai harapan Anda.</p>
      </div>
      <div class="about-logo">
        <img src="assets/images/studiologo.jpg" alt="VanillaBlue Studio Logo">
      </div>
    </div>
  </section>

  <!-- WHY SECTION -->
<section class="why">
  <h2 style="font-weight:bold">Mengapa Vanillablue Merupakan<br>Pilihan Anda?</h2>
  <div class="why-cards">
    <div class="why-card">
      <div class="icon-wrap">
        <img src="assets/images/CAM.png" alt="Sentuhan Artistik Profesional">
      </div>
      <h3>Sentuhan Artistik<br>Profesional</h3>
      <p>Kami memastikan Anda merasa nyaman dan rileks selama sesi foto. Pelayanan ramah dan konsultasi konsep yang mendalam agar hasil sesuai dengan impian Anda.</p>
    </div>

    <div class="why-card">
      <div class="icon-wrap">
        <img src="assets/images/HEART.png" alt="Pengalaman Sesi yang Personal">
      </div>
      <h3>Pengalaman Sesi yang<br>Personal</h3>
      <p>Kami memastikan Anda merasa nyaman dan rileks selama sesi foto. Pelayanan ramah dan konsultasi konsep yang mendalam agar hasil sesuai dengan impian Anda.</p>
    </div>

    <div class="why-card">
      <div class="icon-wrap">
        <img src="assets/images/TICK.png" alt="Kualitas Premium, Tepat Waktu">
      </div>
      <h3>Kualitas Premium,<br>Tepat Waktu</h3>
      <p>Kami menghargai waktu Anda. Dapatkan kualitas editing terbaik dengan proses pengerjaan yang transparan dan penyerahan hasil foto yang selalu tepat waktu sesuai janji.</p>
    </div>
  </div>
</section>


  <!-- GALERI SECTION -->
<section id="galeri" class="galeri-section">
  <h2>Beberapa Hasil Karya Kami</h2>

  <div class="galeri-container">
    <a href="{{ url('/galeri/baby') }}" class="galeri-item">
      <img src="assets/images/baby.jpg" alt="Foto Baby">
      <p>Foto Baby</p>
    </a>
    <a href="{{ url('/galeri/birthday') }}" class="galeri-item">
      <img src="assets/images/birthday.jpg" alt="Foto Birthday">
      <p>Foto Birthday</p>
    </a>
    <a href="{{ url('/galeri/prewed') }}" class="galeri-item">
      <img src="assets/images/prewed.jpg" alt="Foto Prewed">
      <p>Foto Prewed</p>
    </a>
    <a href="{{ url('/galeri/couple') }}" class="galeri-item">
      <img src="assets/images/couple.jpg" alt="Foto Couple">
      <p>Foto Couple</p>
    </a>
    <a href="{{ url('/galeri/family') }}" class="galeri-item">
      <img src="assets/images/family.jpg" alt="Foto Family">
      <p>Foto Family</p>
    </a>
    <a href="{{ url('/galeri/graduation') }}" class="galeri-item">
      <img src="assets/images/graduation.jpg" alt="Foto Graduation">
      <p>Foto Graduation</p>
    </a>
  </div>
  <a href="#" class="lihat-lainnya">Hasil Lainnya...</a>
</section>

<!-- SECTION LIST HARGA -->
<section id="listharga">
  <div class="social-card" 
        style="padding: 50px;
        padding-left: 350px; 
        padding-right: 350px;
        padding-top: 200px;
        padding-bottom: 200px;
        text-align: center; 
        max-width: 100%; 
        margin: 0 auto;">
      <div>
        <h5>Klik Harga Paket-Paket di Vanillablue Photostudio</h5>
        <a href="listharga" class="btn btn-warning">Lihat Harga</a>
      </div>
  </div>
</section>

  <!-- LOKASI SECTION -->
<section id="lokasi" class="lokasi-section">
  <!-- FOTO LOKASI -->
  <div class="lokasi-foto">
    <img src="assets/images/studio.jpg" alt="Foto Studio VanillaBlue">
  </div>

<!-- Bagian Kontak -->
<section id="kontak" class="kontak-section py-5 bg-white">
    <div class="social-card" 
    style=" 
    border-radius: 15px; 
    padding: 50px;
    padding-left: 100px; 
    padding-right: 150px; 
    text-align: center; 
    max-width: 100%; 
    margin: 0 auto;">
      <div class="row">
        <div class="col-md-4 mb-3" style="text-align: left">
          <h5 class="fw-bold">Alamat</h5>
          <p>Jl. Jendral Sudirman no 175, Awirarangan, Kuningan</p>
        </div>
        <div class="col-md-4 mb-3" 
            style="text-align: left; 
                  padding-left: 100px; ">
          <h5 class="fw-bold">Jam Buka</h5>
          <p>Buka Setiap Hari<br>Pukul 09.00 – 18.00 WIB<br>Hanya Libur di hari tertentu</p>
        </div>
        <div class="col-md-4 mb-3" style="text-align: right">
          <h5 class="fw-bold">Kontak – Sosial Media</h5>
          <p>
            <i class="bi bi-instagram" style="padding-right: 99px"></i> vanillablue_photostudio<br>
            <i class="bi bi-whatsapp" style="padding-right: 149px"></i> +62 813-8391-9991<br>
            <i class="bi bi-envelope"></i> vanillabluephotography@gmail.com
          </p>
        </div>
      </div>
    </div>
</section>


  <!-- BANNER KONTAK -->
  <div class="banner-kontak text-white">
    <img src="assets/images/family.jpg" alt="Foto Family" class="banner-bg">
    <div class="banner-overlay"></div>
    <div class="banner-content">
      <h2><b>BELUM NEMU APA YANG<br>KAMU CARI ?</b></h2>
      <p>Jangan khawatir, kamu bisa kontak kami untuk konsultasi lebih lanjut.</p>
      <a href="https://wa.me/6281338919991" class="btn btn-warning fw-bold px-4">Whatsapp</a>
    </div>
  </div>
</section>

@include('footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

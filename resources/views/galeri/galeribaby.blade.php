@include ('header')

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
  
<style>
/* === GLOBAL === */
body { 
  font-family: 'Poppins', sans-serif;
  background-color: #f9f9f9;
  margin: 0;
  color: #222;
}

/* === GALERI DETAIL === */
.galeri-detail {
  padding: 60px 20px;
  padding-top: 100px;
}

.galeri-detail h1 {
  text-align: center;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 10px;
}

.galeri-detail .subtitle {
  text-align: center;
  color: #666;
  font-size: 15px;
  margin-bottom: 40px;
}

/* === GRID FOTO === */
.grid-galeri {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); /* ukuran besar */
  gap: 35px;
  width: 95%;
  max-width: 1400px;
  margin: 0 auto;
  justify-items: center;
}

.grid-galeri img {
  width: 100%;
  height: 400px;
  object-fit: cover;
  border-radius: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  transition: transform 0.3s, box-shadow 0.3s;
}

.grid-galeri img:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

@media (max-width: 600px) {
  .grid-galeri img {
    height: 200px;
  }
}


.back-button {
  display: block;
  text-align: center;
  margin: 40px 0;
  text-decoration: none;
  color: #1a3b8f;
  font-weight: 600;
  transition: color 0.3s;
}

.back-button:hover {
  color: #0d2a6b;
}

/* === BAGIAN HARGA === */
.harga-section {
  text-align: center;
  background-color: #f3f5f8;
  padding: 60px 20px;
}

.harga-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
  margin-top: 40px;
}

.harga-card {
  background-color: #fff;
  color: #1a1a1a;
  border-radius: 16px;
  padding: 25px 40px;
  width: 260px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  text-align: left;

  /* tambahan untuk tata letak vertikal rapi */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 280px;
}

.harga-card .card-bottom {
  margin-top: auto;
  text-align: center;
}

.harga-card:hover {
  background: linear-gradient(180deg, #2A4073, #1A2A42);
  color: #fff;
  transform: translateY(-5px);
}

.harga-card .kategori {
  justify-content: center;
  font-weight: 600;
  font-size: 16px;
  margin-bottom: 10px;
}

.harga-card ul {
  list-style: none;
  padding: 0;
  margin: 0 0 10px;
}

.harga-card li {
  font-size: 14px;
  margin-bottom: 4px;
}

.harga-card .harga {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 15px;
}

.btn-booking {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #FFD400;
  color: #000;
  text-decoration: none;
  padding: 10px 0;
  width: 100%;
  font-weight: 600;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.btn-booking:hover {
  background-color: #ffca00;
}


/* === BAGIAN UPDATE === */
.update-section {
  background-color: #fff;
  padding: 60px 0;
  display: flex;
  justify-content: center;
}

.update-box {
  width: 85%;
  max-width: 900px;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 35px;
  text-align: center;
}

.update-box h3 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 10px;
}

.update-box p {
  color: #666;
  margin-bottom: 25px;
}

.update-btns {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.btn-sosmed {
  text-decoration: none;
  font-weight: 600;
  padding: 10px 18px;
  border-radius: 4px;
  color: white;
  transition: 0.3s;
}

.btn-sosmed.tiktok {
  background-color: #010101;
}

.btn-sosmed.instagram {
  background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af, #515bd4);
}

.btn-sosmed:hover {
  opacity: 0.9;
}
</style>

<section class="galeri-detail">
  <div class="container">
    <h1>Galeri Foto Baby</h1>
    <p class="subtitle">Koleksi foto-foto Bayi terbaik dari Vanillablue Photostudio</p>

    <div class="grid-galeri">
      <img src="assets/images/baby/baby1.jpg" alt="Bayi 1">
      <img src="assets/images/baby/baby2.jpg" alt="Bayi 2">
      <img src="assets/images/baby/baby3.jpg" alt="Bayi 3">
      <img src="assets/images/baby/baby4.jpg" alt="Bayi 4">
      <img src="assets/images/baby/baby5.jpg" alt="Bayi 5">
      <img src="assets/images/baby/baby6.jpg" alt="Bayi 6">
    </div>

    <a href="/#galeri" class="back-button">← Kembali ke Galeri Utama</a>
  </div>
</section>

<section class="harga-section">
  <h2>List Harga Foto Baby</h2>

  <div class="harga-list">
    <div class="harga-card">
      <p class="kategori">BABY & KIDS</p>
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

<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-logo">
      <img src="assets/images/studiologo.jpg" alt="Vanillablue Studio">
    </div>
    <nav class="footer-nav">
      <a href="/">Beranda</a>
      <a href="/#galeri">Galeri</a>
      <a href="listharga">Lis Harga</a>
      <a href="/#kontak">Kontak</a>
    </nav>
  </div>
  <div class="footer-bottom">
    <p>Copyright © {{ date('Y') }} Vanillablue Studio.</p>
  </div>

  <style>
    .site-footer {
      background: #fff;
      color: #000;
      padding: 15px 40px;
      font-family: 'Poppins', sans-serif;
      text-align: center;
      border-top: 1px solid #ddd;
    }

    .footer-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }

    .footer-logo img {
      height: 85px;
      margin-top: 10px;
    }

    .footer-nav a {
      color: #000;
      text-decoration: none;
      margin-left: 25px;
      font-weight: 600;
    }

    .footer-nav a:hover {
      text-decoration: underline;
    }

    .footer-bottom {
      font-size: 0.85rem;
      color: #444;
    }
  </style>
</footer>

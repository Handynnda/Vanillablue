<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">

<!-- HEADER -->
<header class="navbar fixed-top py-3" style="background-color: #0b132b;">
  <div class="container d-flex align-items-center justify-content-between">
    <!-- Logo -->
    <div class="d-flex align-items-center">
      <img src="assets/images/studiologo.jpg" alt="Logo" style="height: 36px; margin-right: 10px; border-radius: 50px">
      <span class="text-white fw-bold">VanillaBlue Photostudio</span>
    </div>

    <!-- Menu Navigasi -->
    <nav class="nav">
      <?php if ($current_page === 'home'): ?>
        <a href="#home" class="nav-link text-white scroll-link">Beranda</a>
        <a href="#galeri" class="nav-link text-white scroll-link">Galeri</a>
        <a href="#listharga" class="nav-link text-white">List Harga</a>
        <a href="#kontak" class="nav-link text-white scroll-link">Kontak</a>
      <?php else: ?>
        <a href="/" class="nav-link text-white">Beranda</a>
        <a href="/#galeri" class="nav-link text-white">Galeri</a>
        <a href="/#listharga" class="nav-link text-white">List Harga</a>
        <a href="/#kontak" class="nav-link text-white">Kontak</a>
      <?php endif; ?>
    </nav>


    <div class="d-flex align-items-center gap-2">
      @auth
        <div class="dropdown">
          <button class="btn btn-light fw-bold px-3 py-1 dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                <button class="dropdown-item text-danger" type="submit">Keluar</button>
              </form>
            </li>
          </ul>
        </div>
      @else
        <a href="{{ route('login') }}" class="btn btn-light fw-bold px-3 py-1">MASUK</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light fw-bold px-3 py-1">DAFTAR</a>
      @endauth
    </div>
  </div>
</header>

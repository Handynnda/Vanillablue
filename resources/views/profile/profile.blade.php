@extends('layouts.main')

@section('title', 'Pengaturan Akun')

@section('container')


{{-- 2. HERO BANNER --}}
<div class="profile-banner d-flex align-items-center justify-content-center" style="margin-top: 56px;"> 
    {{-- Margin top ditambah manual jika navbar fixed menutupi --}}
    <div class="text-center text-white">
        <h2 class="fw-bold mb-0">Pengaturan Akun</h2>
        <p class="text-white-50">Kelola data diri dan keamanan akun Anda</p>
    </div>
</div>

{{-- 3. KONTEN UTAMA --}}
<div class="container pb-5" style="margin-top: -20px;">
    <div class="row justify-content-center">
        
        {{-- KOLOM KIRI: MENU --}}
        <div class="col-lg-3 mb-4">
            {{-- Kartu User Singkat --}}
            <div class="card border-0 shadow-sm rounded-4 text-center mb-4">
                <div class="card-body pt-0">
                    <div class="profile-avatar-container">
                        <div class="profile-avatar">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                    <div class="badge bg-light text-dark border px-3 py-2 rounded-pill mt-2">
                        Member sejak {{ $user->created_at->format('Y') }}
                    </div>
                </div>
            </div>

            {{-- Menu Navigasi --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <a href="{{ route('profile.index') }}" class="menu-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i> Profil Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="menu-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                    </a>
                    
                    <hr class="my-2 opacity-25">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu-link w-100 text-danger bg-transparent border-0">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM EDIT --}}
        <div class="col-lg-8">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                    <i class="fas fa-check-circle fs-4 me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            {{-- CARD 1: EDIT DATA DIRI --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                    <div class="bg-light p-2 rounded-3 me-3 text-warning">
                        <i class="fas fa-address-card fs-5"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Data Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-control-custom" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nomor WhatsApp</label>
                                <input type="text" name="phone" class="form-control form-control-custom" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control form-control-custom" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-dark fw-bold px-4 py-2" style="background-color: #222831;">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CARD 2: KEAMANAN (VERSI OTP) --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                    <div class="bg-light p-2 rounded-3 me-3 text-danger">
                        <i class="fas fa-shield-alt fs-5"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Keamanan Akun</h5>
                </div>
                <div class="card-body p-4 text-center">
                    
                    <div class="mb-4">
                        <i class="fas fa-lock text-muted" style="font-size: 3rem; opacity: 0.2;"></i>
                    </div>

                    <h6 class="fw-bold">Ingin Mengubah Kata Sandi?</h6>
                    <p class="text-muted small mb-4">
                        Demi keamanan, kami akan mengirimkan Kode OTP ke email 
                        <strong>{{ $user->email }}</strong> sebelum Anda dapat membuat password baru.
                    </p>

                    <form action="{{ route('profile.otp.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 py-2 fw-bold w-100">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Kode OTP
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
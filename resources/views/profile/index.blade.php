@extends('profile.profile')

@section('content')

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div style="
        background:#d1fae5;
        padding:12px;
        border-radius:10px;
        margin:20px 40px;
        color:#065f46;">
    {{ session('success') }}
</div>
@endif

<div class="profile-wrapper">

    <!-- HEADER -->
    <div class="profile-header">
        <h1>Pengaturan Akun</h1>
        <p>Kelola data diri dan keamanan akun Anda</p>
    </div>

    <div class="profile-body">

        <!-- SIDEBAR -->
        <aside class="profile-sidebar">

            <div class="user-card">
                <div class="avatar">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>

                <h3>{{ $user->name }}</h3>
                <span class="email">{{ $user->email }}</span>
                <span class="badge">Member sejak {{ $user->created_at->format('Y') }}</span>
            </div>

            <div class="user-card-menu">
                <ul class="sidebar-menu">
                    <li class="active">Profil Saya</li>
                    <li>Riwayat Pesanan</li>

                    {{-- LOGOUT --}}
                    <li class="logout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="all:unset;cursor:pointer;color:red">
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- CONTENT -->
        <main class="profile-content">

            <!-- DATA PRIBADI -->
            <div class="content-card">
                <div class="card-title">
                    Data Pribadi
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="action-right">
                        <button type="submit" class="btn-dark">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- KEAMANAN -->
            <div class="content-card security">
                <div class="card-title">
                    Keamanan Akun
                </div>

                <div class="security-box">
                    <h4>Ingin Mengubah Kata Sandi?</h4>
                    <p>
                        Demi keamanan, kami akan mengirimkan Kode OTP ke email
                        <strong>{{ $user->email }}</strong>
                        sebelum Anda dapat membuat password baru.
                    </p>

                    <form method="POST" action="{{ route('profile.sendOtp') }}">
                        @csrf
                        <button type="submit" class="btn-danger">
                            Kirim Kode OTP
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection
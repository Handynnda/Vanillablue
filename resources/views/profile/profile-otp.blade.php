@extends('layouts.main')
@section('title', 'Verifikasi Keamanan')

@section('container')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    
                    <h4 class="fw-bold text-center mb-4">Verifikasi & Ganti Password</h4>

                    @if(session('success'))
                        <div class="alert alert-success small mb-4">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.otp.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- INPUT OTP --}}
                        <div class="mb-4 text-center">
                            <label class="form-label small fw-bold text-muted mb-2">Kode OTP dari Email</label>
                            <input type="text" name="otp" 
                                   class="form-control text-center fw-bold fs-4 text-primary @error('otp') is-invalid @enderror" 
                                   maxlength="6" 
                                   placeholder="000000" 
                                   style="letter-spacing: 8px;" 
                                   required autofocus>
                            @error('otp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        {{-- INPUT PASSWORD BARU --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Ulangi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password..." required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark fw-bold py-2">
                                Simpan Password Baru
                            </button>
                            <a href="{{ route('profile.index') }}" class="btn btn-light text-muted small">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
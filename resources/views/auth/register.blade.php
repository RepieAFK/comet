@extends('layouts.app')

@section('content')
<div class="auth-container d-flex justify-content-center align-items-center min-vh-100 p-3">
    <div class="auth-card p-4 shadow-sm" style="max-width: 420px; border-radius: 12px;">
        <div class="logo text-center mb-4">
            <i class="fas fa-user-plus fa-3x text-primary mb-2"></i>
            <h2 class="fw-bold mb-1">Registrasi Akun</h2>
            <p class="text-muted mb-0">Buat akun baru untuk meminjam ruangan</p>
        </div>
        
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0 @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="John Doe" 
                           required>
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nomor_induk" class="form-label fw-semibold">Nomor Induk (NIS/NIP)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-id-card text-muted"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0 @error('nomor_induk') is-invalid @enderror" 
                           id="nomor_induk" 
                           name="nomor_induk" 
                           value="{{ old('nomor_induk') }}" 
                           placeholder="12345678" 
                           required>
                </div>
                @error('nomor_induk')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-envelope text-muted"></i>
                    </span>
                    <input type="email" 
                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="nama@email.com" 
                           required>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label fw-semibold">Nomor Telepon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-phone text-muted"></i>
                    </span>
                    <input type="tel" 
                           class="form-control border-start-0 @error('telepon') is-invalid @enderror" 
                           id="telepon" 
                           name="telepon" 
                           value="{{ old('telepon') }}" 
                           placeholder="08123456789">
                </div>
                @error('telepon')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input type="password" 
                           class="form-control border-start-0 @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Minimal 8 karakter" 
                           required>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input type="password" 
                           class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Ulangi password" 
                           required>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg py-2">
                    <i class="fas fa-user-plus me-2"></i>Daftar
                </button>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <p class="mb-0 text-muted">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="btn btn-link text-decoration-none fw-semibold text-primary">
                Login di sini
            </a>
        </div>
    </div>
</div>
@endsection
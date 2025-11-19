@extends('layouts.app')

@section('content')
<div class="auth-container d-flex justify-content-center align-items-center min-vh-100 p-3">
    <div class="auth-card p-4 shadow-sm" style="max-width: 400px; border-radius: 12px;">
        <div class="logo text-center mb-4">
            <i class="fas fa-door-open fa-3x text-primary mb-2"></i>
            <h2 class="fw-bold mb-1">COMET</h2>
            <p class="text-muted mb-0">Sistem Peminjaman Ruangan</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
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

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input type="password" 
                           class="form-control border-start-0 @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan password" 
                           required>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg py-2">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="mb-0 text-muted">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="btn btn-link text-decoration-none fw-semibold text-primary">
                Daftar di sini
            </a>
        </div>
    </div>
</div>
@endsection
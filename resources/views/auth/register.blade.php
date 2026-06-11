@extends('Layouts.guest')

@section('title', 'Daftar Akun - SummitBuddy')

@section('content')
    <div class="auth-logo">
        <i class="fas fa-user-plus"></i>
        <h2>Daftar Akun</h2>
        <p>Bergabunglah dengan SummitBuddy</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap Anda" required autofocus autocomplete="name">
            </div>
            @error('name')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="username">
            </div>
            @error('email')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
            </div>
            @error('password')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
            </div>
            @error('password_confirmation')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Daftar</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
@endsection

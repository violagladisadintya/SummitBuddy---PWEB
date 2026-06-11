@extends('Layouts.guest')

@section('title', 'Login - SummitBuddy')

@section('content')
    <div class="auth-logo">
        <i class="fas fa-mountain"></i>
        <h2>SummitBuddy</h2>
        <p>Silakan masuk ke akun Anda</p>
    </div>

    @if(session('status'))
        <div class="alert" style="background: rgba(46, 204, 113, 0.2); border-color: rgba(46, 204, 113, 0.4); color: #2ecc71;">
            {{ session('status') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="username">
            </div>
            @error('email')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
            </div>
            @error('password')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Masuk</button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>
@endsection

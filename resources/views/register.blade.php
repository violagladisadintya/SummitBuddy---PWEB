@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container" style="max-width: 400px; margin: 100px auto;">
    <div class="card" style="padding: 30px;">
        <h2 style="text-align: center;">Register SummitBuddy</h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>Nama</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Register</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</div>
@endsection

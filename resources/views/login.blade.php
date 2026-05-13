@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 400px; margin: 100px auto;">
    <div class="card" style="padding: 30px;">
        <h2 style="text-align: center;">Login SummitBuddy</h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
</div>
@endsection

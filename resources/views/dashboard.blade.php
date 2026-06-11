@extends('layouts.app')

@section('title', 'Dashboard - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Dashboard SummitBuddy</h1>
        <p>Selamat datang, {{ auth()->user()->name }}</p>
    </div>
</header>
@endsection

@section('content')
@if(auth()->user()->email === 'admin@summitbuddy.com')
    <!-- ADMIN VIEW -->
    <h2 style="margin-bottom: 20px; color: #1b5e2f;"><i class="fas fa-user-shield"></i> Panel Administrator</h2>
    <div class="stat-row">
        <div class="stat-card">
            <h4>👤 Admin</h4>
            <div class="angka" style="font-size: 20px;">{{ auth()->user()->name }}</div>
        </div>
        <div class="stat-card">
            <h4>📧 Email</h4>
            <div class="angka" style="font-size: 16px; word-break: break-all;">{{ auth()->user()->email }}</div>
        </div>
        <div class="stat-card">
            <h4>📦 Total Alat</h4>
            <div class="angka">{{ \App\Models\Alat::count() }}</div>
        </div>
        <div class="stat-card">
            <h4>📋 Total Penyewaan</h4>
            <div class="angka">{{ count(session('data_sewa', [])) }}</div>
        </div>
        <div class="stat-card">
            <h4>🛡️ Hak Akses</h4>
            <div class="angka" style="font-size: 20px; color: #43a047;">Full Admin</div>
        </div>
    </div>

    <div class="card" style="padding: 35px; margin-top: 30px;">
        <h3 style="color: #1b5e2f; margin-bottom: 20px; border-bottom: 2px solid #ff8c42; padding-bottom: 8px; display: inline-block;">Menu Cepat Admin</h3>
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 15px;">
            <a href="{{ route('kelola-alat') }}" class="btn-tambah" style="text-decoration: none; padding: 14px 28px; font-weight: 600;">📦 Kelola Alat & Penyewaan</a>
        </div>
    </div>
@else
    <!-- CUSTOMER VIEW -->
    <h2 style="margin-bottom: 20px; color: #1b5e2f;"><i class="fas fa-user"></i> Panel Pelanggan</h2>
    <div class="stat-row-3">
        <div class="stat-card">
            <h4>👤 Nama</h4>
            <div class="angka" style="font-size: 20px;">{{ auth()->user()->name }}</div>
        </div>
        <div class="stat-card">
            <h4>📧 Email</h4>
            <div class="angka" style="font-size: 16px; word-break: break-all;">{{ auth()->user()->email }}</div>
        </div>
        <div class="stat-card">
            <h4>Status Akun</h4>
            <div class="angka" style="font-size: 20px; color: #43a047;">Pelanggan Aktif</div>
        </div>
    </div>

    <div class="card" style="padding: 35px; margin-top: 30px;">
        <h3 style="color: #1b5e2f; margin-bottom: 20px; border-bottom: 2px solid #ff8c42; padding-bottom: 8px; display: inline-block;">Layanan Pendakian</h3>
        <p style="margin-bottom: 25px; color: #666;">Silakan pilih menu di bawah ini untuk melihat daftar alat pendakian yang tersedia atau melakukan penyewaan perlengkapan di halaman utama.</p>
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <a href="{{ route('data-alat') }}" class="btn-tambah" style="text-decoration: none; padding: 14px 28px; font-weight: 600; background: #43a047;"><i class="fas fa-search"></i> Lihat Katalog Alat</a>
            <a href="{{ route('form-sewa') }}" class="btn-tambah" style="text-decoration: none; padding: 14px 28px; font-weight: 600; background: #ff8c42;"><i class="fas fa-calendar-alt"></i> Sewa Alat Pendakian</a>
            <a href="{{ route('home') }}" class="btn-tambah" style="text-decoration: none; padding: 14px 28px; font-weight: 600; background: #2196f3;"><i class="fas fa-home"></i> Halaman Utama</a>
        </div>
    </div>
@endif

<style>
    /* Styling overrides for dark mode compatibility on custom dashboard containers */
    .dark div[style*="background: white"] {
        background: #22223b !important;
        box-shadow: none !important;
    }
    .dark p[style*="color: #666"] {
        color: #bbb !important;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Dashboard SummitBuddy</h1>
        <p>Selamat datang di panel utama</p>
    </div>
</header>
@endsection

@section('content')
<div class="stat-row">
    <div class="stat-card">
        <h4>👤 Nama User</h4>
        <div class="angka">{{ auth()->user()->name }}</div>
    </div>
    <div class="stat-card">
        <h4>📧 Email</h4>
        <div class="angka" style="font-size: 20px;">{{ auth()->user()->email }}</div>
    </div>
    <div class="stat-card">
        <h4>📦 Total Alat</h4>
        <div class="angka">{{ \App\Models\Alat::count() }}</div>
    </div>
    <div class="stat-card">
        <h4>👥 Total Penyewa</h4>
        <div class="angka">{{ \App\Models\Penyewa::count() }}</div>
    </div>
    <div class="stat-card">
        <h4>🔄 Status</h4>
        <div class="angka" style="font-size: 20px;">Aktif</div>
    </div>
</div>

<div style="background: white; padding: 30px; border-radius: 20px; margin-top: 20px;">
    <h3 style="color: #1b5e2f; margin-bottom: 20px;">Menu Cepat</h3>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <a href="{{ route('alat.index') }}" class="btn-tambah" style="text-decoration: none;">📦 Kelola Alat</a>
        <a href="{{ route('kelola-alat') }}" class="btn-tambah" style="text-decoration: none; background: #ff8c42;">📋 Data Penyewaan</a>
        <a href="{{ route('data-alat') }}" class="btn-tambah" style="text-decoration: none; background: #2196f3;">🔍 Lihat Alat</a>
    </div>
</div>
@endsection

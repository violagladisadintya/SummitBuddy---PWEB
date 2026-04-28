@extends('layouts.app')

@section('title', 'Dashboard - SummitBuddy')

@section('hero')
<div class="hero-small">
    <h1>Dashboard SummitBuddy</h1>
</div>
@endsection

@section('content')
<div class="stat-row">
    <div class="stat-card">
        <h4>📦 Total Alat</h4>
        <div class="angka">8</div>
    </div>
    <div class="stat-card">
        <h4>📊 Total Stok</h4>
        <div class="angka">51</div>
    </div>
    <div class="stat-card">
        <h4>📋 Total Sewa</h4>
        <div class="angka">24</div>
    </div>
    <div class="stat-card">
        <h4>⭐ Rating</h4>
        <div class="angka">4.8</div>
    </div>
</div>

<div class="card" style="padding: 30px;">
    <h1>Selamat Datang di Dashboard SummitBuddy</h1>
    <p>Sistem Informasi Penyewaan Alat Pendakian</p>
    <ul style="margin-top: 20px; margin-left: 20px;">
        <li>📦 Kelola Data Alat Pendakian</li>
        <li>📋 Lihat Daftar Penyewaan</li>
        <li>⭐ Kelola Ulasan Pelanggan</li>
        <li>📊 Lihat Statistik Penyewaan</li>
    </ul>
</div>
@endsection

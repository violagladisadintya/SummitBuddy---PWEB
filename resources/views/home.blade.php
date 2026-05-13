@extends('layouts.app')

@section('title', 'Home - Sewa Alat Pendakian')

@section('hero')
<header class="hero-home">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>SummitBuddy</h1>
        <p>Sistem Penyewaan Alat Pendakian</p>
        <a href="{{ route('form-sewa') }}" class="btn-hero">Sewa Sekarang →</a>
    </div>
</header>
@endsection

@section('content')
<section>
    <h2>⚡ Alat Populer</h2>
    <div class="grid">
        @forelse($alatPopuler as $alat)
        <div class="card">
            <img src="{{ asset($alat['foto']) }}"
                 alt="{{ $alat['nama'] }}"
                 onerror="this.outerHTML='<div style=\'height:180px; background:#e0e0e0; display:flex; align-items:center; justify-content:center;\'>{{ $alat['nama'] }}</div>'"
            <p>{{ $alat['nama'] }}</p>
            <span class="harga">Rp {{ number_format($alat['harga'], 0, ',', '.') }}/hari</span>
        </div>
        @empty
        <p>Belum ada data alat</p>
        @endforelse
    </div>

    <h2>⭐ Ulasan Pelanggan</h2>
    <div class="ulasan-grid">
        @forelse($ulasan as $item)
        <div class="ulasan-card">
            <div class="rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $item['rating']) ★ @else ☆ @endif
                @endfor
            </div>
            <p class="ulasan-text">{{ $item['pesan'] }}</p>
            <div class="ulasan-user">
                <strong>- {{ $item['nama'] }}</strong>
                <span>{{ $item['role'] }}</span>
            </div>
        </div>
        @empty
        <p>Belum ada ulasan</p>
        @endforelse
    </div>
</section>
@endsection

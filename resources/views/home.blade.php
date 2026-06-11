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
                 onerror="this.outerHTML='<div style=\'height:130px; background:#e0e0e0; display:flex; align-items:center; justify-content:center; border-radius:15px;\'>{{ $alat['nama'] }}</div>'">
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

    @if($hasRented)
    <div class="card" style="max-width: 600px; margin: 40px auto 20px auto; padding: 30px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); text-align: left;">
        <h3 style="color: #1b5e2f; margin-bottom: 15px; text-align: center;"><i class="fas fa-edit"></i> Tulis Ulasan Anda</h3>
        <p style="font-size: 13px; color: #666; margin-bottom: 20px; text-align: center;">Sebagai pelanggan yang telah menyewa di SummitBuddy, Anda dapat membagikan pengalaman Anda!</p>
        <form action="{{ route('review.store') }}" method="POST" style="background: none; padding: 0; box-shadow: none; border-radius: 0; max-width: 100%; margin: 0;">
            @csrf
            
            <label for="rating" style="margin-top: 0; font-size: 14px;">Rating Bintang</label>
            <select id="rating" name="rating" required style="width: 100%; border: 2px solid #e8e8e8; border-radius: 12px; padding: 12px; font-size: 14px; background: white; color: #333;">
                <option value="5">★★★★★ (5 - Sangat Puas)</option>
                <option value="4">★★★★☆ (4 - Puas)</option>
                <option value="3">★★★☆☆ (3 - Cukup)</option>
                <option value="2">★★☆☆☆ (2 - Kurang)</option>
                <option value="1">★☆☆☆☆ (1 - Sangat Kurang)</option>
            </select>

            <label for="role" style="font-size: 14px; margin-top: 15px;">Peran / Status Anda</label>
            <input type="text" id="role" name="role" placeholder="Contoh: Mahasiswa, Pendaki Pemula" required style="width: 100%; border: 2px solid #e8e8e8; border-radius: 12px; padding: 12px; font-size: 14px; background: white; color: #333;">

            <label for="pesan" style="font-size: 14px; margin-top: 15px;">Pesan Ulasan</label>
            <textarea id="pesan" name="pesan" rows="4" placeholder="Tuliskan pengalaman Anda menggunakan alat sewa dari SummitBuddy..." required style="width: 100%; border: 2px solid #e8e8e8; border-radius: 12px; padding: 12px; font-size: 14px; background: white; color: #333; font-family: inherit; resize: vertical;"></textarea>

            <button type="submit" style="width: 100%; margin-top: 20px; padding: 12px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; font-weight: bold; cursor: pointer; font-size: 15px; box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);">Kirim Ulasan</button>
        </form>
    </div>
    @endif
</section>
@endsection


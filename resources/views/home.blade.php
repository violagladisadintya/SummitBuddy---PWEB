@extends('layouts.app')

@section('title', 'Home - SummitBuddy')

@section('hero')
<div class="hero">
    <div>
        <h1>SummitBuddy</h1>
        <p>Sistem Penyewaan Alat Pendakian</p>
    </div>
</div>
@endsection

@section('content')
<h2>⚡ Alat Populer</h2>
<div class="grid">
    <div class="card">
        <p>Tenda</p>
        <span class="harga">Rp 100.000/hari</span>
    </div>
    <div class="card">
        <p>Carrier</p>
        <span class="harga">Rp 80.000/hari</span>
    </div>
    <div class="card">
        <p>Sleeping Bag</p>
        <span class="harga">Rp 50.000/hari</span>
    </div>
    <div class="card">
        <p>Kompor</p>
        <span class="harga">Rp 40.000/hari</span>
    </div>
    <div class="card">
        <p>Matras</p>
        <span class="harga">Rp 30.000/hari</span>
    </div>
</div>

<h2>⭐ Ulasan Pelanggan</h2>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px;">
    <div class="card" style="text-align: left;">
        <div style="color: #ffc107;">★★★★★</div>
        <p>"Alat lengkap dan berkualitas! Pelayanannya ramah."</p>
        <strong>- Andi Pratama</strong>
    </div>
    <div class="card" style="text-align: left;">
        <div style="color: #ffc107;">★★★★★</div>
        <p>"Tenda dan carrier dalam kondisi prima. Recommended!"</p>
        <strong>- Sari Dewi</strong>
    </div>
    <div class="card" style="text-align: left;">
        <div style="color: #ffc107;">★★★★☆</div>
        <p>"Pelayanan cepat, alat lengkap. Overall oke!"</p>
        <strong>- Budi Santoso</strong>
    </div>
    <div class="card" style="text-align: left;">
        <div style="color: #ffc107;">★★★★★</div>
        <p>"Sewa matras dan sleeping bag, bersih dan wangi. Mantap!"</p>
        <strong>- Rina Wahyuni</strong>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Detail Alat')

@section('content')
<div class="container">
    <h1>Detail Alat</h1>

    @if($alat->foto)
        <img src="{{ asset('storage/' . $alat->foto) }}" width="200" style="border-radius: 15px;">
    @endif

    <p><strong>Kode:</strong> {{ $alat->kode }}</p>
    <p><strong>Nama:</strong> {{ $alat->nama }}</p>
    <p><strong>Kategori:</strong> {{ $alat->kategori }}</p>
    <p><strong>Stok:</strong> {{ $alat->stok }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($alat->harga, 0, ',', '.') }}/hari</p>
    <p><strong>Deskripsi:</strong> {{ $alat->deskripsi }}</p>
    <p><strong>Tanggal Masuk:</strong> {{ $alat->tgl_masuk }}</p>

    <a href="{{ route('alat.index') }}" class="btn-tambah">Kembali</a>
</div>
@endsection

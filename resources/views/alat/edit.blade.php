@extends('layouts.app')

@section('title', 'Edit Alat')

@section('content')
<div class="container">
    <h1>Edit Alat</h1>

    <form action="{{ route('alat.update', $alat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Kode Alat *</label>
        <input type="text" name="kode" value="{{ old('kode', $alat->kode) }}">
        @error('kode') <small class="error">{{ $message }}</small> @enderror

        <label>Nama Alat *</label>
        <input type="text" name="nama" value="{{ old('nama', $alat->nama) }}">
        @error('nama') <small class="error">{{ $message }}</small> @enderror

        <label>Kategori *</label>
        <select name="kategori">
            <option value="Tenda" {{ $alat->kategori == 'Tenda' ? 'selected' : '' }}>Tenda</option>
            <option value="Carrier" {{ $alat->kategori == 'Carrier' ? 'selected' : '' }}>Carrier</option>
            <option value="Sleeping" {{ $alat->kategori == 'Sleeping' ? 'selected' : '' }}>Sleeping Bag</option>
            <option value="Kompor" {{ $alat->kategori == 'Kompor' ? 'selected' : '' }}>Kompor</option>
            <option value="Aksesoris" {{ $alat->kategori == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
        </select>
        @error('kategori') <small class="error">{{ $message }}</small> @enderror

        <label>Stok *</label>
        <input type="number" name="stok" value="{{ old('stok', $alat->stok) }}">
        @error('stok') <small class="error">{{ $message }}</small> @enderror

        <label>Harga/Hari *</label>
        <input type="number" name="harga" value="{{ old('harga', $alat->harga) }}">
        @error('harga') <small class="error">{{ $message }}</small> @enderror

        <label>Deskripsi</label>
        <textarea name="deskripsi">{{ old('deskripsi', $alat->deskripsi) }}</textarea>

        @if($alat->foto)
            <label>Foto Saat Ini</label>
            <img src="{{ asset('storage/' . $alat->foto) }}" width="100" style="border-radius: 10px;">
        @endif

        <label>Ganti Foto</label>
        <input type="file" name="foto">
        @error('foto') <small class="error">{{ $message }}</small> @enderror

        <label>Tanggal Masuk *</label>
        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $alat->tgl_masuk) }}">
        @error('tgl_masuk') <small class="error">{{ $message }}</small> @enderror

        <button type="submit">Update Alat</button>
    </form>
</div>
@endsection

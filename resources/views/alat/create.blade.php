@extends('layouts.app')

@section('title', 'Tambah Alat')

@section('content')
<div class="container">
    <h1>Tambah Alat Baru</h1>

    <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Kode Alat *</label>
        <input type="text" name="kode" value="{{ old('kode') }}">
        @error('kode') <small class="error">{{ $message }}</small> @enderror

        <label>Nama Alat *</label>
        <input type="text" name="nama" value="{{ old('nama') }}">
        @error('nama') <small class="error">{{ $message }}</small> @enderror

        <label>Kategori *</label>
        <select name="kategori">
            <option value="">Pilih Kategori</option>
            <option value="Tenda">Tenda</option>
            <option value="Carrier">Carrier</option>
            <option value="Sleeping">Sleeping Bag</option>
            <option value="Kompor">Kompor</option>
            <option value="Aksesoris">Aksesoris</option>
        </select>
        @error('kategori') <small class="error">{{ $message }}</small> @enderror

        <label>Stok *</label>
        <input type="number" name="stok" value="{{ old('stok', 0) }}">
        @error('stok') <small class="error">{{ $message }}</small> @enderror

        <label>Harga/Hari *</label>
        <input type="number" name="harga" value="{{ old('harga') }}">
        @error('harga') <small class="error">{{ $message }}</small> @enderror

        <label>Deskripsi</label>
        <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>

        <label>Foto</label>
        <input type="file" name="foto">
        @error('foto') <small class="error">{{ $message }}</small> @enderror

        <label>Tanggal Masuk *</label>
        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}">
        @error('tgl_masuk') <small class="error">{{ $message }}</small> @enderror

        <button type="submit">Simpan Alat</button>
    </form>
</div>
@endsection

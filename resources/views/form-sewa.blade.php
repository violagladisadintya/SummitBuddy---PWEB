@extends('layouts.app')

@section('title', 'Form Penyewaan Alat - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Form Penyewaan Alat</h1>
        <p>Isi data dengan lengkap untuk menyewa alat</p>
    </div>
</header>
@endsection

@section('content')
<section>
    <form action="{{ route('form-sewa.store') }}" method="POST">
        @csrf

        <label for="nama">Nama Penyewa *</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
        @error('nama') <small style="color:red">{{ $message }}</small> @enderror

        <label for="no_hp">No HP *</label>
        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
        @error('no_hp') <small style="color:red">{{ $message }}</small> @enderror

        <label for="alat_id">Nama Alat *</label>
        <select id="alat_id" name="alat_id" required>
            <option value="">-- Pilih Alat --</option>
            @foreach($daftarAlat as $alat)
            <option value="{{ $alat['id'] }}" {{ old('alat_id') == $alat['id'] ? 'selected' : '' }}>
                {{ $alat['nama'] }} - Rp {{ number_format($alat['harga'], 0, ',', '.') }}/hari
            </option>
            @endforeach
        </select>
        @error('alat_id') <small style="color:red">{{ $message }}</small> @enderror

        <label for="jumlah">Jumlah *</label>
        <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
        @error('jumlah') <small style="color:red">{{ $message }}</small> @enderror

        <label for="tgl_sewa">Tanggal Sewa *</label>
        <input type="date" id="tgl_sewa" name="tgl_sewa" value="{{ old('tgl_sewa') }}" required>
        @error('tgl_sewa') <small style="color:red">{{ $message }}</small> @enderror

        <label for="tgl_kembali">Tanggal Kembali *</label>
        <input type="date" id="tgl_kembali" name="tgl_kembali" value="{{ old('tgl_kembali') }}" required>
        @error('tgl_kembali') <small style="color:red">{{ $message }}</small> @enderror

        <label for="keterangan">Keterangan (opsional)</label>
        <textarea id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>

        <button type="submit"><i class="fas fa-calendar-check"></i> Sewa Sekarang</button>
    </form>

    <div style="margin-top: 30px; text-align: center; font-size: 14px; color: #666;">
        * Harga dihitung berdasarkan jumlah alat × harga per hari × lama sewa
    </div>
</section>
@endsection

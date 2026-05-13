@extends('layouts.app')

@section('title', 'Data Alat Pendakian')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Data Alat Pendakian</h1>
        <p>Lengkapi persiapan pendakianmu dengan alat terbaik</p>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <a href="{{ route('alat.create') }}" class="btn-tambah">+ Tambah Alat</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $key => $alat)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if($alat->foto)
                            <img src="{{ asset('storage/' . $alat->foto) }}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
                        @else
                            <img src="https://via.placeholder.com/50?text=No+Image" width="50" height="50">
                        @endif
                    </td>
                    <td>{{ $alat->kode }}</td>
                    <td>{{ $alat->nama }}</td>
                    <td>{{ $alat->kategori }}</td>
                    <td>{{ $alat->stok }}</td>
                    <td>Rp {{ number_format($alat->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('alat.edit', $alat) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('alat.destroy', $alat) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center">Belum ada data alat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $alats->links() }}
</div>
@endsection

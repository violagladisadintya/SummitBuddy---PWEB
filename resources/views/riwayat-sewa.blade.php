@extends('layouts.app')

@section('title', 'Riwayat Penyewaan - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Riwayat Penyewaan</h1>
        <p>Lihat status dan bukti penyewaan alat pendakianmu</p>
    </div>
</header>
@endsection

@section('content')
<section style="margin-top: 20px;">
    <h2>📋 Daftar Riwayat Sewa</h2>
    
    <div class="table-container">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Invoice</th>
                    <th>Alat & Jumlah</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Total Biaya</th>
                    <th>Metode & Status Bayar</th>
                    <th>Status Sewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $invoiceCode => $items)
                @php
                    $firstItem = $items->first();
                    $totalHarga = $items->sum('total_harga');
                    
                    $itemNames = [];
                    foreach ($items as $item) {
                        $itemNames[] = ($item->alat ? $item->alat->nama : 'Alat Terhapus') . ' (' . $item->jumlah . ' Pcs)';
                    }
                    $itemList = implode(', ', $itemNames);
                @endphp
                <tr>
                    <td data-label="No" style="padding: 15px;">{{ $loop->iteration }}</td>
                    <td data-label="No. Invoice" style="padding: 15px; font-weight: bold; color: #1b5e2f;">{{ $invoiceCode }}</td>
                    <td data-label="Alat & Jumlah" style="padding: 15px;">{{ $itemList }}</td>
                    <td data-label="Tgl Sewa" style="padding: 15px;">{{ $firstItem->tgl_sewa->format('d M Y') }}</td>
                    <td data-label="Tgl Kembali" style="padding: 15px;">{{ $firstItem->tgl_kembali->format('d M Y') }}</td>
                    <td data-label="Total Biaya" style="padding: 15px; font-weight: bold; color: #ff8c42;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    <td data-label="Metode & Status Bayar" style="padding: 15px;">
                        <span style="font-weight: 500; font-size: 13px; display: block; margin-bottom: 4px;">{{ $firstItem->metode_pembayaran ?: 'Transfer' }}</span>
                        @if($firstItem->status_pembayaran === 'Lunas')
                            <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Lunas</span>
                        @elseif($firstItem->status_pembayaran === 'Menunggu Verifikasi')
                            <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Perlu Verifikasi</span>
                        @elseif($firstItem->status_pembayaran === 'COD (Bayar di Tempat)')
                            <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">COD</span>
                        @else
                            <span style="background: #ffebee; color: #c62828; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Belum Bayar</span>
                        @endif
                    </td>
                    <td data-label="Status Sewa" style="padding: 15px;">
                        @if($firstItem->status === 'aktif')
                            <span style="background: #e8f5e9; color: #2e7d32; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Aktif</span>
                        @elseif($firstItem->status === 'selesai')
                            <span style="background: #e3f2fd; color: #1565c0; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Selesai</span>
                        @else
                            <span style="background: #ffebee; color: #c62828; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Dibatalkan</span>
                        @endif
                    </td>
                    <td data-label="Aksi" style="padding: 15px;">
                        <a href="{{ route('sewa.bukti', $invoiceCode) }}" class="btn-edit" style="text-decoration: none; display: inline-block; padding: 8px 16px; border-radius: 30px; font-weight: 600;">
                            <i class="fas fa-file-invoice"></i> Bukti Sewa
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #888;">
                        <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 10px; display: block; color: #ccc;"></i>
                        Belum ada riwayat penyewaan. Yuk sewa alat pendakianmu sekarang!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

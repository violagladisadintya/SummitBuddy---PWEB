@extends('layouts.app')

@section('title', 'Bukti Penyewaan - SummitBuddy')

@section('content')
<div class="receipt-outer-container">
    <div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('riwayat-sewa') }}" style="text-decoration: none; color: #1b5e2f; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
        </a>
        <button onclick="window.print()" style="background: linear-gradient(135deg, #1b5e2f, #43a047); border: none; border-radius: 30px; color: white; padding: 10px 24px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-print"></i> Cetak Bukti Sewa
        </button>
    </div>

    <div class="receipt-card">
        <div class="receipt-header">
            <div class="receipt-logo">
                <i class="fas fa-mountain" style="font-size: 36px; color: #1b5e2f;"></i>
                <div>
                    <h2>SummitBuddy</h2>
                    <p>Sewa Alat Pendakian Berkualitas</p>
                </div>
            </div>
            <div class="receipt-invoice-info">
                <h3>BUKTI PENYEWAAN</h3>
                <span class="invoice-num">{{ $sewaFirst->invoice_code }}</span>
                <span class="invoice-date">Dibuat: {{ $sewaFirst->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <hr class="receipt-divider">

        <div class="receipt-info-grid">
            <div>
                <h4>Rincian Penyewa:</h4>
                <p><strong>Nama:</strong> {{ $sewaFirst->nama }}</p>
                <p><strong>No. HP:</strong> {{ $sewaFirst->no_hp }}</p>
                <p><strong>Akun Renter:</strong> {{ $sewaFirst->user->name }} ({{ $sewaFirst->user->email }})</p>
            </div>
            <div class="receipt-status-box">
                <h4>Rincian Pembayaran:</h4>
                <p style="margin: 2px 0;"><strong>Metode:</strong> {{ $sewaFirst->metode_pembayaran ?: 'Transfer' }}</p>
                <p style="margin: 2px 0 8px 0;"><strong>Status Bayar:</strong>
                    @if($sewaFirst->status_pembayaran === 'Lunas')
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Lunas</span>
                    @elseif($sewaFirst->status_pembayaran === 'Menunggu Verifikasi')
                        <span style="background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Menunggu Verifikasi</span>
                    @elseif($sewaFirst->status_pembayaran === 'COD (Bayar di Tempat)')
                        <span style="background: #e3f2fd; color: #1565c0; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">COD (Bayar Tunai)</span>
                    @else
                        <span style="background: #ffebee; color: #c62828; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Belum Bayar</span>
                    @endif
                </p>
                
                <h4>Status Sewa:</h4>
                @if($sewaFirst->status === 'aktif')
                    <span class="status-badge status-aktif" style="margin-top: 4px;">AKTIF (Siap Diambil)</span>
                @elseif($sewaFirst->status === 'selesai')
                    <span class="status-badge status-selesai" style="margin-top: 4px;">SELESAI</span>
                @else
                    <span class="status-badge status-batal" style="margin-top: 4px;">DIBATALKAN</span>
                @endif
            </div>
        </div>

        @php
            $tgl1 = new \DateTime($sewaFirst->tgl_sewa);
            $tgl2 = new \DateTime($sewaFirst->tgl_kembali);
            $lamaHari = $tgl2->diff($tgl1)->days ?: 1;
        @endphp

        <table class="receipt-table responsive-table">
            <thead>
                <tr>
                    <th>Deskripsi Alat</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal ({{ $lamaHari }} hari)</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($rentals as $rental)
                @php $grandTotal += $rental->total_harga; @endphp
                <tr>
                    <td data-label="Deskripsi Alat">
                        <strong>{{ $rental->alat ? $rental->alat->nama : 'Alat Terhapus' }}</strong><br>
                        <small style="color: #777;">Kategori: {{ $rental->alat ? $rental->alat->kategori : '-' }}</small>
                    </td>
                    <td data-label="Jumlah" style="text-align: center;">{{ $rental->jumlah }} Pcs</td>
                    <td data-label="Harga Satuan" style="text-align: right;">Rp {{ number_format($rental->alat ? $rental->alat->harga : 0, 0, ',', '.') }}/hari</td>
                    <td data-label="Subtotal" style="text-align: right;">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="receipt-total-row">
                    <td colspan="3" style="text-align: right; font-size: 18px; font-weight: 800; color: #1b5e2f;">Grand Total:</td>
                    <td style="text-align: right; font-size: 18px; font-weight: 800; color: #ff8c42;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="receipt-dates">
            <div class="date-col">
                <span>Tanggal Pengambilan:</span>
                <strong>{{ $sewaFirst->tgl_sewa->format('d M Y') }}</strong>
            </div>
            <div class="date-col">
                <span>Tanggal Pengembalian:</span>
                <strong>{{ $sewaFirst->tgl_kembali->format('d M Y') }}</strong>
            </div>
        </div>

        @if(!empty($sewaFirst->custom_answers))
        <div class="receipt-answers" style="margin-top: 25px; background: #f8fbf9; padding: 20px; border-radius: 16px; border: 1px solid #e2f0e5;">
            <strong style="color: #1b5e2f; display: block; margin-bottom: 12px; font-size: 15px;"><i class="fas fa-info-circle"></i> Informasi Tambahan Form:</strong>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px;">
                @foreach($sewaFirst->custom_answers as $qLabel => $ans)
                    <div>
                        <span style="font-size: 11px; color: #777; text-transform: uppercase; display: block;">{{ $qLabel }}</span>
                        <strong style="font-size: 14px; color: #333;">{{ $ans }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($sewaFirst->bukti_pembayaran)
        <div class="receipt-payment-proof" style="margin-top: 25px; background: #fdfdfd; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; text-align: center;">
            <strong style="color: #1b5e2f; display: block; margin-bottom: 12px; font-size: 15px; text-align: left;"><i class="fas fa-file-invoice-dollar"></i> Bukti Transfer Pembayaran:</strong>
            <img src="{{ asset($sewaFirst->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #ddd;">
        </div>
        @endif

        @if($sewaFirst->keterangan)
        <div class="receipt-notes" style="margin-top: 20px; background: #fafafa; padding: 15px; border-radius: 8px;">
            <strong>Catatan Renter:</strong>
            <p style="margin: 5px 0 0 0; font-style: italic; color: #666;">{{ $sewaFirst->keterangan }}</p>
        </div>
        @endif

        <hr class="receipt-divider" style="margin: 30px 0 20px 0;">

        <div class="receipt-footer">
            <div class="receipt-instructions">
                <h5>⚠️ Petunjuk Pengambilan Barang:</h5>
                <ol>
                    <li style="margin-bottom: 6px;">Ambil barang sewaan Anda di alamat store kami: <strong>SummitBuddy Jember, Jl. Mastrip No. 45, Kecamatan Sumbersari, Jember Kota (Depan Kampus UNEJ)</strong>.</li>
                    <li style="margin-bottom: 6px;">Tunjukkan bukti sewa ini (cetak atau layar handphone) kepada petugas store.</li>
                    @if($sewaFirst->metode_pembayaran === 'Tunai' || $sewaFirst->status_pembayaran === 'COD (Bayar di Tempat)')
                        <li style="margin-bottom: 6px; color: #2e7d32; font-weight: 600;">Lakukan pembayaran tunai / cash secara langsung kepada kasir toko saat mengambil barang.</li>
                    @endif
                    <li style="margin-bottom: 6px;">Bawa kartu identitas penyewa yang sah (KTP / KTM / SIM) asli untuk jaminan sewa.</li>
                    <li style="margin-bottom: 6px;">Lakukan pengecekan kondisi kelengkapan alat bersama petugas sebelum meninggalkan store.</li>
                    <li style="margin-bottom: 6px;">Keterlambatan pengembalian akan dikenakan denda sesuai dengan tarif per hari.</li>
                </ol>
            </div>
            <div class="receipt-qr">
                <i class="fas fa-qrcode" style="font-size: 80px; color: #333;"></i>
                <span style="font-size: 10px; color: #999; margin-top: 5px;">VERIFIED SYSTEM</span>
            </div>
        </div>
    </div>
</div>

<style>
.receipt-outer-container {
    max-width: 800px;
    margin: 30px auto;
}
.receipt-card {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    border: 1px solid #eef2ee;
    position: relative;
    color: #333;
}
.receipt-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.receipt-logo {
    display: flex;
    align-items: center;
    gap: 15px;
}
.receipt-logo h2 {
    color: #1b5e2f;
    margin: 0;
    font-size: 28px;
    font-weight: 800;
}
.receipt-logo p {
    margin: 0;
    font-size: 12px;
    color: #666;
}
.receipt-invoice-info {
    text-align: right;
}
.receipt-invoice-info h3 {
    color: #1b5e2f;
    margin: 0 0 5px 0;
    font-size: 20px;
    letter-spacing: 1px;
}
.invoice-num {
    display: block;
    font-size: 16px;
    font-weight: 700;
    color: #ff8c42;
}
.invoice-date {
    display: block;
    font-size: 12px;
    color: #888;
}
.receipt-divider {
    border: none;
    border-top: 2px dashed #e2e8f0;
    margin: 25px 0;
}
.receipt-info-grid {
    display: grid;
    grid-template-columns: 2fr 1.2fr;
    gap: 20px;
    margin-bottom: 25px;
}
.receipt-info-grid h4 {
    margin: 0 0 8px 0;
    color: #1b5e2f;
    font-size: 14px;
    text-transform: uppercase;
}
.receipt-info-grid p {
    margin: 4px 0;
    font-size: 14px;
}
.receipt-status-box {
    background: #f7faf7;
    padding: 15px;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.status-badge {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
}
.status-aktif {
    background: #e8f5e9;
    color: #2e7d32;
}
.status-selesai {
    background: #e3f2fd;
    color: #1565c0;
}
.status-batal {
    background: #ffebee;
    color: #c62828;
}
.receipt-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}
.receipt-table th {
    background: #f1f8f3;
    color: #1b5e2f;
    padding: 12px;
    font-weight: 700;
    border-bottom: 2px solid #e2f0e5;
}
.receipt-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}
.receipt-total-row td {
    border-bottom: none;
    padding-top: 20px;
}
.receipt-dates {
    display: flex;
    justify-content: space-between;
    background: #f8faf8;
    padding: 20px;
    border-radius: 16px;
    margin-top: 25px;
}
.date-col {
    display: flex;
    flex-direction: column;
}
.date-col span {
    font-size: 11px;
    color: #777;
    text-transform: uppercase;
}
.date-col strong {
    font-size: 16px;
    color: #1b5e2f;
    margin-top: 4px;
}
.receipt-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 30px;
}
.receipt-instructions {
    flex-grow: 1;
}
.receipt-instructions h5 {
    color: #c0392b;
    font-size: 14px;
    margin: 0 0 10px 0;
}
.receipt-instructions ol {
    padding-left: 20px;
    font-size: 12px;
    color: #555;
}
.receipt-instructions li {
    margin-bottom: 6px;
}
.receipt-qr {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Responsive Styling for Screen (not printing) */
@media screen and (max-width: 600px) {
    .receipt-card {
        padding: 20px;
        border-radius: 16px;
    }
    .receipt-header {
        flex-direction: column;
        gap: 15px;
    }
    .receipt-invoice-info {
        text-align: left;
    }
    .receipt-info-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    .receipt-status-box {
        align-items: flex-start;
    }
    .receipt-dates {
        flex-direction: column;
        gap: 12px;
    }
    .receipt-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 20px;
    }
    .receipt-qr {
        align-self: center;
    }

    /* Responsive Table (transform to card lists) */
    .receipt-table thead {
        display: none;
    }
    .receipt-table tbody,
    .receipt-table tr,
    .receipt-table td {
        display: block;
        width: 100%;
    }
    .receipt-table tr {
        border: 1px solid #e2f0e5;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 12px;
        background: #fdfdfd;
    }
    .dark .receipt-table tr {
        background: #22223b;
        border-color: #3d3d5c;
    }
    .receipt-table td {
        text-align: right !important;
        padding: 8px 0;
        border-bottom: 1px dashed #e2f0e5 !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }
    .dark .receipt-table td {
        border-bottom-color: #3d3d5c !important;
    }
    .receipt-table td:last-child {
        border-bottom: none !important;
    }
    .receipt-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #1b5e2f;
        text-align: left;
        margin-right: 15px;
    }
    .dark .receipt-table td::before {
        color: #ff8c42;
    }
    
    /* Total row overrides */
    .receipt-total-row {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }
    .receipt-total-row td {
        display: flex;
        justify-content: space-between;
        border: none !important;
        padding: 10px 0;
    }
    .receipt-total-row td::before {
        display: none;
    }
}

/* Print Styling */
@media print {
    body {
        background: white !important;
        color: black !important;
    }
    nav, footer, .no-print, .dark-mode-toggle {
        display: none !important;
    }
    .container {
        padding: 0 !important;
        margin: 0 !important;
    }
    .receipt-outer-container {
        margin: 0 !important;
        max-width: 100% !important;
    }
    .receipt-card {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection

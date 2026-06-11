@extends('layouts.app')

@section('title', 'Kelola Alat & Penyewaan - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Admin Panel</h1>
        <p>Kelola Alat & Penyewaan</p>
    </div>
</header>
@endsection

@section('content')
<div class="tab-buttons">
    <button class="tab-btn active" onclick="showTab('alat')">📦 Kelola Alat</button>
    <button class="tab-btn" onclick="showTab('sewa')">📋 Daftar Penyewaan</button>
</div>

<!-- TAB 1: KELOLA ALAT -->
<div id="tab-alat" class="tab-content active">
    <div class="stat-row">
        <div class="stat-card"><h4>📦 Total Alat</h4><div class="angka" id="statTotalAlat">{{ $totalAlat }}</div></div>
        <div class="stat-card"><h4>📦 Total Stok</h4><div class="angka" id="statTotalStok">{{ $totalStok }}</div></div>
        <div class="stat-card"><h4>💰 Total Nilai</h4><div class="angka" id="statTotalNilai">Rp {{ number_format($totalNilai, 0, ',', '.') }}</div></div>
        <div class="stat-card"><h4>⚠️ Stok Menipis</h4><div class="angka" id="statStokMenipis">{{ $stokMenipis }}</div></div>
        <div class="stat-card"><h4>📋 Total Sewa</h4><div class="angka" id="statTotalSewa">{{ $totalSewa }}</div></div>
    </div>

    <button class="btn-tambah" onclick="openTambahModal()">+ Tambah Alat Baru</button>

    <div class="table-container">
        <table id="alatTable" class="responsive-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga/Hari</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="alatBody">
                @forelse($alats as $alat)
                <tr id="row-{{ $alat->id }}" class="{{ $alat->stok < 5 ? 'stok-warning' : '' }}">
                    <td data-label="Foto" style="padding: 12px;">
                        @php
                            $fotoPath = $alat->foto;
                            if ($fotoPath && !str_starts_with($fotoPath, 'image/') && !str_starts_with($fotoPath, 'http')) {
                                $fotoPath = 'storage/' . $fotoPath;
                            }
                        @endphp
                        <img src="{{ asset($fotoPath ?: 'https://via.placeholder.com/50?text=No+Image') }}" width="50" height="50" style="object-fit:cover; border-radius:8px;" onerror="this.src='https://via.placeholder.com/50?text=No+Image'">
                    </td>
                    <td data-label="Kode" style="padding: 12px;">{{ $alat->kode }}</td>
                    <td data-label="Nama" style="padding: 12px;">{{ $alat->nama }}</td>
                    <td data-label="Kategori" style="padding: 12px;">{{ $alat->kategori }}</td>
                    <td data-label="Stok" class="stok-{{ $alat->id }}" style="padding: 12px; font-weight: {{ $alat->stok < 5 ? 'bold' : 'normal' }}; color: {{ $alat->stok < 5 ? '#d35400' : 'inherit' }};">{{ $alat->stok }}</td>
                    <td data-label="Harga/Hari" style="padding: 12px;">Rp {{ number_format($alat->harga, 0, ',', '.') }}</td>
                    <td data-label="Aksi" style="padding: 12px;">
                        <button class="btn-edit" onclick="editAlat({{ $alat->id }})">✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusAlat({{ $alat->id }})">🗑️ Hapus</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center">Tidak ada data alat di database.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 15px;">
        {{ $alats->links() }}
    </div>
</div>

<!-- TAB 2: DAFTAR PENYEWAAN -->
<div id="tab-sewa" class="tab-content" style="display: none;">
    <!-- Statistik Laporan Penyewaan -->
    <div class="stat-row">
        <div class="stat-card">
            <h4>💰 Pendapatan (Lunas)</h4>
            <div class="angka" style="font-size: 24px; color: #2e7d32;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h4>📋 Sewa Aktif</h4>
            <div class="angka" style="color: #1b5e2f;">{{ $sewaAktif }}</div>
        </div>
        <div class="stat-card">
            <h4>✅ Sewa Selesai</h4>
            <div class="angka" style="color: #1565c0;">{{ $sewaSelesai }}</div>
        </div>
        <div class="stat-card">
            <h4>⏳ Perlu Verifikasi</h4>
            <div class="angka" style="color: #e67e22;">{{ $menungguVerifikasi }}</div>
        </div>
    </div>

    <button class="btn-tambah" onclick="openTambahSewaModal()" style="margin-bottom: 20px; margin-top: 10px;">+ Tambah Penyewaan Baru</button>
    
    <div class="table-container">
        <table id="sewaTable" class="responsive-table">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Nama Penyewa</th>
                    <th>No HP</th>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Total Biaya</th>
                    <th>Metode & Status Bayar</th>
                    <th>Status Sewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="sewaBody">
                @forelse($daftarSewa as $index => $sewa)
                <tr id="sewa-row-{{ $sewa['id'] }}">
                    <td data-label="No Invoice" style="padding: 12px; font-weight: bold; color: #1b5e2f;">
                        <a href="{{ route('sewa.bukti', $sewa['invoice_code']) }}" target="_blank" style="text-decoration: none; color: #1b5e2f;">
                            {{ $sewa['invoice_code'] }} <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                        </a>
                    </td>
                    <td data-label="Nama Penyewa" style="padding: 12px;">{{ $sewa['nama'] }}</td>
                    <td data-label="No HP" style="padding: 12px;">{{ $sewa['noHp'] }}</td>
                    <td data-label="Nama Alat" style="padding: 12px;">{{ $sewa['alat'] }}</td>
                    <td data-label="Jumlah" style="padding: 12px;">{{ $sewa['jumlah'] }} Pcs</td>
                    <td data-label="Tgl Sewa" style="padding: 12px;">{{ $sewa['tglSewa'] }}</td>
                    <td data-label="Tgl Kembali" style="padding: 12px;">{{ $sewa['tglKembali'] }}</td>
                    <td data-label="Total Biaya" style="padding: 12px; font-weight: bold;">Rp {{ number_format($sewa['totalHarga'], 0, ',', '.') }}</td>
                    <td data-label="Metode & Status Bayar" style="padding: 12px;">
                        <span style="font-weight: 500; font-size: 13px; display: block; margin-bottom: 4px;">{{ $sewa['metode_pembayaran'] ?: 'Transfer' }}</span>
                        @if($sewa['status_pembayaran'] === 'Lunas')
                            <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Lunas</span>
                        @elseif($sewa['status_pembayaran'] === 'Menunggu Verifikasi')
                            <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Perlu Verifikasi</span>
                            @if($sewa['bukti_pembayaran'])
                                <a href="{{ asset($sewa['bukti_pembayaran']) }}" target="_blank" style="margin-left: 5px; color: #43a047; font-weight: 600; font-size: 11px; text-decoration: none;"><i class="fas fa-image"></i> Lihat</a>
                            @endif
                        @elseif($sewa['status_pembayaran'] === 'COD (Bayar di Tempat)')
                            <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">COD</span>
                        @else
                            <span style="background: #ffebee; color: #c62828; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">Belum Bayar</span>
                        @endif
                    </td>
                    <td data-label="Status Sewa" style="padding: 12px;">
                        @if($sewa['status'] === 'aktif')
                            <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Aktif</span>
                        @elseif($sewa['status'] === 'selesai')
                            <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Selesai</span>
                        @else
                            <span style="background: #ffebee; color: #c62828; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Batal</span>
                        @endif
                    </td>
                    <td data-label="Aksi" style="padding: 12px; display: flex; gap: 5px;">
                        <button class="btn-edit" onclick='editSewa({!! json_encode($sewa) !!})'>✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusSewa({{ $sewa['id'] }})">🗑️ Batalkan</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" style="text-align:center">Belum ada transaksi penyewaan aktif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT ALAT -->
<div id="modalAlat" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 90%; max-width: 450px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalTitle" style="font-size: 20px; margin: 0; color: #1b5e2f;">Tambah Alat Baru</h3>
            <span onclick="closeModal()" style="font-size: 28px; cursor: pointer; color: #999; line-height: 1;">&times;</span>
        </div>

        <form id="formAlat" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div id="methodFieldContainer"></div>

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Kode Alat *</label>
            <input type="text" id="kodeAlat" name="kode" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Nama Alat *</label>
            <input type="text" id="namaAlat" name="nama" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Kategori *</label>
            <select id="kategoriAlat" name="kategori" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white;">
                <option value="">Pilih Kategori</option>
                <option value="Tenda">Tenda</option>
                <option value="Carrier">Carrier</option>
                <option value="Sleeping">Sleeping Bag</option>
                <option value="Kompor">Kompor</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Stok *</label>
            <input type="number" id="stokAlat" name="stok" min="0" value="0" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Harga/Hari (Rp) *</label>
            <input type="number" id="hargaAlat" name="harga" min="0" value="0" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Tanggal Masuk *</label>
            <input type="date" id="tglMasuk" name="tgl_masuk" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Foto Alat</label>
            <input type="file" id="fotoAlat" name="foto" accept="image/jpeg,image/png,image/jpg" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            <small style="display: block; margin-top: 5px; font-size: 11px; color: #666;">Kosongkan jika tidak ingin mengubah foto</small>

            <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; font-weight: bold; margin-top: 20px; cursor: pointer; font-size: 15px;">Simpan Alat</button>
        </form>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT SEWA -->
<div id="modalSewa" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 90%; max-width: 450px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalSewaTitle" style="font-size: 20px; margin: 0; color: #1b5e2f;">Tambah Penyewaan Baru</h3>
            <span onclick="closeSewaModal()" style="font-size: 28px; cursor: pointer; color: #999; line-height: 1;">&times;</span>
        </div>

        <form id="formSewaAdmin" method="POST" action="">
            @csrf
            <div id="methodFieldSewaContainer"></div>

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Nama Renter *</label>
            <input type="text" id="sewaNama" name="nama" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">No HP *</label>
            <input type="text" id="sewaNoHp" name="no_hp" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Alat *</label>
            <select id="sewaAlatId" name="alat_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; color: #333;">
                <option value="">Pilih Alat</option>
                @foreach($alats as $a)
                <option value="{{ $a->id }}">{{ $a->nama }} (Stok: {{ $a->stok }})</option>
                @endforeach
            </select>

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Jumlah *</label>
            <input type="number" id="sewaJumlah" name="jumlah" min="1" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Tanggal Sewa *</label>
            <input type="date" id="sewaTglSewa" name="tgl_sewa" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Tanggal Kembali *</label>
            <input type="date" id="sewaTglKembali" name="tgl_kembali" required style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Keterangan</label>
            <textarea id="sewaKeterangan" name="keterangan" rows="2" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; color:#333; font-family:inherit;"></textarea>

            <div id="adminSewaStatusContainer" style="display: none;">
                <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Status Sewa *</label>
                <select id="sewaStatus" name="status" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; color: #333;">
                    <option value="aktif">Aktif (Sedang Dipinjam)</option>
                    <option value="selesai">Selesai (Sudah Dikembalikan)</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>

                <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Status Pembayaran *</label>
                <select id="sewaStatusPembayaran" name="status_pembayaran" style="width: 100%; padding: 10px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; color: #333;">
                    <option value="Belum Bayar">Belum Bayar</option>
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Lunas">Lunas</option>
                    <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                </select>
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; font-weight: bold; margin-top: 20px; cursor: pointer; font-size: 15px;">Simpan Penyewaan</button>
        </form>
    </div>
</div>

<style>
.tab-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 10px;
}
.tab-btn {
    background: none;
    border: none;
    font-size: 16px;
    font-weight: 600;
    color: #888;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
}
@media (max-width: 480px) {
    .tab-buttons {
        flex-wrap: wrap;
        gap: 10px;
    }
    .tab-btn {
        flex: 1;
        text-align: center;
        font-size: 14px;
        padding: 8px 12px;
        min-width: 120px;
    }
}
.tab-btn.active {
    color: #1b5e2f;
    background: rgba(27, 94, 47, 0.1);
}
.dark .tab-btn.active {
    color: #ff8c42 !important;
    background: rgba(255, 140, 66, 0.15);
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.modal input, .modal select, .modal textarea {
    background: white;
    color: #333;
}
.dark .modal div {
    background: #22223b !important;
    color: white !important;
}
.dark .modal input, .dark .modal select, .dark .modal textarea {
    background: #12121e !important;
    border-color: #3d3d5c !important;
    color: white !important;
}
.dark .modal h3 {
    color: #ff8c42 !important;
}
.dark .modal small {
    color: #aaa !important;
}
.dark div[style*="background: white"] {
    background: #22223b !important;
}
.dark div[style*="background: white"] h3 {
    color: #ff8c42 !important;
}
.dark div[style*="background: white"] th {
    background: #1b5e2f;
}
.dark div[style*="background: white"] td {
    border-bottom-color: #3d3d5c;
    color: #eee;
}
</style>

@push('scripts')
<script>
    // Load paginated list of alats on page load
    const daftarAlat = @json($alats->items());

    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
        const contentEl = document.getElementById('tab-' + tab);
        if (contentEl) {
            contentEl.style.display = 'block';
        }
        
        const btn = Array.from(document.querySelectorAll('.tab-btn')).find(b => b.getAttribute('onclick').includes(tab));
        if (btn) {
            btn.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || 'alat';
        showTab(tab);
    });

    function openTambahModal() {
        const form = document.getElementById('formAlat');
        form.action = "{{ route('alat.store') }}";
        document.getElementById('methodFieldContainer').innerHTML = ''; // POST only
        document.getElementById('modalTitle').textContent = 'Tambah Alat Baru';
        
        document.getElementById('kodeAlat').value = '{{ $nextKode }}';
        document.getElementById('namaAlat').value = '';
        document.getElementById('kategoriAlat').value = '';
        document.getElementById('stokAlat').value = '0';
        document.getElementById('hargaAlat').value = '0';
        document.getElementById('tglMasuk').value = new Date().toISOString().split('T')[0];
        document.getElementById('fotoAlat').value = '';

        document.getElementById('modalAlat').style.display = 'flex';
    }

    function editAlat(id) {
        const alat = daftarAlat.find(a => a.id == id);
        if (!alat) {
            alert('Data tidak ditemukan!');
            return;
        }

        const form = document.getElementById('formAlat');
        form.action = "/alat/" + id;
        document.getElementById('methodFieldContainer').innerHTML = '@method("PUT")';
        document.getElementById('modalTitle').textContent = 'Edit Alat';
        
        document.getElementById('kodeAlat').value = alat.kode;
        document.getElementById('namaAlat').value = alat.nama;
        document.getElementById('kategoriAlat').value = alat.kategori;
        document.getElementById('stokAlat').value = alat.stok;
        document.getElementById('hargaAlat').value = Math.round(alat.harga);
        document.getElementById('tglMasuk').value = alat.tgl_masuk.split('T')[0];
        document.getElementById('fotoAlat').value = '';

        document.getElementById('modalAlat').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalAlat').style.display = 'none';
    }

    function hapusAlat(id) {
        if (confirm('Yakin ingin menghapus alat ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "/alat/" + id;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function hapusSewa(id) {
        if (confirm('Yakin ingin membatalkan transaksi penyewaan ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "/kelola-sewa/" + id;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function openTambahSewaModal() {
        const form = document.getElementById('formSewaAdmin');
        form.action = "/kelola-sewa"; 
        document.getElementById('methodFieldSewaContainer').innerHTML = '';
        document.getElementById('modalSewaTitle').textContent = 'Tambah Penyewaan Baru';
        
        document.getElementById('sewaNama').value = '';
        document.getElementById('sewaNoHp').value = '';
        document.getElementById('sewaAlatId').value = '';
        document.getElementById('sewaJumlah').value = '1';
        document.getElementById('sewaTglSewa').value = new Date().toISOString().split('T')[0];
        document.getElementById('sewaTglKembali').value = '';
        document.getElementById('sewaKeterangan').value = '';

        // Hide status fields on create
        const statusContainer = document.getElementById('adminSewaStatusContainer');
        if (statusContainer) {
            statusContainer.style.display = 'none';
            document.getElementById('sewaStatus').value = 'aktif';
            document.getElementById('sewaStatusPembayaran').value = 'Lunas';
        }

        document.getElementById('modalSewa').style.display = 'flex';
    }

    function editSewa(sewa) {
        const form = document.getElementById('formSewaAdmin');
        form.action = "/kelola-sewa/" + sewa.id;
        document.getElementById('methodFieldSewaContainer').innerHTML = '@method("PUT")';
        document.getElementById('modalSewaTitle').textContent = 'Edit Penyewaan';
        
        document.getElementById('sewaNama').value = sewa.nama;
        document.getElementById('sewaNoHp').value = sewa.noHp;
        document.getElementById('sewaAlatId').value = sewa.alat_id;
        document.getElementById('sewaJumlah').value = sewa.jumlah;
        document.getElementById('sewaTglSewa').value = sewa.tglSewa;
        document.getElementById('sewaTglKembali').value = sewa.tglKembali;
        document.getElementById('sewaKeterangan').value = sewa.keterangan || '';

        // Show and populate status fields on edit
        const statusContainer = document.getElementById('adminSewaStatusContainer');
        if (statusContainer) {
            statusContainer.style.display = 'block';
            document.getElementById('sewaStatus').value = sewa.status || 'aktif';
            document.getElementById('sewaStatusPembayaran').value = sewa.status_pembayaran || 'Belum Bayar';
        }

        document.getElementById('modalSewa').style.display = 'flex';
    }

    function closeSewaModal() {
        document.getElementById('modalSewa').style.display = 'none';
    }

    window.onclick = function(event) {
        const modalAlat = document.getElementById('modalAlat');
        const modalSewa = document.getElementById('modalSewa');
        if (event.target === modalAlat) {
            closeModal();
        } else if (event.target === modalSewa) {
            closeSewaModal();
        }
    }
</script>
@endpush
@endsection

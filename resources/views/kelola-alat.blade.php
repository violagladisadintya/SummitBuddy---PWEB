@extends('layouts.app')

@section('title', 'Kelola Alat & Penyewaan - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Admin Panel</h1>
        <p>Kelola Alat & Lihat Daftar Penyewaan</p>
    </div>
</header>
@endsection

@section('content')
<div class="tab-buttons">
    <button class="tab-btn active" onclick="showTab('alat')">📦 Kelola Alat</button>
    <button class="tab-btn" onclick="showTab('sewa')">📋 Daftar Penyewaan</button>
</div>

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
        <table id="alatTable">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="alatBody">
                @foreach($alats as $alat)
                <tr id="row-{{ $alat->id }}" style="{{ $alat->stok < 5 ? 'background-color:#fff3cd' : '' }}">
                    <td style="padding: 12px;">
                        @php
                            $manualFoto = [
                                'Tenda Dome' => 'tenda.jpg',
                                'Carrier 60L' => 'carrier.jpg',
                                'Carrier 80L' => 'carrier.jpg',
                                'Sleeping Bag' => 'sleepingbag.jpg',
                                'Kompor Portable' => 'kompor.jpg',
                                'Matras' => 'matras.jpg',
                                'Headlamp' => 'headlamp.jpg',
                            ];
                        @endphp

                        @if($alat->foto)
                            <img src="{{ asset('storage/' . $alat->foto) }}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
                        @elseif(isset($manualFoto[$alat->nama]))
                            <img src="{{ asset('image/' . $manualFoto[$alat->nama]) }}" width="50" height="50" style="object-fit:cover; border-radius:8px;" onerror="this.src='https://via.placeholder.com/50?text=No+Image'">
                        @else
                            <img src="https://via.placeholder.com/50?text=No+Image" width="50" height="50">
                        @endif
                    </td>
                    <td style="padding: 12px;">{{ $alat->kode }}</td>
                    <td style="padding: 12px;">{{ $alat->nama }}</td>
                    <td style="padding: 12px;">{{ $alat->kategori }}</td>
                    <td class="stok-{{ $alat->id }}" style="padding: 12px;">{{ $alat->stok }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($alat->harga, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">
                        <button class="btn-edit" onclick="editAlat({{ $alat->id }})">✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusAlat({{ $alat->id }})">🗑️ Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $alats->links() }}
</div>

<div id="tab-sewa" class="tab-content">
    <div class="table-container">
        <table id="sewaTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="sewaBody">
                @foreach($daftarSewa as $index => $sewa)
                <tr id="sewa-row-{{ $sewa['id'] }}">
                    <td style="padding: 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px;">{{ $sewa['nama'] }}</td>
                    <td style="padding: 12px;">{{ $sewa['noHp'] }}</td>
                    <td style="padding: 12px;">{{ $sewa['alat'] }}</td>
                    <td style="padding: 12px;">{{ $sewa['jumlah'] }}</td>
                    <td style="padding: 12px;">{{ $sewa['tglSewa'] }}</td>
                    <td style="padding: 12px;">{{ $sewa['tglKembali'] }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($sewa['totalHarga'], 0, ',', '.') }}</td>
                    <td style="padding: 12px;"><button class="btn-hapus" onclick="hapusSewa({{ $sewa['id'] }})">🗑️ Hapus</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT ALAT (UKURAN KECIL) -->
<div id="modalAlat" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 20px; width: 90%; max-width: 400px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalTitle" style="font-size: 18px; margin: 0;">Tambah Alat Baru</h3>
            <span onclick="closeModal()" style="font-size: 28px; cursor: pointer; color: #999; line-height: 1;">&times;</span>
        </div>

        <form id="formAlat" enctype="multipart/form-data">
            <input type="hidden" id="editId">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Kode Alat *</label>
            <input type="text" id="kodeAlat" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Nama Alat *</label>
            <input type="text" id="namaAlat" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Kategori *</label>
            <select id="kategoriAlat" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                <option value="">Pilih Kategori</option>
                <option value="Tenda">Tenda</option>
                <option value="Carrier">Carrier</option>
                <option value="Sleeping">Sleeping Bag</option>
                <option value="Kompor">Kompor</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Stok *</label>
            <input type="number" id="stokAlat" min="0" value="0" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Harga/Hari (Rp) *</label>
            <input type="number" id="hargaAlat" min="0" value="0" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Tanggal Masuk *</label>
            <input type="date" id="tglMasuk" required style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">

            <label style="display: block; margin: 10px 0 5px; font-weight: 600; font-size: 13px;">Foto</label>
            <input type="file" id="fotoAlat" accept="image/jpeg,image/png,image/jpg" style="width: 100%; padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            <small style="display: block; margin-top: 5px; font-size: 11px; color: #666;">Format: JPG, JPEG, PNG (Max 2MB)</small>

            <button type="button" onclick="simpanAlat()" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; font-weight: bold; margin-top: 15px; cursor: pointer; font-size: 14px;">Simpan Alat</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let daftarAlat = @json($alats);
    let daftarSewa = @json($daftarSewa);

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function getFotoUrl(alat) {
        const manualFoto = {
            'Tenda Dome': '/image/tenda.jpg',
            'Carrier 60L': '/image/carrier.jpg',
            'Carrier 80L': '/image/carrier.jpg',
            'Sleeping Bag': '/image/sleepingbag.jpg',
            'Kompor Portable': '/image/kompor.jpg',
            'Matras': '/image/matras.jpg',
            'Headlamp': '/image/headlamp.jpg',
        };

        if (alat.foto) {
            return '/storage/' + alat.foto;
        } else if (manualFoto[alat.nama]) {
            return manualFoto[alat.nama];
        } else {
            return 'https://via.placeholder.com/50?text=No+Image';
        }
    }

    function saveToLocalStorage() {
        localStorage.setItem('summitbuddy_alat', JSON.stringify(daftarAlat));
        localStorage.setItem('summitbuddy_sewa', JSON.stringify(daftarSewa));
    }

    function loadFromLocalStorage() {
        const alat = localStorage.getItem('summitbuddy_alat');
        const sewa = localStorage.getItem('summitbuddy_sewa');
        if (alat) daftarAlat = JSON.parse(alat);
        if (sewa) daftarSewa = JSON.parse(sewa);
    }

    function renderTabelAlat() {
        const tbody = document.getElementById('alatBody');
        if (!tbody) return;

        if (daftarAlat.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center">Tidak ada data alat</td></tr>';
        } else {
            tbody.innerHTML = daftarAlat.map(alat => `
                <tr id="row-${alat.id}" style="${alat.stok < 5 ? 'background-color:#fff3cd' : ''}">
                    <td style="padding:12px;">
                        <img src="${getFotoUrl(alat)}" width="50" height="50" style="object-fit:cover; border-radius:8px;" onerror="this.src='https://via.placeholder.com/50?text=No+Image'">
                    </td>
                    <td style="padding:12px;">${alat.kode}</td>
                    <td style="padding:12px;">${alat.nama}</td>
                    <td style="padding:12px;">${alat.kategori}</td>
                    <td class="stok-${alat.id}" style="padding:12px;">${alat.stok}</td>
                    <td style="padding:12px;">Rp ${alat.harga.toLocaleString('id-ID')}</td>
                    <td style="padding:12px;">
                        <button class="btn-edit" onclick="editAlat(${alat.id})">✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusAlat(${alat.id})">🗑️ Hapus</button>
                    </td>
                </tr>
            `).join('');
        }

        document.getElementById('statTotalAlat').innerHTML = daftarAlat.length;
        document.getElementById('statTotalStok').innerHTML = daftarAlat.reduce((sum, a) => sum + a.stok, 0);
        document.getElementById('statTotalNilai').innerHTML = formatRupiah(daftarAlat.reduce((sum, a) => sum + (a.stok * a.harga), 0));
        document.getElementById('statStokMenipis').innerHTML = daftarAlat.filter(a => a.stok < 5).length;
        document.getElementById('statTotalSewa').innerHTML = daftarSewa.length;
    }

    function renderTabelSewa() {
        const tbody = document.getElementById('sewaBody');
        if (!tbody) return;

        if (daftarSewa.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center">Belum ada penyewaan</td></tr>';
        } else {
            tbody.innerHTML = daftarSewa.map((sewa, i) => `
                <tr id="sewa-row-${sewa.id}">
                    <td style="padding:12px;">${i + 1}</td>
                    <td style="padding:12px;">${sewa.nama}</td>
                    <td style="padding:12px;">${sewa.noHp}</td>
                    <td style="padding:12px;">${sewa.alat}</td>
                    <td style="padding:12px;">${sewa.jumlah}</td>
                    <td style="padding:12px;">${sewa.tglSewa}</td>
                    <td style="padding:12px;">${sewa.tglKembali}</td>
                    <td style="padding:12px;">Rp ${sewa.totalHarga.toLocaleString('id-ID')}</td>
                    <td style="padding:12px;"><button class="btn-hapus" onclick="hapusSewa(${sewa.id})">🗑️ Hapus</button></td>
                </tr>
            `).join('');
        }
    }

    function openTambahModal() {
        document.getElementById('editId').value = '';
        document.getElementById('kodeAlat').value = '';
        document.getElementById('namaAlat').value = '';
        document.getElementById('kategoriAlat').value = '';
        document.getElementById('stokAlat').value = '0';
        document.getElementById('hargaAlat').value = '';
        document.getElementById('tglMasuk').value = new Date().toISOString().split('T')[0];
        document.getElementById('fotoAlat').value = '';
        document.getElementById('modalTitle').innerHTML = 'Tambah Alat Baru';
        document.getElementById('modalAlat').style.display = 'flex';
    }

    function editAlat(id) {
        const alat = daftarAlat.find(a => a.id == id);
        if (!alat) {
            alert('Data tidak ditemukan!');
            return;
        }

        document.getElementById('editId').value = alat.id;
        document.getElementById('kodeAlat').value = alat.kode;
        document.getElementById('namaAlat').value = alat.nama;
        document.getElementById('kategoriAlat').value = alat.kategori;
        document.getElementById('stokAlat').value = alat.stok;
        document.getElementById('hargaAlat').value = alat.harga;
        document.getElementById('tglMasuk').value = alat.tgl_masuk;
        document.getElementById('fotoAlat').value = '';
        document.getElementById('modalTitle').innerHTML = 'Edit Alat';
        document.getElementById('modalAlat').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalAlat').style.display = 'none';
    }

    function simpanAlat() {
        const editId = document.getElementById('editId').value;
        const kode = document.getElementById('kodeAlat').value.trim();
        const nama = document.getElementById('namaAlat').value.trim();
        const kategori = document.getElementById('kategoriAlat').value;
        const stok = parseInt(document.getElementById('stokAlat').value);
        const harga = parseInt(document.getElementById('hargaAlat').value);
        const tglMasuk = document.getElementById('tglMasuk').value;

        if (!kode || !nama || !kategori || !tglMasuk) {
            alert('Semua field wajib diisi!');
            return;
        }
        if (stok < 0 || harga < 0) {
            alert('Stok dan harga tidak boleh negatif!');
            return;
        }

        const kodeExists = daftarAlat.some(a => a.kode === kode && a.id != editId);
        if (kodeExists) {
            alert('Kode alat sudah digunakan!');
            return;
        }

        if (editId) {
            const index = daftarAlat.findIndex(a => a.id == editId);
            if (index !== -1) {
                daftarAlat[index] = {
                    ...daftarAlat[index],
                    kode, nama, kategori, stok, harga, tgl_masuk: tglMasuk
                };
                alert('✅ Alat berhasil diupdate!');
            }
        } else {
            const newId = Date.now();
            daftarAlat.push({
                id: newId, kode, nama, kategori, stok, harga, tgl_masuk: tglMasuk, foto: null
            });
            alert('✅ Alat berhasil ditambahkan!');
        }

        saveToLocalStorage();
        closeModal();
        renderTabelAlat();
    }

    function hapusAlat(id) {
        const alat = daftarAlat.find(a => a.id == id);
        if (confirm(`Hapus alat "${alat?.nama}" (${alat?.kode})?`)) {
            daftarAlat = daftarAlat.filter(a => a.id != id);
            saveToLocalStorage();
            renderTabelAlat();
            alert('✅ Alat berhasil dihapus!');
        }
    }

    function hapusSewa(id) {
        const sewa = daftarSewa.find(s => s.id == id);
        if (confirm(`Hapus penyewaan atas nama "${sewa?.nama}"?`)) {
            daftarSewa = daftarSewa.filter(s => s.id != id);
            saveToLocalStorage();
            renderTabelSewa();
            renderTabelAlat();
            alert('✅ Penyewaan berhasil dihapus!');
        }
    }

    function showTab(tab) {
        const tabAlat = document.getElementById('tab-alat');
        const tabSewa = document.getElementById('tab-sewa');
        const btns = document.querySelectorAll('.tab-btn');

        if (tab === 'alat') {
            tabAlat.classList.add('active');
            tabSewa.classList.remove('active');
            btns[0].classList.add('active');
            btns[1].classList.remove('active');
            renderTabelAlat();
        } else {
            tabAlat.classList.remove('active');
            tabSewa.classList.add('active');
            btns[0].classList.remove('active');
            btns[1].classList.add('active');
            renderTabelSewa();
        }
    }

    renderTabelAlat();
    renderTabelSewa();

    window.onclick = function(event) {
        const modal = document.getElementById('modalAlat');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endpush
@endsection

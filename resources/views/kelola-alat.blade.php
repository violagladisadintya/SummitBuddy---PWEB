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
        <div class="stat-card"><h4>📦 Total Alat</h4><div class="angka" id="statTotalAlat">{{ $statistik['totalAlat'] }}</div></div>
        <div class="stat-card"><h4>📦 Total Stok</h4><div class="angka" id="statTotalStok">{{ $statistik['totalStok'] }}</div></div>
        <div class="stat-card"><h4>💰 Total Nilai</h4><div class="angka" id="statTotalNilai">Rp {{ number_format($statistik['totalNilai'], 0, ',', '.') }}</div></div>
        <div class="stat-card"><h4>⚠️ Stok Menipis</h4><div class="angka" id="statStokMenipis">{{ $statistik['stokMenipis'] }}</div></div>
        <div class="stat-card"><h4>📋 Total Sewa</h4><div class="angka" id="statTotalSewa">{{ $statistik['totalSewa'] }}</div></div>
    </div>

    <button class="btn-tambah" onclick="openTambahModal()">+ Tambah Alat Baru</button>

    <div class="table-container">
        <table id="alatTable">
            <thead>
                <tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Harga</th><th>Aksi</th></tr>
            </thead>
            <tbody id="alatBody">
                @foreach($daftarAlat as $alat)
                <tr id="row-{{ $alat['id'] }}" style="{{ $alat['stok'] < 5 ? 'background-color:#fff3cd' : '' }}">
                    <td>{{ $alat['kode'] }}</td>
                    <td>{{ $alat['nama'] }}</td>
                    <td>{{ $alat['kategori'] }}</td>
                    <td class="stok-{{ $alat['id'] }}">{{ $alat['stok'] }}</td>
                    <td>Rp {{ number_format($alat['harga'], 0, ',', '.') }}</td>
                    <td>
                        <button class="btn-edit" onclick="editAlat({{ $alat['id'] }})">✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusAlat({{ $alat['id'] }})">🗑️ Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="tab-sewa" class="tab-content">
    <div class="table-container">
        <table id="sewaTable">
            <thead>
                <tr><th>No</th><th>Nama</th><th>No HP</th><th>Alat</th><th>Jumlah</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Aksi</th></tr>
            </thead>
            <tbody id="sewaBody">
                @foreach($daftarSewa as $index => $sewa)
                <tr id="sewa-row-{{ $sewa['id'] }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sewa['nama'] }}</td>
                    <td>{{ $sewa['noHp'] }}</td>
                    <td>{{ $sewa['alat'] }}</td>
                    <td>{{ $sewa['jumlah'] }}</td>
                    <td>{{ $sewa['tglSewa'] }}</td>
                    <td>{{ $sewa['tglKembali'] }}</td>
                    <td>Rp {{ number_format($sewa['totalHarga'], 0, ',', '.') }}</td>
                    <td><button class="btn-hapus" onclick="hapusSewa({{ $sewa['id'] }})">🗑️ Hapus</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalAlat" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 500px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 id="modalTitle">Tambah Alat Baru</h3>
            <span onclick="closeModal()" style="font-size: 28px; cursor: pointer; color: #999;">&times;</span>
        </div>
        <form id="formAlat" onsubmit="return false;">
            <input type="hidden" id="editId">
            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Kode Alat *</label>
            <input type="text" id="kodeAlat" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">

            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Nama Alat *</label>
            <input type="text" id="namaAlat" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">

            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Kategori *</label>
            <select id="kategoriAlat" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">
                <option value="">Pilih Kategori</option>
                <option value="Tenda">Tenda</option>
                <option value="Carrier">Carrier</option>
                <option value="Sleeping">Sleeping Bag</option>
                <option value="Kompor">Kompor</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>

            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Stok *</label>
            <input type="number" id="stokAlat" min="0" value="0" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">

            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Harga/Hari (Rp) *</label>
            <input type="number" id="hargaAlat" min="0" value="0" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">

            <label style="display: block; margin: 15px 0 5px; font-weight: 600;">Tanggal Masuk *</label>
            <input type="date" id="tglMasuk" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px;">

            <button type="button" onclick="simpanAlat()" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; font-weight: bold; margin-top: 20px; cursor: pointer;">Simpan Alat</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let daftarAlat = @json($daftarAlat);
    let daftarSewa = @json($daftarSewa);

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
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
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">Tidak ada data alat</td></tr>';
        } else {
            tbody.innerHTML = daftarAlat.map(alat => `
                <tr id="row-${alat.id}" style="${alat.stok < 5 ? 'background-color:#fff3cd' : ''}">
                    <td>${alat.kode}</td>
                    <td>${alat.nama}</td>
                    <td>${alat.kategori}</td>
                    <td class="stok-${alat.id}">${alat.stok}</td>
                    <td>Rp ${alat.harga.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn-edit" onclick="editAlat(${alat.id})">✏️ Edit</button>
                        <button class="btn-hapus" onclick="hapusAlat(${alat.id})">🗑️ Hapus</button>
                    </td>
                </tr>
            `).join('');
        }

        const totalAlat = daftarAlat.length;
        const totalStok = daftarAlat.reduce((sum, a) => sum + a.stok, 0);
        const totalNilai = daftarAlat.reduce((sum, a) => sum + (a.stok * a.harga), 0);
        const stokMenipis = daftarAlat.filter(a => a.stok < 5).length;
        const totalSewa = daftarSewa.length;

        document.getElementById('statTotalAlat').innerHTML = totalAlat;
        document.getElementById('statTotalStok').innerHTML = totalStok;
        document.getElementById('statTotalNilai').innerHTML = formatRupiah(totalNilai);
        document.getElementById('statStokMenipis').innerHTML = stokMenipis;
        document.getElementById('statTotalSewa').innerHTML = totalSewa;
    }

    function renderTabelSewa() {
        const tbody = document.getElementById('sewaBody');
        if (!tbody) return;

        if (daftarSewa.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center">Belum ada penyewaan</td></tr>';
        } else {
            tbody.innerHTML = daftarSewa.map((sewa, i) => `
                <tr id="sewa-row-${sewa.id}">
                    <td>${i + 1}</td>
                    <td>${sewa.nama}</td>
                    <td>${sewa.noHp}</td>
                    <td>${sewa.alat}</td>
                    <td>${sewa.jumlah}</td>
                    <td>${sewa.tglSewa}</td>
                    <td>${sewa.tglKembali}</td>
                    <td>Rp ${sewa.totalHarga.toLocaleString('id-ID')}</td>
                    <td><button class="btn-hapus" onclick="hapusSewa(${sewa.id})">🗑️ Hapus</button></td>
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
        document.getElementById('modalTitle').innerHTML = 'Tambah Alat Baru';
        document.getElementById('modalAlat').style.display = 'flex';
    }

    function editAlat(id) {
        const alat = daftarAlat.find(a => a.id === id);
        if (!alat) return;

        document.getElementById('editId').value = alat.id;
        document.getElementById('kodeAlat').value = alat.kode;
        document.getElementById('namaAlat').value = alat.nama;
        document.getElementById('kategoriAlat').value = alat.kategori;
        document.getElementById('stokAlat').value = alat.stok;
        document.getElementById('hargaAlat').value = alat.harga;
        document.getElementById('tglMasuk').value = alat.tglMasuk;
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
                    kode, nama, kategori, stok, harga, tglMasuk
                };
                alert('✅ Alat berhasil diupdate!');
            }
        } else {
            const newId = Date.now();
            daftarAlat.push({
                id: newId, kode, nama, kategori, stok, harga, tglMasuk
            });
            alert('✅ Alat berhasil ditambahkan!');
        }

        saveToLocalStorage();
        closeModal();
        renderTabelAlat();
    }

    function hapusAlat(id) {
        const alat = daftarAlat.find(a => a.id === id);
        if (confirm(`Hapus alat "${alat?.nama}" (${alat?.kode})?`)) {
            daftarAlat = daftarAlat.filter(a => a.id !== id);
            saveToLocalStorage();
            renderTabelAlat();
            alert('✅ Alat berhasil dihapus!');
        }
    }

    function hapusSewa(id) {
        const sewa = daftarSewa.find(s => s.id === id);
        if (confirm(`Hapus penyewaan atas nama "${sewa?.nama}"?`)) {
            daftarSewa = daftarSewa.filter(s => s.id !== id);
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

    loadFromLocalStorage();
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

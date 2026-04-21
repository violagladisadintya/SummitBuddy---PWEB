let daftarAlat = [
    { id: 1, kode: "A001", nama: "Tenda Dome", kategori: "Tenda", stok: 10, harga: 100000, tglMasuk: "2024-01-15" },
    { id: 2, kode: "A002", nama: "Carrier 60L", kategori: "Carrier", stok: 8, harga: 80000, tglMasuk: "2024-01-20" },
    { id: 3, kode: "A003", nama: "Sleeping Bag", kategori: "Sleeping", stok: 7, harga: 50000, tglMasuk: "2024-02-10" },
    { id: 4, kode: "A004", nama: "Kompor Portable", kategori: "Kompor", stok: 5, harga: 40000, tglMasuk: "2024-02-15" },
    { id: 5, kode: "A005", nama: "Matras", kategori: "Aksesoris", stok: 3, harga: 30000, tglMasuk: "2024-03-01" },
    { id: 6, kode: "A006", nama: "Headlamp", kategori: "Aksesoris", stok: 12, harga: 25000, tglMasuk: "2024-03-10" },
    { id: 7, kode: "A007", nama: "Carrier 80L", kategori: "Carrier", stok: 4, harga: 100000, tglMasuk: "2024-03-15" },
    { id: 8, kode: "A008", nama: "Tenda 4 Season", kategori: "Tenda", stok: 2, harga: 150000, tglMasuk: "2024-04-01" }
];

let daftarSewa = [
    { id: 101, nama: "Andi Pratama", noHp: "08123456789", alat: "Tenda", jumlah: 2, tglSewa: "2024-12-10", tglKembali: "2024-12-12", totalHarga: 200000 },
    { id: 102, nama: "Sari Dewi", noHp: "08198765432", alat: "Carrier", jumlah: 1, tglSewa: "2024-12-15", tglKembali: "2024-12-17", totalHarga: 160000 },
    { id: 103, nama: "Budi Santoso", noHp: "08155555555", alat: "Sleeping Bag", jumlah: 3, tglSewa: "2024-12-20", tglKembali: "2024-12-22", totalHarga: 150000 },
    { id: 104, nama: "Rina Wahyuni", noHp: "08144444444", alat: "Kompor", jumlah: 1, tglSewa: "2024-12-25", tglKembali: "2024-12-26", totalHarga: 40000 }
];

function loadData() {
    const alat = localStorage.getItem('summitbuddy_alat');
    const sewa = localStorage.getItem('summitbuddy_sewa');
    if (alat) daftarAlat = JSON.parse(alat);
    if (sewa) daftarSewa = JSON.parse(sewa);
    if (!localStorage.getItem('summitbuddy_alat')) localStorage.setItem('summitbuddy_alat', JSON.stringify(daftarAlat));
    if (!localStorage.getItem('summitbuddy_sewa')) localStorage.setItem('summitbuddy_sewa', JSON.stringify(daftarSewa));
}

function saveAlat() { localStorage.setItem('summitbuddy_alat', JSON.stringify(daftarAlat)); }
function saveSewa() { localStorage.setItem('summitbuddy_sewa', JSON.stringify(daftarSewa)); }

function formatRupiah(angka) { return 'Rp ' + angka.toLocaleString('id-ID'); }

function renderTabelAlat() {
    const keyword = document.getElementById('searchAlat')?.value.toLowerCase() || '';
    const kategori = document.getElementById('filterKategori')?.value || '';
    let filtered = daftarAlat.filter(alat => {
        const matchSearch = keyword === '' || alat.kode.toLowerCase().includes(keyword) || alat.nama.toLowerCase().includes(keyword);
        const matchKategori = kategori === '' || alat.kategori === kategori;
        return matchSearch && matchKategori;
    });
    const tbody = document.getElementById('alatBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>';
    } else {
        tbody.innerHTML = filtered.map(alat => `
            <tr class="${alat.stok < 5 ? 'stok-menipis' : ''}">
                <td>${alat.kode}</td>
                <td>${alat.nama}</td>
                <td>${alat.kategori}</td>
                <td>${alat.stok}</td>
                <td>${formatRupiah(alat.harga)}</td>
                <td>
                    <button class="btn-edit" onclick="editAlat(${alat.id})">✏️ Edit</button>
                    <button class="btn-hapus" onclick="hapusAlat(${alat.id})">🗑️ Hapus</button>
                </td>
            </tr>
        `).join('');
    }
    const totalItem = daftarAlat.reduce((s, a) => s + a.stok, 0);
    const totalNilai = daftarAlat.reduce((s, a) => s + (a.stok * a.harga), 0);
    const stokMenipis = daftarAlat.filter(a => a.stok < 5).length;
    document.getElementById('statTotalAlat').innerHTML = totalItem;
    document.getElementById('statTotalNilai').innerHTML = formatRupiah(totalNilai);
    document.getElementById('statStokMenipis').innerHTML = stokMenipis;
    document.getElementById('statTotalSewa').innerHTML = daftarSewa.length;
}

function renderTabelSewa() {
    const keyword = document.getElementById('searchSewa')?.value.toLowerCase() || '';
    let filtered = daftarSewa.filter(sewa => keyword === '' || sewa.nama.toLowerCase().includes(keyword));
    const tbody = document.getElementById('sewaBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center">Belum ada penyewaan</td></tr>';
    } else {
        tbody.innerHTML = filtered.map((sewa, i) => `
            <tr>
                <td>${i+1}</td>
                <td>${sewa.nama}</td>
                <td>${sewa.noHp}</td>
                <td>${sewa.alat}</td>
                <td>${sewa.jumlah}</td>
                <td>${sewa.tglSewa}</td>
                <td>${sewa.tglKembali}</td>
                <td>${formatRupiah(sewa.totalHarga)}</td>
                <td><button class="btn-hapus-sewa" onclick="hapusSewa(${sewa.id})">🗑️ Hapus</button></td>
            </tr>
        `).join('');
    }
    document.getElementById('statTotalSewa').innerHTML = daftarSewa.length;
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
    document.getElementById('modalAlat').classList.add('active');
}

function openTambahModal() {
    document.getElementById('editId').value = '';
    document.getElementById('kodeAlat').value = '';
    document.getElementById('namaAlat').value = '';
    document.getElementById('kategoriAlat').value = '';
    document.getElementById('stokAlat').value = '0';
    document.getElementById('hargaAlat').value = '';
    document.getElementById('tglMasuk').value = '';
    document.getElementById('modalTitle').innerHTML = 'Tambah Alat Baru';
    document.getElementById('modalAlat').classList.add('active');
}

function closeModal() { document.getElementById('modalAlat').classList.remove('active'); }

function simpanAlat() {
    const editId = document.getElementById('editId').value;
    const kode = document.getElementById('kodeAlat').value.trim();
    const nama = document.getElementById('namaAlat').value.trim();
    const kategori = document.getElementById('kategoriAlat').value;
    const stok = parseInt(document.getElementById('stokAlat').value);
    const harga = parseInt(document.getElementById('hargaAlat').value);
    const tglMasuk = document.getElementById('tglMasuk').value;
    if (!kode || !nama || !kategori || !tglMasuk) { alert('Semua field wajib diisi!'); return; }
    if (stok < 0 || harga < 0) { alert('Stok dan harga tidak boleh negatif!'); return; }
    const kodeExists = daftarAlat.some(a => a.kode === kode && a.id != editId);
    if (kodeExists) { alert('Kode alat sudah digunakan!'); return; }
    if (editId) {
        const index = daftarAlat.findIndex(a => a.id == editId);
        if (index !== -1) { daftarAlat[index] = { ...daftarAlat[index], kode, nama, kategori, stok, harga, tglMasuk }; saveAlat(); alert('✅ Alat berhasil diupdate!'); }
    } else {
        const newId = Date.now();
        daftarAlat.push({ id: newId, kode, nama, kategori, stok, harga, tglMasuk });
        saveAlat();
        alert('✅ Alat berhasil ditambahkan!');
    }
    closeModal();
    renderTabelAlat();
}

function hapusAlat(id) {
    const alat = daftarAlat.find(a => a.id === id);
    if (confirm(`Hapus alat "${alat?.nama}" (${alat?.kode})?`)) {
        daftarAlat = daftarAlat.filter(a => a.id !== id);
        saveAlat();
        renderTabelAlat();
        alert('✅ Alat berhasil dihapus!');
    }
}

function hapusSewa(id) {
    const sewa = daftarSewa.find(s => s.id === id);
    if (confirm(`Hapus penyewaan atas nama "${sewa?.nama}"?`)) {
        daftarSewa = daftarSewa.filter(s => s.id !== id);
        saveSewa();
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

loadData();
renderTabelAlat();
renderTabelSewa();

document.getElementById('searchAlat')?.addEventListener('keyup', (e) => { if (e.key === 'Enter') renderTabelAlat(); });
document.getElementById('searchSewa')?.addEventListener('keyup', (e) => { if (e.key === 'Enter') renderTabelSewa(); });
document.getElementById('filterKategori')?.addEventListener('change', () => renderTabelAlat());
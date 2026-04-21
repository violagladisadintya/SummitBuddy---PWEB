const hargaAlat = {
    "Tenda": 100000,
    "Carrier": 80000,
    "Sleeping Bag": 50000,
    "Kompor": 40000,
    "Matras": 30000
};

function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

function hitungTotalHarga(alat, jumlah, tglSewa, tglKembali) {
    if (!alat || !jumlah || !tglSewa || !tglKembali) return 0;
    let hargaPerHari = hargaAlat[alat] || 0;
    let date1 = new Date(tglSewa);
    let date2 = new Date(tglKembali);
    if (date2 <= date1) return 0;
    let selisihHari = Math.ceil((date2 - date1) / (1000 * 60 * 60 * 24));
    return jumlah * hargaPerHari * selisihHari;
}

function simpanPenyewaan(data) {
    let daftarSewa = JSON.parse(localStorage.getItem('summitbuddy_sewa')) || [];
    daftarSewa.push(data);
    localStorage.setItem('summitbuddy_sewa', JSON.stringify(daftarSewa));
    return true;
}

function loadDataAlat() {
    const data = localStorage.getItem('summitbuddy_alat');
    if (data) {
        return JSON.parse(data);
    } else {
        const dataAwal = [
            { id: 1, kode: "A001", nama: "Tenda Dome", kategori: "Tenda", stok: 10, harga: 100000, foto: "Tenda.jpg" },
            { id: 2, kode: "A002", nama: "Carrier 60L", kategori: "Carrier", stok: 8, harga: 80000, foto: "Carrier Bag 60L.jpg" },
            { id: 3, kode: "A003", nama: "Sleeping Bag", kategori: "Sleeping", stok: 7, harga: 50000, foto: "SleepingBag.jpg" },
            { id: 4, kode: "A004", nama: "Kompor Portable", kategori: "Kompor", stok: 5, harga: 40000, foto: "Komporjog" },
            { id: 5, kode: "A005", nama: "Matras", kategori: "Aksesoris", stok: 3, harga: 30000, foto: "Matras.jpg" }
        ];
        localStorage.setItem('summitbuddy_alat', JSON.stringify(dataAwal));
        return dataAwal;
    }
}

function renderTabelAlat() {
    const tbody = document.getElementById('alatBody');
    if (!tbody) return;
    
    let daftarAlat = loadDataAlat();
    const searchKeyword = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const checkboxes = document.querySelectorAll('.filter-cb');
    const selectedCategories = [];
    checkboxes.forEach(cb => { if (cb.checked) selectedCategories.push(cb.value); });
    
    let dataFiltered = daftarAlat.filter(alat => {
        const matchSearch = searchKeyword === '' || alat.kode.toLowerCase().includes(searchKeyword) || alat.nama.toLowerCase().includes(searchKeyword);
        const matchKategori = selectedCategories.length === 0 || selectedCategories.includes(alat.kategori);
        return matchSearch && matchKategori;
    });
    
    if (dataFiltered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">Tidak ada data alat</td></tr>';
    } else {
        tbody.innerHTML = dataFiltered.map(alat => `
            <tr>
                <td>${alat.kode}</td>
                <td>${alat.nama}</td>
                <td><img src="${alat.foto}" alt="${alat.nama}" style="width:50px; height:50px; object-fit:cover;"></td>
                <td>${alat.kategori}</td>
                <td>${alat.stok}</td>
                <td>${formatRupiah(alat.harga)}</td>
            </tr>
        `).join('');
    }
    
    const totalItem = daftarAlat.reduce((sum, alat) => sum + alat.stok, 0);
    if (document.getElementById('statTotalAlatData')) {
        document.getElementById('statTotalAlatData').textContent = totalItem;
        document.getElementById('statTersediaData').textContent = totalItem;
        document.getElementById('statDipinjamData').textContent = 0;
    }
}

function updateTotalHargaForm() {
    let alatSelect = document.getElementById('alat');
    let jumlah = parseInt(document.getElementById('jumlah')?.value) || 0;
    let tglSewa = document.getElementById('tglSewa')?.value || '';
    let tglKembali = document.getElementById('tglKembali')?.value || '';
    let alat = alatSelect ? alatSelect.options[alatSelect.selectedIndex]?.text.split(' - ')[0] : '';
    let total = hitungTotalHarga(alat, jumlah, tglSewa, tglKembali);
    let totalDiv = document.getElementById('totalHarga');
    if (totalDiv) totalDiv.innerHTML = total > 0 ? `💰 Total: ${formatRupiah(total)}` : `💰 Total: Rp 0`;
}

function validasiFormSewa() {
    let nama = document.getElementById('nama')?.value.trim() || '';
    let noHp = document.getElementById('noHp')?.value.trim() || '';
    let jumlah = document.getElementById('jumlah')?.value || 0;
    let ktp = document.getElementById('ktp')?.value || '';
    let tglSewa = document.getElementById('tglSewa')?.value || '';
    let tglKembali = document.getElementById('tglKembali')?.value || '';
    let errors = [];
    if (!nama) errors.push('Nama penyewa wajib diisi');
    if (!noHp) errors.push('Nomor HP wajib diisi');
    if (noHp.length < 10) errors.push('Nomor HP minimal 10 digit');
    if (!jumlah || jumlah <= 0) errors.push('Jumlah alat minimal 1');
    if (!ktp) errors.push('Upload KTP wajib dilampirkan');
    if (!tglSewa) errors.push('Tanggal sewa wajib diisi');
    if (!tglKembali) errors.push('Tanggal kembali wajib diisi');
    if (tglSewa && tglKembali) {
        let date1 = new Date(tglSewa);
        let date2 = new Date(tglKembali);
        if (date2 <= date1) errors.push('Tanggal kembali harus setelah tanggal sewa');
    }
    return errors;
}

function tampilkanNotifikasi(pesan, jenis = 'success') {
    let notif = document.createElement('div');
    notif.textContent = pesan;
    notif.style.cssText = `position: fixed; bottom: 20px; right: 20px; padding: 12px 24px; border-radius: 8px; color: white; z-index: 9999; background-color: ${jenis === 'success' ? '#43a047' : '#e53935'}; animation: slideIn 0.4s ease forwards;`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
}

function setupFormSewa() {
    let form = document.getElementById('sewaForm');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let errors = validasiFormSewa();
        if (errors.length > 0) { tampilkanNotifikasi(errors[0], 'error'); return; }
        let alatSelect = document.getElementById('alat');
        let alat = alatSelect.options[alatSelect.selectedIndex]?.text.split(' - ')[0];
        let tglSewa = document.getElementById('tglSewa').value;
        let tglKembali = document.getElementById('tglKembali').value;
        let jumlah = parseInt(document.getElementById('jumlah').value);
        let total = hitungTotalHarga(alat, jumlah, tglSewa, tglKembali);
        let dataSewa = { id: Date.now(), nama: document.getElementById('nama').value.trim(), noHp: document.getElementById('noHp').value.trim(), alat: alat, jumlah: jumlah, tglSewa: tglSewa, tglKembali: tglKembali, totalHarga: total, keterangan: document.getElementById('keterangan').value };
        simpanPenyewaan(dataSewa);
        alert(`✅ Penyewaan Berhasil!\n\nNama: ${dataSewa.nama}\nAlat: ${dataSewa.alat}\nJumlah: ${dataSewa.jumlah}\nTotal: ${formatRupiah(total)}\n\nTerima kasih telah menyewa di SummitBuddy!`);
        form.reset();
        document.getElementById('jumlah').value = '1';
        updateTotalHargaForm();
        tampilkanNotifikasi('Data penyewaan berhasil disimpan!', 'success');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (!document.querySelector('#summitbuddy-styles')) {
        let style = document.createElement('style');
        style.id = 'summitbuddy-styles';
        style.textContent = `@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }`;
        document.head.appendChild(style);
    }
    if (document.getElementById('sewaForm')) {
        setupFormSewa();
        ['alat', 'jumlah', 'tglSewa', 'tglKembali'].forEach(id => {
            let el = document.getElementById(id);
            if (el) el.addEventListener('input', updateTotalHargaForm);
        });
        updateTotalHargaForm();
    }
    if (document.getElementById('alatTable')) {
        renderTabelAlat();
        document.querySelectorAll('.filter-cb').forEach(cb => cb.addEventListener('change', renderTabelAlat));
        document.getElementById('searchBtn')?.addEventListener('click', renderTabelAlat);
        document.getElementById('searchInput')?.addEventListener('keyup', e => { if (e.key === 'Enter') renderTabelAlat(); });
    }
});
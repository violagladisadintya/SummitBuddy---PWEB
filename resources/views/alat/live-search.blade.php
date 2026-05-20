@extends('layouts.app')

@section('title', 'Cari Alat - SummitBuddy')

@section('content')
<div class="container">
    <h2>Cari Alat Pendakian</h2>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari alat..." class="form-control">
        <div id="loadingIndicator" style="display: none;">Loading...</div>
    </div>

    <div class="result-header">
        <span id="resultCount"></span>
        <button id="addBtn" class="btn btn-primary">Tambah Alat</button>
    </div>

    <div id="resultsContainer">
        <table class="table">
            <thead>
                <tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Harga</th></tr>
            </thead>
            <tbody id="tableBody">
                <tr><td colspan="5">Ketik kata kunci untuk mencari...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Alat Baru</h3>
            <span onclick="closeModal()" class="close">&times;</span>
        </div>
        <form id="addForm">
            @csrf
            <div class="form-group"><label>Kode</label><input type="text" id="kode" required></div>
            <div class="form-group"><label>Nama</label><input type="text" id="nama" required></div>
            <div class="form-group">
                <label>Kategori</label>
                <select id="kategori">
                    <option value="Tenda">Tenda</option>
                    <option value="Carrier">Carrier</option>
                    <option value="Sleeping">Sleeping Bag</option>
                    <option value="Kompor">Kompor</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
            </div>
            <div class="form-group"><label>Stok</label><input type="number" id="stok" value="0"></div>
            <div class="form-group"><label>Harga</label><input type="number" id="harga"></div>
            <div class="form-group"><label>Tanggal Masuk</label><input type="date" id="tgl_masuk"></div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()">Batal</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}
.modal-content {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    padding: 20px;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.close {
    font-size: 28px;
    cursor: pointer;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-group input, .form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}
.btn-primary {
    background: #1b5e2f;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    cursor: pointer;
}
.search-box {
    margin-bottom: 20px;
}
.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}
.table th {
    background: #1b5e2f;
    color: white;
}
.result-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}
</style>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let debounceTimer;
let currentKeyword = '';

async function searchAlat() {
    const loading = document.getElementById('loadingIndicator');
    const tbody = document.getElementById('tableBody');
    const resultCount = document.getElementById('resultCount');

    loading.style.display = 'block';

    try {
        const url = currentKeyword ? `/api/alats/search?q=${encodeURIComponent(currentKeyword)}` : '/api/alats/search';
        const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const result = await response.json();

        if (result.success && result.data.length > 0) {
            tbody.innerHTML = result.data.map(alat => `
                <tr>
                    <td>${alat.kode}</td>
                    <td>${alat.nama}</td>
                    <td>${alat.kategori}</td>
                    <td>${alat.stok}</td>
                    <td>Rp ${parseInt(alat.harga).toLocaleString()}</td>
                </tr>
            `).join('');
            resultCount.innerHTML = `Menampilkan ${result.data.length} dari ${result.total} alat`;
        } else {
            tbody.innerHTML = '<tr><td colspan="5">Tidak ada数据</td></tr>';
            resultCount.innerHTML = 'Tidak ada hasil';
        }
    } catch (error) {
        tbody.innerHTML = '<tr><td colspan="5">Error memuat data</td></tr>';
    } finally {
        loading.style.display = 'none';
    }
}

function openModal() {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('addForm').reset();
}

document.getElementById('searchInput').addEventListener('input', function() {
    currentKeyword = this.value.trim();
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(searchAlat, 400);
});

document.getElementById('addBtn').addEventListener('click', openModal);

document.getElementById('addForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('kode', document.getElementById('kode').value);
    formData.append('nama', document.getElementById('nama').value);
    formData.append('kategori', document.getElementById('kategori').value);
    formData.append('stok', document.getElementById('stok').value);
    formData.append('harga', document.getElementById('harga').value);
    formData.append('tgl_masuk', document.getElementById('tgl_masuk').value || new Date().toISOString().split('T')[0]);
    formData.append('_token', CSRF);

    const response = await fetch('/api/alats', {
        method: 'POST',
        body: formData,
        headers: { 'Accept': 'application/json' }
    });
    const result = await response.json();

    if (result.success) {
        alert(result.message);
        closeModal();
        searchAlat();
    } else {
        alert('Gagal menyimpan');
    }
});

searchAlat();
</script>
@endsection

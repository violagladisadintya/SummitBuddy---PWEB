@extends('layouts.app')

@section('title', 'Data Alat Pendakian - SummitBuddy')

@section('hero')
<div class="hero-small">
    <h1>Data Alat Pendakian</h1>
    <p>Lengkapi persiapan pendakianmu dengan alat terbaik</p>
</div>
@endsection

@section('content')
<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <aside style="flex: 1; min-width: 220px;">
        <h3>Filter Kategori</h3>
        <div class="filter-group">
            <label><input type="checkbox" value="Tenda" class="filter-cb"> 🏕️ Tenda</label>
            <label><input type="checkbox" value="Carrier" class="filter-cb"> 🎒 Carrier</label>
            <label><input type="checkbox" value="Sleeping" class="filter-cb"> 🛌 Sleeping Bag</label>
            <label><input type="checkbox" value="Kompor" class="filter-cb"> 🔥 Kompor</label>
            <label><input type="checkbox" value="Aksesoris" class="filter-cb"> 🔦 Aksesoris</label>
        </div>
        <h3>📊 Statistik</h3>
        <div class="stat-item"><span>Total Alat</span><span class="stat-value">51</span></div>
        <div class="stat-item"><span>Tersedia</span><span class="stat-value">51</span></div>
        <div class="stat-item"><span>Dipinjam</span><span class="stat-value">0</span></div>
    </aside>

    <section style="flex: 3;">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari alat...">
            <button id="searchBtn">🔍 Cari</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th>Foto</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Sewa/Hari</th>
                    </tr>
                </thead>
                <tbody id="alatBody">
                    @php
                    $daftarAlat = [
                        ['kode' => 'A001', 'nama' => 'Tenda Dome', 'kategori' => 'Tenda', 'stok' => 10, 'harga' => 100000],
                        ['kode' => 'A002', 'nama' => 'Carrier 60L', 'kategori' => 'Carrier', 'stok' => 8, 'harga' => 80000],
                        ['kode' => 'A003', 'nama' => 'Sleeping Bag', 'kategori' => 'Sleeping', 'stok' => 7, 'harga' => 50000],
                        ['kode' => 'A004', 'nama' => 'Kompor Portable', 'kategori' => 'Kompor', 'stok' => 5, 'harga' => 40000],
                        ['kode' => 'A005', 'nama' => 'Matras', 'kategori' => 'Aksesoris', 'stok' => 3, 'harga' => 30000],
                        ['kode' => 'A006', 'nama' => 'Headlamp', 'kategori' => 'Aksesoris', 'stok' => 12, 'harga' => 25000],
                        ['kode' => 'A007', 'nama' => 'Carrier 80L', 'kategori' => 'Carrier', 'stok' => 4, 'harga' => 100000],
                        ['kode' => 'A008', 'nama' => 'Tenda 4 Season', 'kategori' => 'Tenda', 'stok' => 2, 'harga' => 150000],
                    ];
                    @endphp
                    @foreach($daftarAlat as $alat)
                    <tr data-kategori="{{ $alat['kategori'] }}">
                        <td>{{ $alat['kode'] }}</td>
                        <td>{{ $alat['nama'] }}</td>
                        <td><img src="https://via.placeholder.com/50?text=Alat" width="50" height="50" style="object-fit:cover; border-radius:8px;"></td>
                        <td>{{ $alat['kategori'] }}</td>
                        <td>{{ $alat['stok'] }}</td>
                        <td>Rp {{ number_format($alat['harga'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

@push('scripts')
<script>
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const checkboxes = document.querySelectorAll('.filter-cb:checked');
        const selectedCategories = Array.from(checkboxes).map(cb => cb.value);
        const rows = document.querySelectorAll('#alatBody tr');

        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() || '';
            const kategori = row.getAttribute('data-kategori') || '';
            const matchSearch = search === '' || nama.includes(search);
            const matchKategori = selectedCategories.length === 0 || selectedCategories.includes(kategori);
            row.style.display = matchSearch && matchKategori ? '' : 'none';
        });
    }

    document.getElementById('searchBtn')?.addEventListener('click', filterTable);
    document.getElementById('searchInput')?.addEventListener('keyup', (e) => { if(e.key === 'Enter') filterTable(); });
    document.querySelectorAll('.filter-cb').forEach(cb => cb.addEventListener('change', filterTable));
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'Data Alat Pendakian - SummitBuddy')

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
<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <aside style="flex: 1; min-width: 220px;">
        <h3 style="margin-bottom: 20px; color: #1b5e2f; border-bottom: 2px solid #ff8c42; padding-bottom: 8px; display: inline-block;">
            <i class="fas fa-filter"></i> Filter Kategori
        </h3>
        <div style="display: flex; flex-direction: column; gap: 12px; margin: 20px 0 30px 0;">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: normal;">
                <input type="checkbox" value="Tenda" class="filter-cb" style="width: 18px; height: 18px; cursor: pointer; accent-color: #1b5e2f; margin: 0;">
                <span>🏕️ Tenda</span>
            </label>
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: normal;">
                <input type="checkbox" value="Carrier" class="filter-cb" style="width: 18px; height: 18px; cursor: pointer; accent-color: #1b5e2f; margin: 0;">
                <span>🎒 Carrier</span>
            </label>
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: normal;">
                <input type="checkbox" value="Sleeping" class="filter-cb" style="width: 18px; height: 18px; cursor: pointer; accent-color: #1b5e2f; margin: 0;">
                <span>🛌 Sleeping Bag</span>
            </label>
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: normal;">
                <input type="checkbox" value="Kompor" class="filter-cb" style="width: 18px; height: 18px; cursor: pointer; accent-color: #1b5e2f; margin: 0;">
                <span>🔥 Kompor</span>
            </label>
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: normal;">
                <input type="checkbox" value="Aksesoris" class="filter-cb" style="width: 18px; height: 18px; cursor: pointer; accent-color: #1b5e2f; margin: 0;">
                <span>🔦 Aksesoris</span>
            </label>
        </div>

        <h3 style="margin-bottom: 15px; color: #1b5e2f; font-size: 18px;">📊 Statistik</h3>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
            <span>Total Alat</span>
            <span style="font-weight: bold; color: #ff8c42;">{{ $totalItem }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
            <span>Tersedia</span>
            <span style="font-weight: bold; color: #ff8c42;">{{ $tersedia }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
            <span>Dipinjam</span>
            <span style="font-weight: bold; color: #ff8c42;">{{ $dipinjam }}</span>
        </div>
    </aside>

    <section style="flex: 3;">
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <input type="text" id="searchInput" placeholder="Cari alat..." style="flex: 1; padding: 12px 20px; border: 2px solid #e0e0e0; border-radius: 50px;">
            <button id="searchBtn" style="padding: 12px 30px; background: linear-gradient(135deg, #1b5e2f, #43a047); color: white; border: none; border-radius: 50px; cursor: pointer;">🔍 Cari</button>
        </div>

        <div style="overflow-x: auto; margin: 20px 0;">
            <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 20px; overflow: hidden;">
                <thead>
                    <tr style="background: #1b5e2f; color: white;">
                        <th style="padding: 12px; text-align: left;">Kode</th>
                        <th style="padding: 12px; text-align: left;">Nama Alat</th>
                        <th style="padding: 12px; text-align: left;">Foto</th>
                        <th style="padding: 12px; text-align: left;">Kategori</th>
                        <th style="padding: 12px; text-align: left;">Stok</th>
                        <th style="padding: 12px; text-align: left;">Harga Sewa/Hari</th>
                    </tr>
                </thead>
                <tbody id="alatBody">
                    @foreach($daftarAlat as $alat)
                    <tr data-kode="{{ $alat['kode'] }}" data-nama="{{ $alat['nama'] }}" data-kategori="{{ $alat['kategori'] }}" style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;">{{ $alat['kode'] }}</td>
                        <td style="padding: 12px;">{{ $alat['nama'] }}</td>
                        <td style="padding: 12px;">
                            <img src="{{ asset($alat['foto']) }}"
                                 alt="{{ $alat['nama'] }}"
                                 width="50" height="50"
                                 style="object-fit:cover; border-radius:8px;"
                                 onerror="this.src='https://via.placeholder.com/50?text=No+Image'">
                        </td>
                        <td style="padding: 12px;">{{ $alat['kategori'] }}</td>
                        <td style="padding: 12px;">{{ $alat['stok'] }}</td>
                        <td style="padding: 12px;">Rp {{ number_format($alat['harga'], 0, ',', '.') }}</td>
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

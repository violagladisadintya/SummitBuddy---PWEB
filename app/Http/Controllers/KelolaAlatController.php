<?php

namespace App\Http\Controllers;

class KelolaAlatController extends Controller
{
    public function index()
    {
        $daftarAlat = [
            ['id' => 1, 'kode' => 'A001', 'nama' => 'Tenda Dome', 'kategori' => 'Tenda', 'stok' => 10, 'harga' => 100000, 'tglMasuk' => '2024-01-15'],
            ['id' => 2, 'kode' => 'A002', 'nama' => 'Carrier 60L', 'kategori' => 'Carrier', 'stok' => 8, 'harga' => 80000, 'tglMasuk' => '2024-01-20'],
            ['id' => 3, 'kode' => 'A003', 'nama' => 'Sleeping Bag', 'kategori' => 'Sleeping', 'stok' => 7, 'harga' => 50000, 'tglMasuk' => '2024-02-10'],
            ['id' => 4, 'kode' => 'A004', 'nama' => 'Kompor Portable', 'kategori' => 'Kompor', 'stok' => 5, 'harga' => 40000, 'tglMasuk' => '2024-02-15'],
            ['id' => 5, 'kode' => 'A005', 'nama' => 'Matras', 'kategori' => 'Aksesoris', 'stok' => 3, 'harga' => 30000, 'tglMasuk' => '2024-03-01'],
            ['id' => 6, 'kode' => 'A006', 'nama' => 'Headlamp', 'kategori' => 'Aksesoris', 'stok' => 12, 'harga' => 25000, 'tglMasuk' => '2024-03-10'],
            ['id' => 7, 'kode' => 'A007', 'nama' => 'Carrier 80L', 'kategori' => 'Carrier', 'stok' => 4, 'harga' => 100000, 'tglMasuk' => '2024-03-15'],
            ['id' => 8, 'kode' => 'A008', 'nama' => 'Tenda 4 Season', 'kategori' => 'Tenda', 'stok' => 2, 'harga' => 150000, 'tglMasuk' => '2024-04-01'],
        ];

        $daftarSewa = [
            ['id' => 101, 'nama' => 'Andi Pratama', 'noHp' => '08123456789', 'alat' => 'Tenda', 'jumlah' => 2, 'tglSewa' => '2024-12-10', 'tglKembali' => '2024-12-12', 'totalHarga' => 200000],
            ['id' => 102, 'nama' => 'Sari Dewi', 'noHp' => '08198765432', 'alat' => 'Carrier', 'jumlah' => 1, 'tglSewa' => '2024-12-15', 'tglKembali' => '2024-12-17', 'totalHarga' => 160000],
            ['id' => 103, 'nama' => 'Budi Santoso', 'noHp' => '08155555555', 'alat' => 'Sleeping Bag', 'jumlah' => 3, 'tglSewa' => '2024-12-20', 'tglKembali' => '2024-12-22', 'totalHarga' => 150000],
            ['id' => 104, 'nama' => 'Rina Wahyuni', 'noHp' => '08144444444', 'alat' => 'Kompor', 'jumlah' => 1, 'tglSewa' => '2024-12-25', 'tglKembali' => '2024-12-26', 'totalHarga' => 40000],
        ];

        $statistik = [
            'totalAlat' => count($daftarAlat),
            'totalStok' => array_sum(array_column($daftarAlat, 'stok')),
            'totalNilai' => array_sum(array_map(fn($a) => $a['stok'] * $a['harga'], $daftarAlat)),
            'stokMenipis' => count(array_filter($daftarAlat, fn($a) => $a['stok'] < 5)),
            'totalSewa' => count($daftarSewa),
        ];

        return view('kelola-alat', compact('daftarAlat', 'daftarSewa', 'statistik'));
    }
}

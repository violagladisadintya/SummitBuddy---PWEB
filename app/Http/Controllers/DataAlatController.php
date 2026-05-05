<?php

namespace App\Http\Controllers;

class DataAlatController extends Controller
{
    public function index()
    {
        $daftarAlat = [
            ['kode' => 'A001', 'nama' => 'Tenda Dome', 'kategori' => 'Tenda', 'stok' => 10, 'harga' => 100000, 'foto' => 'image/Tenda.jpg'],
            ['kode' => 'A002', 'nama' => 'Carrier 60L', 'kategori' => 'Carrier', 'stok' => 8, 'harga' => 80000, 'foto' => 'image/Carrier Bag 60L.jpg'],
            ['kode' => 'A003', 'nama' => 'Sleeping Bag', 'kategori' => 'Sleeping', 'stok' => 7, 'harga' => 50000, 'foto' => 'image/SleepingBag.jpg'],
            ['kode' => 'A004', 'nama' => 'Kompor Portable', 'kategori' => 'Kompor', 'stok' => 5, 'harga' => 40000, 'foto' => 'image/Kompor.jpg'],
            ['kode' => 'A005', 'nama' => 'Matras', 'kategori' => 'Aksesoris', 'stok' => 3, 'harga' => 30000, 'foto' => 'image/Matras.jpg'],
            ['kode' => 'A006', 'nama' => 'Headlamp', 'kategori' => 'Aksesoris', 'stok' => 12, 'harga' => 25000, 'foto' => 'image/headlamp.jpg'],
            ['kode' => 'A007', 'nama' => 'Carrier 80L', 'kategori' => 'Carrier', 'stok' => 4, 'harga' => 100000, 'foto' => 'image/Carrier Bag 60L.jpg'],
            ['kode' => 'A008', 'nama' => 'Tenda 4 Season', 'kategori' => 'Tenda', 'stok' => 2, 'harga' => 150000, 'foto' => 'image/Tenda.jpg'],
        ];

        $totalItem = array_sum(array_column($daftarAlat, 'stok'));
        $tersedia = $totalItem;
        $dipinjam = 0;

        return view('data-alat', compact('daftarAlat', 'totalItem', 'tersedia', 'dipinjam'));
    }
}

<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'A001', 'nama' => 'Tenda Dome', 'kategori' => 'Tenda', 'stok' => 10, 'harga' => 100000, 'tgl_masuk' => '2024-01-15', 'foto' => 'image/Tenda.jpg'],
            ['kode' => 'A002', 'nama' => 'Carrier 60L', 'kategori' => 'Carrier', 'stok' => 8, 'harga' => 80000, 'tgl_masuk' => '2024-01-20', 'foto' => 'image/Carrier Bag 60L.jpg'],
            ['kode' => 'A003', 'nama' => 'Sleeping Bag', 'kategori' => 'Sleeping', 'stok' => 7, 'harga' => 50000, 'tgl_masuk' => '2024-02-10', 'foto' => 'image/SleepingBag.jpg'],
            ['kode' => 'A004', 'nama' => 'Kompor Portable', 'kategori' => 'Kompor', 'stok' => 5, 'harga' => 40000, 'tgl_masuk' => '2024-02-15', 'foto' => 'image/Kompor.jpg'],
            ['kode' => 'A005', 'nama' => 'Matras', 'kategori' => 'Aksesoris', 'stok' => 3, 'harga' => 30000, 'tgl_masuk' => '2024-03-01', 'foto' => 'image/Matras.jpg'],
            ['kode' => 'A006', 'nama' => 'Headlamp', 'kategori' => 'Aksesoris', 'stok' => 12, 'harga' => 25000, 'tgl_masuk' => '2024-03-10', 'foto' => 'image/headlamp.jpg'],
            ['kode' => 'A007', 'nama' => 'Carrier 80L', 'kategori' => 'Carrier', 'stok' => 4, 'harga' => 100000, 'tgl_masuk' => '2024-03-15', 'foto' => 'image/Carrier Bag 60L.jpg'],
            ['kode' => 'A008', 'nama' => 'Tenda 4 Season', 'kategori' => 'Tenda', 'stok' => 2, 'harga' => 150000, 'tgl_masuk' => '2024-04-01', 'foto' => 'image/Tenda.jpg'],
        ];

        foreach ($data as $item) {
            Alat::create($item);
        }
    }
}

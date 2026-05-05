<?php

namespace Database\Seeders;

use App\Models\Penyewa;
use Illuminate\Database\Seeder;

class PenyewaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Andi Pratama', 'no_hp' => '08123456789', 'email' => 'andi@email.com', 'alamat' => 'Yogyakarta'],
            ['nama' => 'Sari Dewi', 'no_hp' => '08198765432', 'email' => 'sari@email.com', 'alamat' => 'Jakarta'],
            ['nama' => 'Budi Santoso', 'no_hp' => '08155555555', 'email' => 'budi@email.com', 'alamat' => 'Bandung'],
        ];

        foreach ($data as $item) {
            Penyewa::create($item);
        }
    }
}

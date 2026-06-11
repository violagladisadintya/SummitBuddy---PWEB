<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Pendaki Lawu',
                'email' => 'pendaki@lawu.com',
                'password' => \Hash::make('password'),
            ]);
        }

        $data = [
            ['user_id' => $user->id, 'nama' => 'Andi Pratama', 'role' => 'Mahasiswa, Pendaki Pemula', 'rating' => 5, 'pesan' => 'Alat lengkap dan berkualitas! Pelayanannya ramah. Next mau sewa lagi pasti di SummitBuddy.'],
            ['user_id' => $user->id, 'nama' => 'Sari Dewi', 'role' => 'Pendaki Gunung Rinjani', 'rating' => 5, 'pesan' => 'Tenda dan carrier dalam kondisi prima. Harga sewa terjangkau. Recommended!'],
            ['user_id' => $user->id, 'nama' => 'Budi Santoso', 'role' => 'Anggota Mapala', 'rating' => 4, 'pesan' => 'Pelayanan cepat, alat lengkap. Sayang kompor agak kotor, tapi overall oke!'],
            ['user_id' => $user->id, 'nama' => 'Rina Wahyuni', 'role' => 'Pendaki Gunung Semeru', 'rating' => 5, 'pesan' => 'Sewa matras dan sleeping bag, bersih dan wangi. Proses sewa gampang. Mantap!'],
        ];

        foreach ($data as $item) {
            Review::create($item);
        }
    }
}

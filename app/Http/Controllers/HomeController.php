<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $alatPopuler = [
            ['nama' => 'Tenda', 'harga' => 100000, 'foto' => 'image/Tenda.jpg'],
            ['nama' => 'Carrier', 'harga' => 80000, 'foto' => 'image/Carrier Bag 60L.jpg'],
            ['nama' => 'Sleeping Bag', 'harga' => 50000, 'foto' => 'image/SleepingBag.jpg'],
            ['nama' => 'Kompor', 'harga' => 40000, 'foto' => 'image/Kompor.jpg'],
            ['nama' => 'Matras', 'harga' => 30000, 'foto' => 'image/Matras.jpg'],
        ];

        $ulasan = [
            ['nama' => 'Andi Pratama', 'role' => 'Mahasiswa, Pendaki Pemula', 'rating' => 5, 'pesan' => '"Alat lengkap dan berkualitas! Pelayanannya ramah. Next mau sewa lagi pasti di SummitBuddy."'],
            ['nama' => 'Sari Dewi', 'role' => 'Pendaki Gunung Rinjani', 'rating' => 5, 'pesan' => '"Tenda dan carrier dalam kondisi prima. Harga sewa terjangkau. Recommended!"'],
            ['nama' => 'Budi Santoso', 'role' => 'Anggota Mapala', 'rating' => 4, 'pesan' => '"Pelayanan cepat, alat lengkap. Sayang kompor agak kotor, tapi overall oke!"'],
            ['nama' => 'Rina Wahyuni', 'role' => 'Pendaki Gunung Semeru', 'rating' => 5, 'pesan' => '"Sewa matras dan sleeping bag, bersih dan wangi. Proses sewa gampang. Mantap!"'],
        ];

        return view('home', compact('alatPopuler', 'ulasan'));
    }
}

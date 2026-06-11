<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Review;
use App\Models\Sewa;

class HomeController extends Controller
{
    public function index()
    {
        // Query active tools from the database (take 5)
        $alats = Alat::where('stok', '>', 0)->take(5)->get();
        $alatPopuler = [];
        foreach ($alats as $alat) {
            $fotoPath = $alat->foto;
            // Map the path to correct URL
            if ($fotoPath && !str_starts_with($fotoPath, 'image/') && !str_starts_with($fotoPath, 'http')) {
                $fotoPath = 'storage/' . $fotoPath;
            }
            $alatPopuler[] = [
                'nama' => $alat->nama,
                'harga' => $alat->harga,
                'foto' => $fotoPath ?: 'https://via.placeholder.com/150?text=No+Image'
            ];
        }

        // If database has no items, provide beautiful fallbacks
        if (empty($alatPopuler)) {
            $alatPopuler = [
                ['nama' => 'Tenda Dome', 'harga' => 100000, 'foto' => 'image/Tenda.jpg'],
                ['nama' => 'Carrier 60L', 'harga' => 80000, 'foto' => 'image/Carrier Bag 60L.jpg'],
                ['nama' => 'Sleeping Bag', 'harga' => 50000, 'foto' => 'image/SleepingBag.jpg'],
                ['nama' => 'Kompor Portable', 'harga' => 40000, 'foto' => 'image/Kompor.jpg'],
                ['nama' => 'Matras', 'harga' => 30000, 'foto' => 'image/Matras.jpg'],
            ];
        }

        // Fetch reviews from DB
        $dbReviews = Review::latest()->take(4)->get();
        $ulasan = [];
        foreach ($dbReviews as $rev) {
            $ulasan[] = [
                'nama' => $rev->nama,
                'role' => $rev->role,
                'rating' => $rev->rating,
                'pesan' => '"' . $rev->pesan . '"'
            ];
        }

        if (empty($ulasan)) {
            $ulasan = [
                ['nama' => 'Andi Pratama', 'role' => 'Mahasiswa, Pendaki Pemula', 'rating' => 5, 'pesan' => '"Alat lengkap dan berkualitas! Pelayanannya ramah. Next mau sewa lagi pasti di SummitBuddy."'],
                ['nama' => 'Sari Dewi', 'role' => 'Pendaki Gunung Rinjani', 'rating' => 5, 'pesan' => '"Tenda dan carrier dalam kondisi prima. Harga sewa terjangkau. Recommended!"'],
                ['nama' => 'Budi Santoso', 'role' => 'Anggota Mapala', 'rating' => 4, 'pesan' => '"Pelayanan cepat, alat lengkap. Sayang kompor agak kotor, tapi overall oke!"'],
                ['nama' => 'Rina Wahyuni', 'role' => 'Pendaki Gunung Semeru', 'rating' => 5, 'pesan' => '"Sewa matras dan sleeping bag, bersih dan wangi. Proses sewa gampang. Mantap!"'],
            ];
        }

        // Check if user has rented
        $hasRented = false;
        if (auth()->check()) {
            $hasRented = Sewa::where('user_id', auth()->id())->exists();
        }

        return view('home', compact('alatPopuler', 'ulasan', 'hasRented'));
    }
}


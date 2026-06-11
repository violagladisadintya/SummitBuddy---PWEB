<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Sewa;

class DataAlatController extends Controller
{
    public function index()
    {
        $alats = Alat::all();
        $daftarAlat = [];
        foreach ($alats as $alat) {
            $fotoPath = $alat->foto;
            if ($fotoPath && !str_starts_with($fotoPath, 'image/') && !str_starts_with($fotoPath, 'http')) {
                $fotoPath = 'storage/' . $fotoPath;
            }
            $daftarAlat[] = [
                'kode' => $alat->kode,
                'nama' => $alat->nama,
                'kategori' => $alat->kategori,
                'stok' => $alat->stok,
                'harga' => $alat->harga,
                'foto' => $fotoPath ?: 'https://via.placeholder.com/150?text=No+Image'
            ];
        }

        $tersedia = Alat::sum('stok');
        $dipinjam = Sewa::where('status', 'aktif')->sum('jumlah') ?: 0;
        $totalItem = $tersedia + $dipinjam;

        return view('data-alat', compact('daftarAlat', 'totalItem', 'tersedia', 'dipinjam'));
    }
}


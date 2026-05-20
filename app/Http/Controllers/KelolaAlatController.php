<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class KelolaAlatController extends Controller
{
    public function index()
    {
        $alats = Alat::latest()->paginate(10);
        $daftarSewa = session('data_sewa', []);
        $totalAlat = Alat::count();
        $totalStok = Alat::sum('stok');
        $totalNilai = Alat::sum(\DB::raw('stok * harga'));
        $stokMenipis = Alat::where('stok', '<', 5)->count();
        $totalSewa = count($daftarSewa);

        return view('kelola-alat', compact('alats', 'daftarSewa', 'totalAlat', 'totalStok', 'totalNilai', 'stokMenipis', 'totalSewa'));
    }
} 

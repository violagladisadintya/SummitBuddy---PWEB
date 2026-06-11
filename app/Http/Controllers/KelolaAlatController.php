<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelolaAlatController extends Controller
{
    public function index()
    {
        $alats = Alat::latest()->paginate(10);
        
        // Fetch rentals from database
        $sewas = Sewa::with('alat')->latest()->get();
        $daftarSewa = [];
        foreach ($sewas as $sewa) {
            $daftarSewa[] = [
                'id' => $sewa->id,
                'nama' => $sewa->nama,
                'noHp' => $sewa->no_hp,
                'alat' => $sewa->alat ? $sewa->alat->nama : 'Alat Terhapus',
                'alat_id' => $sewa->alat_id,
                'jumlah' => $sewa->jumlah,
                'tglSewa' => $sewa->tgl_sewa->format('Y-m-d'),
                'tglKembali' => $sewa->tgl_kembali->format('Y-m-d'),
                'totalHarga' => $sewa->total_harga,
                'keterangan' => $sewa->keterangan,
                'invoice_code' => $sewa->invoice_code,
                'status' => $sewa->status,
                'metode_pembayaran' => $sewa->metode_pembayaran,
                'status_pembayaran' => $sewa->status_pembayaran,
                'bukti_pembayaran' => $sewa->bukti_pembayaran,
            ];
        }

        $totalAlat = Alat::count();
        $totalStok = Alat::sum('stok');
        $totalNilai = Alat::sum(DB::raw('stok * harga'));
        $stokMenipis = Alat::where('stok', '<', 5)->count();
        $totalSewa = count($daftarSewa);

        // Report Statistics
        $totalPendapatan = Sewa::where('status', '!=', 'dibatalkan')->sum('total_harga');
        $sewaAktif = Sewa::where('status', 'aktif')->count();
        $sewaSelesai = Sewa::where('status', 'selesai')->count();
        $menungguVerifikasi = Sewa::where('status_pembayaran', 'Menunggu Verifikasi')->count();

        $nextKode = Alat::generateNextKode();

        return view('kelola-alat', compact(
            'alats', 'daftarSewa', 'totalAlat', 'totalStok', 'totalNilai', 
            'stokMenipis', 'totalSewa', 'nextKode',
            'totalPendapatan', 'sewaAktif', 'sewaSelesai', 'menungguVerifikasi'
          ));
    }
} 

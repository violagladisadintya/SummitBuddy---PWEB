<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormSewaController extends Controller
{
    public function index()
    {
        $daftarAlat = [
            ['id' => 1, 'nama' => 'Tenda', 'harga' => 100000],
            ['id' => 2, 'nama' => 'Carrier', 'harga' => 80000],
            ['id' => 3, 'nama' => 'Sleeping Bag', 'harga' => 50000],
            ['id' => 4, 'nama' => 'Kompor', 'harga' => 40000],
            ['id' => 5, 'nama' => 'Matras', 'harga' => 30000],
        ];

        return view('form-sewa', compact('daftarAlat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|min:3|max:100',
            'no_hp' => 'required|min:10|max:15',
            'alat_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'keterangan' => 'nullable|string',
        ]);

        $hargaAlat = [1 => 100000, 2 => 80000, 3 => 50000, 4 => 40000, 5 => 30000];

        $tgl1 = new \DateTime($request->tgl_sewa);
        $tgl2 = new \DateTime($request->tgl_kembali);
        $lamaHari = $tgl2->diff($tgl1)->days;
        $totalHarga = $request->jumlah * $hargaAlat[$request->alat_id] * $lamaHari;

        $sewa = session('data_sewa', []);
        $sewa[] = [
            'id' => count($sewa) + 1,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alat' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'total_harga' => $totalHarga,
            'keterangan' => $request->keterangan,
        ];
        session(['data_sewa' => $sewa]);

        return redirect()->route('form-sewa')->with('success', '✅ Penyewaan Berhasil! Terima kasih telah menyewa di SummitBuddy.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KunjunganController extends Controller
{
    public function index()
    {
        $jumlah = session('kunjungan_jumlah', 0);
        $pertama = session('kunjungan_pertama');
        $terakhir = session('kunjungan_terakhir');

        $jumlah++;

        if (!$pertama) {
            $pertama = now()->format('d M Y, H:i:s');
        }

        $terakhir = now()->format('d M Y, H:i:s');

        session([
            'kunjungan_jumlah' => $jumlah,
            'kunjungan_pertama' => $pertama,
            'kunjungan_terakhir' => $terakhir,
        ]);

        // Catat aktivitas
        $aktivitas = session('aktivitas_kunjungan', []);
        $aktivitas[] = ['waktu' => now()->format('d M Y H:i:s'), 'jumlah_ke' => $jumlah];
        if (count($aktivitas) > 10) $aktivitas = array_slice($aktivitas, -10);
        session(['aktivitas_kunjungan' => $aktivitas]);

        return view('kunjungan.index', compact('jumlah', 'pertama', 'terakhir'));
    }

    public function getStats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'jumlah' => session('kunjungan_jumlah', 0),
            'pertama' => session('kunjungan_pertama'),
            'terakhir' => session('kunjungan_terakhir'),
            'aktivitas' => session('aktivitas_kunjungan', [])
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        session()->forget(['kunjungan_jumlah', 'kunjungan_pertama', 'kunjungan_terakhir', 'aktivitas_kunjungan']);
        return response()->json(['success' => true, 'message' => 'Statistik berhasil direset!']);
    }
}

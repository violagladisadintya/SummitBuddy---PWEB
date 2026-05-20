<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AlatController extends Controller
{
    public function kelola()
    {
        $alats = Alat::latest()->paginate(10);
        $totalAlat = Alat::count();
        $totalStok = Alat::sum('stok');
        $totalNilai = Alat::sum(DB::raw('stok * harga'));
        $stokMenipis = Alat::where('stok', '<', 5)->count();
        $totalSewa = count(session('data_sewa', []));
        $daftarSewa = session('data_sewa', []);
        return view('kelola-alat', compact('alats', 'daftarSewa', 'totalAlat', 'totalStok', 'totalNilai', 'stokMenipis', 'totalSewa'));
    }

    public function index()
    {
        $alats = Alat::latest()->paginate(10);
        return view('alat.index', compact('alats'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:alats',
            'nama' => 'required|string|min:3|max:100',
            'kategori' => 'required|in:Tenda,Carrier,Sleeping,Kompor,Aksesoris',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tgl_masuk' => 'required|date',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Alat::create($validated);
        return redirect()->route('kelola-alat')->with('success', 'Alat berhasil ditambahkan!');
    }

    public function show(Alat $alat)
    {
        return view('alat.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:alats,kode,' . $alat->id,
            'nama' => 'required|string|min:3|max:100',
            'kategori' => 'required|in:Tenda,Carrier,Sleeping,Kompor,Aksesoris',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tgl_masuk' => 'required|date',
        ]);

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($validated);
        return redirect()->route('kelola-alat')->with('success', 'Alat berhasil diupdate!');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }
        $alat->delete();
        return redirect()->route('kelola-alat')->with('success', 'Alat berhasil dihapus!');
    }

    public function liveSearch()
    {
        return view('alat.live-search');
    }

    public function searchJson(Request $request): JsonResponse
    {
        $query = Alat::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($qry) use ($q) {
                $qry->where('kode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('kategori', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $alats = $query->orderBy('nama')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $alats->items(),
            'total' => $alats->total(),
            'current_page' => $alats->currentPage(),
            'last_page' => $alats->lastPage(),
            'from' => $alats->firstItem(),
            'to' => $alats->lastItem(),
        ]);
    }

    public function storeJson(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:alats',
            'nama' => 'required|string|min:3|max:100',
            'kategori' => 'required|in:Tenda,Carrier,Sleeping,Kompor,Aksesoris',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tgl_masuk' => 'required|date',
        ]);

        $alat = Alat::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Alat berhasil ditambahkan!',
            'data' => $alat
        ], 201);
    }
}

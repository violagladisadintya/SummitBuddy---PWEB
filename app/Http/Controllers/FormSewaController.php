<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DateTime;

class FormSewaController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->email === 'admin@summitbuddy.com') {
            return redirect()->route('kelola-alat', ['tab' => 'sewa']);
        }

        // Fetch active equipment items with stock > 0
        $daftarAlat = Alat::where('stok', '>', 0)->get()->toArray();
        
        return view('form-sewa', compact('daftarAlat'));
    }

    public function store(Request $request)
    {
        // 1. Validate fields
        $validated = $request->validate([
            'nama' => 'required|min:3|max:100',
            'no_hp' => 'required|min:10|max:15',
            'alats' => 'required|array|min:1',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'keterangan' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'metode_pembayaran' => 'required|in:Transfer,Tunai',
        ]);

        // 2. Filter out selected items
        $selectedAlats = [];
        foreach ($request->alats as $alatId => $data) {
            if (isset($data['selected']) && $data['selected'] == '1') {
                if (!isset($data['jumlah']) || (int)$data['jumlah'] < 1) {
                    return back()->with('error', 'Jumlah barang yang dipilih harus minimal 1!')->withInput();
                }
                $selectedAlats[$alatId] = (int)$data['jumlah'];
            }
        }

        if (empty($selectedAlats)) {
            return back()->with('error', 'Silakan centang minimal satu alat untuk disewa!')->withInput();
        }

        // 3. Validate stock for all selected items
        foreach ($selectedAlats as $alatId => $qty) {
            $alat = Alat::findOrFail($alatId);
            if ($alat->stok < $qty) {
                return back()->with('error', 'Stok alat "' . $alat->nama . '" tidak mencukupi! Tersisa: ' . $alat->stok)->withInput();
            }
        }

        // 4. Validate custom questions (None)
        $customAnswers = [];

        // 5. Handle file upload for bukti_pembayaran
        $buktiPembayaranPath = null;
        if ($request->metode_pembayaran === 'Transfer' && $request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti_pembayaran'), $filename);
            $buktiPembayaranPath = 'uploads/bukti_pembayaran/' . $filename;
        }

        // Determine status_pembayaran
        if ($request->metode_pembayaran === 'Tunai') {
            $statusPembayaran = 'COD (Bayar di Tempat)';
        } else {
            $statusPembayaran = $buktiPembayaranPath ? 'Menunggu Verifikasi' : 'Belum Bayar';
        }

        // 6. Generate invoice code
        $invoiceCode = 'SB-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 7. Calculate days
        $tgl1 = new DateTime($request->tgl_sewa);
        $tgl2 = new DateTime($request->tgl_kembali);
        $lamaHari = $tgl2->diff($tgl1)->days ?: 1;

        // 8. Save rental records
        foreach ($selectedAlats as $alatId => $qty) {
            $alat = Alat::findOrFail($alatId);
            $subtotal = $qty * $alat->harga * $lamaHari;

            // Decrement stock
            $alat->decrement('stok', $qty);

            // Create record
            Sewa::create([
                'invoice_code' => $invoiceCode,
                'user_id' => auth()->id(),
                'alat_id' => $alat->id,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jumlah' => $qty,
                'tgl_sewa' => $request->tgl_sewa,
                'tgl_kembali' => $request->tgl_kembali,
                'total_harga' => $subtotal,
                'status' => 'aktif',
                'keterangan' => $request->keterangan,
                'bukti_pembayaran' => $buktiPembayaranPath,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $statusPembayaran,
                'custom_answers' => $customAnswers,
            ]);
        }

        return redirect()->route('riwayat-sewa')->with('success', '✅ Penyewaan Berhasil! Nomor Invoice: ' . $invoiceCode . '. Silakan tunjukkan bukti sewa saat mengambil barang.');
    }

    public function destroy($id)
    {
        $sewa = Sewa::findOrFail($id);
        
        // Find all records under the same invoice to restore stock and delete
        $rentals = Sewa::where('invoice_code', $sewa->invoice_code)->get();
        foreach ($rentals as $item) {
            $alat = Alat::find($item->alat_id);
            if ($alat) {
                $alat->increment('stok', $item->jumlah);
            }
            $item->delete();
        }

        return redirect()->route('kelola-alat')->with('success', 'Transaksi sewa ' . $sewa->invoice_code . ' berhasil dibatalkan dan stok dikembalikan!');
    }

    public function history()
    {
        // Group user rentals by invoice code
        $rentals = Sewa::where('user_id', auth()->id())
            ->with('alat')
            ->latest()
            ->get()
            ->groupBy('invoice_code');

        return view('riwayat-sewa', compact('rentals'));
    }

    public function receipt($id)
    {
        // Find sewa by ID or by invoice code
        $sewaFirstQuery = Sewa::where(function($q) use ($id) {
            $q->where('id', $id)->orWhere('invoice_code', $id);
        });

        // If not admin, restrict to owner
        if (auth()->user()->email !== 'admin@summitbuddy.com') {
            $sewaFirstQuery->where('user_id', auth()->id());
        }

        $sewaFirst = $sewaFirstQuery->firstOrFail();

        $rentalsQuery = Sewa::where('invoice_code', $sewaFirst->invoice_code)->with('alat');
        
        if (auth()->user()->email !== 'admin@summitbuddy.com') {
            $rentalsQuery->where('user_id', auth()->id());
        }

        $rentals = $rentalsQuery->get();

        return view('bukti-sewa', compact('sewaFirst', 'rentals'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|min:3|max:100',
            'no_hp' => 'required|min:10|max:15',
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'keterangan' => 'nullable|string',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok < $request->jumlah) {
            return redirect()->route('kelola-alat')->with('error', 'Gagal: Stok tidak mencukupi! Tersisa: ' . $alat->stok);
        }

        $tgl1 = new DateTime($request->tgl_sewa);
        $tgl2 = new DateTime($request->tgl_kembali);
        $lamaHari = $tgl2->diff($tgl1)->days ?: 1;

        $totalHarga = $request->jumlah * $alat->harga * $lamaHari;

        $alat->decrement('stok', $request->jumlah);

        $invoiceCode = 'SB-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        Sewa::create([
            'invoice_code' => $invoiceCode,
            'user_id' => auth()->id(),
            'alat_id' => $alat->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'jumlah' => $request->jumlah,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'total_harga' => $totalHarga,
            'keterangan' => $request->keterangan,
            'metode_pembayaran' => 'Tunai',
            'status_pembayaran' => 'Lunas',
            'custom_answers' => null,
        ]);

        return redirect()->route('kelola-alat')->with('success', 'Penyewaan baru berhasil ditambahkan oleh Admin!');
    }

    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|min:3|max:100',
            'no_hp' => 'required|min:10|max:15',
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,selesai,dibatalkan',
            'status_pembayaran' => 'required|string',
        ]);

        $sewa = Sewa::findOrFail($id);
        $originalAlat = Alat::findOrFail($sewa->alat_id);
        $targetAlat = Alat::findOrFail($request->alat_id);

        // Tentatively increment original tool stock if old status was active
        if ($sewa->status === 'aktif') {
            $originalAlat->increment('stok', $sewa->jumlah);
        }

        // Decrement target tool stock if new status is active
        if ($request->status === 'aktif') {
            if ($targetAlat->stok < $request->jumlah) {
                // Revert original stock if target stock is insufficient
                if ($sewa->status === 'aktif') {
                    $originalAlat->decrement('stok', $sewa->jumlah);
                }
                return redirect()->route('kelola-alat')->with('error', 'Gagal: Stok tidak mencukupi! Tersisa: ' . $targetAlat->stok);
            }
            $targetAlat->decrement('stok', $request->jumlah);
        }

        $tgl1 = new DateTime($request->tgl_sewa);
        $tgl2 = new DateTime($request->tgl_kembali);
        $lamaHari = $tgl2->diff($tgl1)->days ?: 1;
        $totalHarga = $request->jumlah * $targetAlat->harga * $lamaHari;

        $sewa->update([
            'alat_id' => $targetAlat->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'jumlah' => $request->jumlah,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'total_harga' => $totalHarga,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        return redirect()->route('kelola-alat')->with('success', 'Penyewaan berhasil diperbarui oleh Admin!');
    }
}

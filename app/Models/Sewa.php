<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    protected $table = 'sewas';

    protected $fillable = [
        'invoice_code', 'user_id', 'alat_id', 'nama', 'no_hp', 'jumlah',
        'tgl_sewa', 'tgl_kembali', 'total_harga', 'status', 'keterangan', 'bukti_pembayaran',
        'metode_pembayaran', 'status_pembayaran', 'custom_answers'
    ];

    protected $casts = [
        'tgl_sewa' => 'date',
        'tgl_kembali' => 'date',
        'total_harga' => 'decimal:2',
        'jumlah' => 'integer',
        'custom_answers' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}

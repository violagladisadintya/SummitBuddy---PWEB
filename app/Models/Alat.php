<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alats';

    protected $fillable = [
        'kode', 'nama', 'kategori', 'stok', 'harga',
        'deskripsi', 'foto', 'tgl_masuk', 'aktif'  
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'aktif' => 'boolean',
        'tgl_masuk' => 'date',
        'stok' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0)->where('aktif', true);
    }
}

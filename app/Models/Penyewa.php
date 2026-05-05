<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $fillable = [
        'nama', 'no_hp', 'email', 'alamat'
    ];
}

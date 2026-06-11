<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id', 'nama', 'role', 'rating', 'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

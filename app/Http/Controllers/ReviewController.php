<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'role' => 'required|string|max:100',
            'pesan' => 'required|string|min:5|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->name,
            'role' => $validated['role'],
            'rating' => $validated['rating'],
            'pesan' => $validated['pesan'],
        ]);

        return redirect()->route('home')->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback-nya.');
    }
}

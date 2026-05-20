<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class PreferensiController extends Controller
{
    public function index()
    {
        return view('preferensi.index');
    }

    public function getPreferences(Request $request): JsonResponse
    {
        $tema = $request->cookie('preferensi_tema', 'light');
        $fontSize = $request->cookie('preferensi_font_size', 'medium');

        return response()->json([
            'success' => true,
            'tema' => $tema,
            'font_size' => $fontSize
        ]);
    }

    public function savePreferences(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tema' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,medium,large'
        ]);

        $cookieTema = Cookie::make('preferensi_tema', $validated['tema'], 60 * 24 * 365);
        $cookieFontSize = Cookie::make('preferensi_font_size', $validated['font_size'], 60 * 24 * 365);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil disimpan'
        ])->withCookie($cookieTema)->withCookie($cookieFontSize);
    }

    public function resetPreferences(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Preferensi direset'
        ])
        ->withCookie(Cookie::forget('preferensi_tema'))
        ->withCookie(Cookie::forget('preferensi_font_size'));
    }
}

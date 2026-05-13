<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah email user adalah admin
        if (auth()->user()->email !== 'admin@summitbuddy.com') {
            abort(403, 'Akses hanya untuk admin!');
        }

        return $next($request);
    }
}

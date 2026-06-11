<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataAlatController;
use App\Http\Controllers\KelolaAlatController;
use App\Http\Controllers\FormSewaController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

// All application routes are protected by authentication middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/data-alat', [DataAlatController::class, 'index'])->name('data-alat');
    Route::get('/form-sewa', [FormSewaController::class, 'index'])->name('form-sewa');
    Route::post('/form-sewa', [FormSewaController::class, 'store'])->name('form-sewa.store');
    
    // Customer history and receipt routes
    Route::get('/riwayat-sewa', [FormSewaController::class, 'history'])->name('riwayat-sewa');
    Route::get('/bukti-sewa/{id}', [FormSewaController::class, 'receipt'])->name('sewa.bukti');
    Route::post('/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/api/weather', [WeatherController::class, 'getWeather'])->name('weather.get');

    // User Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('alat', AlatController::class);
    Route::get('/kelola-alat', [KelolaAlatController::class, 'index'])->name('kelola-alat');
    
    // Admin Rental CRUD actions
    Route::post('/kelola-sewa', [FormSewaController::class, 'adminStore'])->name('sewa.admin.store');
    Route::put('/kelola-sewa/{id}', [FormSewaController::class, 'adminUpdate'])->name('sewa.admin.update');
    Route::delete('/kelola-sewa/{id}', [FormSewaController::class, 'destroy'])->name('sewa.destroy');


});

require __DIR__.'/auth.php';


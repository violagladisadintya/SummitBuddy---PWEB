<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataAlatController;
use App\Http\Controllers\KelolaAlatController;
use App\Http\Controllers\FormSewaController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PreferensiController;
use App\Http\Controllers\KunjunganController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/data-alat', [DataAlatController::class, 'index'])->name('data-alat');
Route::get('/form-sewa', [FormSewaController::class, 'index'])->name('form-sewa');
Route::post('/form-sewa', [FormSewaController::class, 'store'])->name('form-sewa.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('alat', AlatController::class);
});

Route::get('/kelola-alat', [KelolaAlatController::class, 'index'])->name('kelola-alat');

Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/api/weather', [WeatherController::class, 'getWeather'])->name('weather.get');

Route::get('/alat/live-search', [AlatController::class, 'liveSearch'])->name('alat.live-search');
Route::get('/api/alats/search', [AlatController::class, 'searchJson'])->name('alat.search.json');
Route::post('/api/alats', [AlatController::class, 'storeJson'])->name('alat.store.json');

Route::middleware(['auth'])->group(function () {
    Route::get('/preferensi', [PreferensiController::class, 'index'])->name('preferensi.index');
    Route::get('/api/preferensi', [PreferensiController::class, 'getPreferences'])->name('preferensi.get');
    Route::post('/api/preferensi', [PreferensiController::class, 'savePreferences'])->name('preferensi.save');
    Route::delete('/api/preferensi', [PreferensiController::class, 'resetPreferences'])->name('preferensi.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/api/kunjungan/stats', [KunjunganController::class, 'getStats'])->name('kunjungan.stats');
    Route::delete('/api/kunjungan/reset', [KunjunganController::class, 'reset'])->name('kunjungan.reset');
});

require __DIR__.'/auth.php';

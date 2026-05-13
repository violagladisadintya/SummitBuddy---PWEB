<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataAlatController;
use App\Http\Controllers\KelolaAlatController;
use App\Http\Controllers\FormSewaController;
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
    Route::get('/kelola-alat', [KelolaAlatController::class, 'index'])->name('kelola-alat');
});

require __DIR__.'/auth.php';

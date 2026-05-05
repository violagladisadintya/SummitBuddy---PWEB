<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataAlatController;
use App\Http\Controllers\KelolaAlatController;
use App\Http\Controllers\FormSewaController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/data-alat', [DataAlatController::class, 'index'])->name('data-alat');
Route::get('/kelola-alat', [KelolaAlatController::class, 'index'])->name('kelola-alat');
Route::get('/form-sewa', [FormSewaController::class, 'index'])->name('form-sewa');
Route::post('/form-sewa', [FormSewaController::class, 'store'])->name('form-sewa.store');

Route::get('/hitung/{a}/{b}', function ($a, $b) {$hasil = $a + $b;return "Hasil penjumlahan {$a} + {$b} = {$hasil}";})->name('hitung');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {return view('home');})->name('home');
Route::get('/data-alat', function () {return view('data-alat');})->name('data-alat');
Route::get('/kelola-alat', function () {return view('kelola-alat');})->name('kelola-alat');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::view('/tentang', 'tentang')->name('tentang');
Route::get('/hitung/{a}/{b}', function ($a, $b) {return $a + $b; });

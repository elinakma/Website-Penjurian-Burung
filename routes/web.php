<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\BurungController;
use App\Http\Controllers\KelasLombaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('acara', AcaraController::class);
    Route::post('acara/{acara}/mulai', [AcaraController::class, 'mulai'])->name('acara.mulai');
    Route::resource('burung', BurungController::class);
    Route::resource('kelas-lomba', KelasLombaController::class);
});

require __DIR__.'/auth.php';

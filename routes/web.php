<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JatahCutiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboardadmin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboardadmin');

Route::get('/dashboardkaryawan', function () {
    return view('karyawann.dashboard');
})->middleware(['auth', 'verified'])->name('dashboardkaryawan');

Route::middleware(['auth'])->group(function () {
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('jatah-cuti', JatahCutiController::class);
    Route::resource('pengajuan-cuti', PengajuanCutiController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

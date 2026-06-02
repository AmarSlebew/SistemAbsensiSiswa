<?php

use App\Http\Controllers\Guru\AttendanceController;
use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'guru'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Absensi
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/',                [AttendanceController::class, 'index'])->name('index');
        Route::get('/buat',            [AttendanceController::class, 'create'])->name('create');
        Route::get('/siswa',           [AttendanceController::class, 'getStudents'])->name('students');
        Route::post('/',               [AttendanceController::class, 'store'])->name('store');
        Route::get('/{attendance}',    [AttendanceController::class, 'show'])->name('show');
        Route::get('/{attendance}/edit', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/{attendance}',    [AttendanceController::class, 'update'])->name('update');
    });

    // Rekap Absensi
    Route::get('/rekap', [\App\Http\Controllers\Guru\RecapController::class, 'index'])->name('rekap.index');

    // Hasil Klasifikasi ML
    Route::get('/klasifikasi', [\App\Http\Controllers\Guru\ClassificationController::class, 'index'])->name('klasifikasi.index');
    Route::post('/klasifikasi/latih', [\App\Http\Controllers\Guru\ClassificationController::class, 'train'])->name('klasifikasi.train');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

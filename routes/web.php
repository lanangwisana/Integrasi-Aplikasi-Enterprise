<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DinasController;

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/faskes/detail', [DashboardController::class, 'cariFaskes'])->name('admin.faskes.detail');
    Route::get('/dashboard/faskes-statistik', [DashboardController::class, 'faskesStatistik'])->name('admin.dashboard.faskes');
    
    Route::get('/proyek/detail', [DashboardController::class, 'cariProyek'])->name('admin.proyek.detail');
    Route::get('/proyek/statistik', [DashboardController::class, 'statistikProyek'])->name('admin.proyek.statistik');

    Route::get('/penduduk/detail', [DashboardController::class, 'cariPenduduk'])->name('admin.penduduk.detail');
    Route::get('/penduduk/statistik', [DashboardController::class, 'statistikPenduduk'])->name('admin.penduduk.statistik');
});


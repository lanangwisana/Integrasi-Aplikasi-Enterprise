<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return redirect('/');
});
// Dinas Pendapatan
Route::get('/layanan/pendapatan', function () {
    return view('layanan.pendapatan');
})->name('layanan.pendapatan');

// Dinas Pekerjaan Umum
Route::get('/layanan/pekerjaan-umum', function () {
    return view('layanan.pekerjaanumum');
})->name('layanan.pekerjaanumum');

// Dinas Kesehatan
Route::get('/layanan/kesehatan', function () {
    return view('layanan.kesehatan');
})->name('layanan.kesehatan');

// Dinas Kependudukan
Route::get('/layanan/kependudukan', function () {
    return view('layanan.kependudukan');
})->name('layanan.kependudukan');

// ini routes
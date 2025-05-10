<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('beranda');
});
Route::get('/masuk', function () {
    return view('masuk');
})->name('login');
Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');
Route::get('/dashboard', function () {
    return view('dashboardadmin');
})->name('dashboard');
Route::get('/admin/barang', function () {
    return view('crudbarang');
})->name('crudbarang');
Route::get('/admin/kategori', function () {
    return view('crudkategori');
})->name('crudkategori');
Route::get('/admin/pesanan', function () {
    return view('crudpesanan');
})->name('crudpesanan');
Route::get('/admin/pengguna', function () {
    return view('crudpengguna');
})->name('crudpengguna');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;

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

Route::middleware(['guest'])->group(function() {
    Route::get('/masuk', [SessionController::class, 'index'])->name('login');
    Route::post('/masuk', [SessionController::class, 'login']);
});

//redirect klo ngakses home yg redirectifauthenticated tu
Route::get('/home', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin'); // Dashboard admin
    Route::get('/user', [UserController::class, 'index'])->name('user'); // Halaman beranda user
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout'); // Logout route
});



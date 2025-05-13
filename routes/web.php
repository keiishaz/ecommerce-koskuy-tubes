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

Route::get('/admin/pesanan', function () {
    return view('admin.crudpesanan');
})->name('crudpesanan');
Route::get('/admin/pengguna', function () {
    return view('admin.crudpengguna');
})->name('crudpengguna');
Route::get('/admin/pengguna', function () {
    return view('admin.crudpengguna');
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

    Route::get('/admin/barang', [AdminController::class, 'produk'])->name('crudbarang');
    Route::get('/admin/barang/tambah', [AdminController::class, 'tambahProduk'])->name('tambahproduk'); // Halaman tambah produk
    Route::post('/admin/barang/tambah', [AdminController::class, 'simpanProduk']); // Proses simpan produk
    Route::get('/admin/barang/{id}/edit', [AdminController::class, 'editProduk'])->name('editProduk');
    Route::put('/admin/barang/{id}', [AdminController::class, 'updateProduk'])->name('updateProduk');
    Route::delete('/admin/barang/{id}', [AdminController::class, 'hapusProduk'])->name('hapusProduk');

    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('kategori'); // Menampilkan daftar kategori
    Route::get('/admin/kategori/tambah', [AdminController::class, 'tambahKategori'])->name('tambahKategori'); // Form tambah kategori
    Route::post('/admin/kategori', [AdminController::class, 'simpanKategori'])->name('simpanKategori'); // Menyimpan kategori
    Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('editKategori'); // Form edit kategori
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('updateKategori'); // Update kategori
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'hapusKategori'])->name('hapusKategori'); // Hapus kategori
    
    
    Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('crudpengguna');
    Route::get('/admin/pengguna/tambah', [AdminController::class, 'tambahPengguna'])->name('tambahpengguna');    
    Route::get('/admin/pengguna/{id}/edit', [AdminController::class, 'editPengguna'])->name('editPengguna'); // Form edit kategori
});



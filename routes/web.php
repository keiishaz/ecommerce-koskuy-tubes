<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PenggunaController;

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


// ===========================
// Guest Routes (belum login)
// ===========================
    Route::get('/masuk', [SessionController::class, 'index'])->name('login'); // Halaman login
    Route::post('/masuk', [SessionController::class, 'login'])->name('prosesmasuk'); // Proses login
    Route::get('/daftar', [SessionController::class, 'daftar']);
    Route::post('/daftar', [SessionController::class, 'register'])->name('register');

// ===========================
// Redirect default
// ===========================
    Route::get('/home', function () {
        return redirect('/');
    });
    Route::get('/', function () {
        return redirect('/masuk');
    });

// ===========================
// Admin Routes
// ===========================
Route::middleware(['auth', 'can:admin-only'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    // Pesanan
    Route::get('/admin/pesanan', [PesananController::class, 'orders'])->name('crudpesanan');
    Route::get('/admin/order/confirm/{order}', [PesananController::class, 'confirmOrder'])->name('admin.order.confirm');
    Route::get('/admin/order/delete/{order}', [PesananController::class, 'deleteOrder'])->name('admin.order.delete');
    Route::put('/admin/order/{order}/status/{status}', [PesananController::class, 'updateOrderStatus'])->name('admin.order.updateStatus');

    // Produk
    Route::get('/admin/barang', [ProductController::class, 'produk'])->name('crudbarang');
    Route::get('/admin/barang/tambah', [ProductController::class, 'tambahProduk'])->name('tambahproduk');
    Route::post('/admin/barang/tambah', [ProductController::class, 'simpanProduk']);
    Route::get('/admin/barang/{id}/edit', [ProductController::class, 'editProduk'])->name('editProduk');
    Route::put('/admin/barang/{id}', [ProductController::class, 'updateProduk'])->name('updateProduk');
    Route::delete('/admin/barang/{id}', [ProductController::class, 'hapusProduk'])->name('hapusProduk');

    // Kategori
    Route::get('/admin/kategori', [CategoryController::class, 'kategori'])->name('kategori');
    Route::get('/admin/kategori/tambah', [CategoryController::class, 'tambahKategori'])->name('tambahKategori');
    Route::post('/admin/kategori', [CategoryController::class, 'simpanKategori'])->name('simpanKategori');
    Route::get('/admin/kategori/{id}/edit', [CategoryController::class, 'editKategori'])->name('editKategori');
    Route::put('/admin/kategori/{id}', [CategoryController::class, 'updateKategori'])->name('updateKategori');
    Route::delete('/admin/kategori/{id}', [CategoryController::class, 'hapusKategori'])->name('hapusKategori');

    // Profil Admin
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.akun');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // Pengguna
    Route::get('/admin/pengguna', [PenggunaController::class, 'pengguna'])->name('crudpengguna');
    Route::get('/admin/pengguna/tambah', [PenggunaController::class, 'tambahPengguna'])->name('tambahpengguna');
    Route::post('/admin/tambah-pengguna', [PenggunaController::class, 'storeUser'])->name('storePengguna');
    Route::delete('/admin/pengguna/{user}', [PenggunaController::class, 'deleteUser'])->name('deletePengguna');

});

// ===========================
// Pembeli/User Routes
// ===========================
Route::middleware(['auth', 'can:pembeli-only'])->group(function () {
    // Beranda dan detail produk
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/produk/{id}', [UserController::class, 'detailProduk'])->name('produk.detail');

    // Akun
    Route::get('/akun', [UserController::class, 'akun'])->name('akun');
    Route::put('/akun', [UserController::class, 'update'])->name('akun.update');

    // Keranjang
    Route::post('/product/{id}/add-to-cart', [CartController::class, 'addToCart'])->name('produk.addToCart');
    Route::get('/keranjang', [CartController::class, 'viewCart'])->name('keranjang');
    Route::delete('/keranjang/{id}/hapus', [CartController::class, 'deleteItem'])->name('keranjang.hapus');

    // Checkout dan pemesanan
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [OrderController::class, 'storeOrder'])->name('checkout.store');

    // Pesanan
    Route::get('/pesanan', [OrderController::class, 'pesanan'])->name('pesanan');
    Route::delete('/pesanan/{date}/cancel', [OrderController::class, 'cancelGroupOrder'])->name('pesanan.cancelGroup');
});

// ===========================
// Logout Routes
// ===========================
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');


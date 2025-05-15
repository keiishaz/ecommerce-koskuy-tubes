<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;
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


// ===========================
// Guest Routes (belum login)
// ===========================
Route::middleware(['guest'])->group(function() {
    Route::get('/masuk', [SessionController::class, 'index'])->name('login');
    Route::post('/masuk', [SessionController::class, 'login']);
    Route::post('/daftar', [SessionController::class, 'register'])->name('register');
});

// ===========================
// Redirect default
// ===========================
Route::get('/home', function () {
    return redirect('/masuk');
});

// ===========================
// Admin Routes
// ===========================
Route::middleware(['auth', 'can:admin-only'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin'); // Dashboard admin

    // Pesanan
    Route::get('/admin/pesanan', [AdminController::class, 'orders'])->name('crudpesanan');
    Route::get('/admin/order/confirm/{order}', [AdminController::class, 'confirmOrder'])->name('admin.order.confirm');
    Route::get('/admin/order/delete/{order}', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');
    Route::put('/admin/order/{order}/status/{status}', [AdminController::class, 'updateOrderStatus'])->name('admin.order.updateStatus');

    // Produk
    Route::get('/admin/barang', [AdminController::class, 'produk'])->name('crudbarang');
    Route::get('/admin/barang/tambah', [AdminController::class, 'tambahProduk'])->name('tambahproduk');
    Route::post('/admin/barang/tambah', [AdminController::class, 'simpanProduk']);
    Route::get('/admin/barang/{id}/edit', [AdminController::class, 'editProduk'])->name('editProduk');
    Route::put('/admin/barang/{id}', [AdminController::class, 'updateProduk'])->name('updateProduk');
    Route::delete('/admin/barang/{id}', [AdminController::class, 'hapusProduk'])->name('hapusProduk');

    // Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('kategori');
    Route::get('/admin/kategori/tambah', [AdminController::class, 'tambahKategori'])->name('tambahKategori');
    Route::post('/admin/kategori', [AdminController::class, 'simpanKategori'])->name('simpanKategori');
    Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('editKategori');
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('updateKategori');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'hapusKategori'])->name('hapusKategori');

    // Profil Admin
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.akun');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    //Keluar
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
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
    Route::post('/product/{id}/add-to-cart', [UserController::class, 'addToCart'])->name('produk.addToCart');
    Route::get('/keranjang', [UserController::class, 'viewCart'])->name('keranjang');
    Route::delete('/cart/{cartId}/remove', [UserController::class, 'removeFromCart'])->name('cart.remove');

    // Buy now
    Route::post('/product/{id}/buy-now', [UserController::class, 'buyNow'])->name('produk.buyNow');

    // Checkout dan pemesanan
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [UserController::class, 'storeOrder'])->name('checkout.store');

    // Pesanan
    Route::get('/pesanan', [UserController::class, 'pesanan'])->name('pesanan');
    Route::delete('/pesanan/{date}/cancel', [UserController::class, 'cancelGroupOrder'])->name('pesanan.cancelGroup');

    //Keluar
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
});

// Route::middleware(['auth'])->group(function() {
//     Route::get('/user', [UserController::class, 'index'])->name('user');
//     Route::get('/produk/{id}', [UserController::class, 'detailProduk'])->name('produk.detail');
//     Route::get('/akun', [UserController::class, 'akun'])->name('akun');
//     Route::post('/product/{id}/add-to-cart', [UserController::class, 'addToCart'])->name('produk.addToCart');
//     Route::get('/keranjang', [UserController::class, 'viewCart'])->name('keranjang');
//     Route::post('/product/{id}/buy-now', [UserController::class, 'buyNow'])->name('produk.buyNow');
//     Route::post('/checkout/store', [UserController::class, 'storeOrder'])->name('checkout.store');

//     Route::delete('/cart/{cartId}/remove', [UserController::class, 'removeFromCart'])->name('cart.remove');
//     Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
//     Route::get('/pesanan', [UserController::class, 'pesanan'])->name('pesanan');
// // Route untuk membatalkan seluruh kelompok pesanan
//     Route::delete('/pesanan/{date}/cancel', [UserController::class, 'cancelGroupOrder'])->name('pesanan.cancelGroup');
//     Route::put('/akun', [UserController::class, 'update'])->name('akun.update');
// Route::get('/admin/order/confirm/{order}', [AdminController::class, 'confirmOrder'])->name('admin.order.confirm');
// Route::get('/admin/order/delete/{order}', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');
// // Routes to handle the status update
// Route::put('/admin/order/{order}/status/{status}', [AdminController::class, 'updateOrderStatus'])->name('admin.order.updateStatus');
// Route::get('admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.akun');
// Route::post('admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

//     Route::get('/admin', [AdminController::class, 'index'])->name('admin'); // Dashboard admin
//     Route::get('/user', [UserController::class, 'index'])->name('user'); // Halaman beranda user
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout'); // Logout route
//     Route::get('/admin/pesanan', [AdminController::class, 'orders'])->name('crudpesanan');

//     Route::get('/admin/barang', [AdminController::class, 'produk'])->name('crudbarang');
//     Route::get('/admin/barang/tambah', [AdminController::class, 'tambahProduk'])->name('tambahproduk'); // Halaman tambah produk
//     Route::post('/admin/barang/tambah', [AdminController::class, 'simpanProduk']); // Proses simpan produk
//     Route::get('/admin/barang/{id}/edit', [AdminController::class, 'editProduk'])->name('editProduk');
//     Route::put('/admin/barang/{id}', [AdminController::class, 'updateProduk'])->name('updateProduk');
//     Route::delete('/admin/barang/{id}', [AdminController::class, 'hapusProduk'])->name('hapusProduk');

//     Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('kategori'); // Menampilkan daftar kategori
//     Route::get('/admin/kategori/tambah', [AdminController::class, 'tambahKategori'])->name('tambahKategori'); // Form tambah kategori
//     Route::post('/admin/kategori', [AdminController::class, 'simpanKategori'])->name('simpanKategori'); // Menyimpan kategori
//     Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('editKategori'); // Form edit kategori
//     Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('updateKategori'); // Update kategori
//     Route::delete('/admin/kategori/{id}', [AdminController::class, 'hapusKategori'])->name('hapusKategori'); // Hapus kategori
// });



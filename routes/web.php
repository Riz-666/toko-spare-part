<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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

Route::get('/', [IndexController::class, 'index'])->name('index');
//register
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register/proses', [RegisterController::class, 'register'])->name('register.submit');
//Auth Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('auth');
//Logout
Route::post('/login/logout', [LoginController::class, 'logout'])->name('logout');
//unlogin
Route::get('/unlogin', [LoginController::class, 'unlogin'])->name('unlogin');

Route::middleware(['auth', 'role:admin'])->group(function () {
    //livechat
    Route::get('/admin/chat-list', [ChatController::class, 'list'])->name('admin.chat.list');
    Route::get('/admin/chat/{user}', [ChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/admin/chat/messages/{user}', [ChatController::class, 'getMessages'])->name('admin.chat.messages');
    Route::post('/admin/chat/send', [ChatController::class, 'send'])->name('admin.chat.send');
    // Untuk admin
    Route::delete('/admin/chat/clear/{user}', [ChatController::class, 'clearChat'])->name('admin.chat.clear')->middleware(['auth', 'role:admin']);

    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.index');

    //Profile
    Route::get('/profile/admin', [AdminController::class, 'edit'])->name('profile.edit.admin');

    Route::post('/profile/admin', [AdminController::class, 'update'])->name('profile.update.admin');

    //Kelola User
    Route::get('/admin/user', [UserController::class, 'index'])->name('kelola.user');
    //Add
    Route::get('/admin/user/add', [UserController::class, 'create'])->name('add.user');
    Route::post('/admin/user/add/proses', [UserController::class, 'store'])->name('add.user.proses');
    //Edit
    Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
    Route::post('/admin/user/edit/proses/{id}', [UserController::class, 'update'])->name('edit.user.proses');
    //Hapus
    Route::post('/admin/user/hapus/proses/{id}', [UserController::class, 'destroy'])->name('hapus.user.proses');

    //Kelola Produk
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('kelola.produk');
    //Add
    Route::get('/admin/produk/add', [ProdukController::class, 'create'])->name('add.produk');
    Route::post('/admin/produk/add/proses', [ProdukController::class, 'store'])->name('add.produk.proses');
    //Edit
    Route::get('/admin/produk/edit/{id}', [ProdukController::class, 'edit'])->name('edit.produk');
    Route::post('/admin/produk/edit/proses/{id}', [ProdukController::class, 'update'])->name('edit.produk.proses');
    //Hapus
    Route::post('/admin/produk/hapus/proses/{id}', [ProdukController::class, 'destroy'])->name('hapus.produk.proses');

    //Kelola Kategori
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('kelola.kategori');
    //Add
    Route::get('/admin/kategori/add', [KategoriController::class, 'create'])->name('add.kategori');
    Route::post('/admin/kategori/add/proses', [KategoriController::class, 'store'])->name('add.kategori.proses');
    //Edit
    Route::get('/admin/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('edit.kategori');
    Route::post('/admin/kategori/edit/proses/{id}', [KategoriController::class, 'update'])->name('edit.kategori.proses');
    //Hapus
    Route::post('/admin/kategori/hapus/proses/{id}', [KategoriController::class, 'destroy'])->name('hapus.kategori.proses');

    //Kelola Pesanan
    Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('kelola.pesanan');
    //Edit
    Route::get('/admin/pesanan/edit/{id}', [PesananController::class, 'edit'])->name('edit.pesanan');
    Route::post('/admin/pesanan/edit/proses/{id}', [PesananController::class, 'update'])->name('edit.pesanan.proses');
    //Hapus
    Route::post('/admin/pesanan/hapus/proses/{id}', [PesananController::class, 'destroy'])->name('hapus.pesanan.proses');

    //Kelola pembayaran
    Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('kelola.pembayaran');
    //Edit
    Route::get('/admin/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('edit.pembayaran');
    Route::post('/admin/pembayaran/edit/proses/{id}', [PembayaranController::class, 'update'])->name('edit.pembayaran.proses');
    //Hapus
    Route::post('/admin/pembayaran/hapus/proses/{id}', [PembayaranController::class, 'destroy'])->name('hapus.pembayaran.proses');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    //livechat
    Route::get('/customer/chat/{user}', [ChatController::class, 'index'])->name('customer.chat.index');
    Route::get('/customer/chat/messages/{user}', [ChatController::class, 'getMessages'])->name('customer.chat.messages');
    Route::post('/customer/chat/send', [ChatController::class, 'send'])->name('customer.chat.send');
    Route::delete('/customer/chat/clear/{user}', [ChatController::class, 'clearChat'])->name('customer.chat.clear')->middleware(['auth', 'role:customer']);

    //Profile
    Route::get('/profile/user', [IndexController::class, 'edit'])->name('user.edit.profile');

    Route::post('/profile/user', [IndexController::class, 'update'])->name('user.update.profile');

    //add ke keranjang
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/pesanan/buat', [PesananController::class, 'buat'])->name('pesanan.buat');

    //Pemesanan
    Route::get('/detail/Pemesanan', [PemesananController::class, 'index'])->name('detail.pemesanan');

    //Keranjang
    Route::get('/detail/keranjang', [KeranjangController::class, 'cekKeranjang'])->name('cek.keranjang');
    
    //hapus
    Route::delete('/keranjang/{id}/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateJumlah'])->name('keranjang.update');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    //proses checkout langsung
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('checkout.proses');

    Route::get('/pesanan/{id}', [PesananController::class, 'detail'])->name('pesanan.detail');

    Route::post('/pesanan/{id}/bukti', [PembayaranController::class, 'upload'])->name('pesanan.uploadBukti');

    // dari chart
    Route::post('/checkout/keranjang', [CheckoutController::class, 'checkoutDariKeranjang'])->name('checkout.keranjang');

    // per-item
    Route::post('/keranjang/checkout/item/{id}', [CheckoutController::class, 'checkoutSatuan'])->name('keranjang.checkout.satuan');

    //Hapus Pesanan
    Route::delete('/pesanan/{id}/hapus', [PemesananController::class, 'destroy'])->name('pesanan.hapus');

    //Cetak Bukti Pemesanan
    Route::get('/pesanan/cetak/{id}', [PemesananController::class, 'cetak'])->name('pesanan.cetak');

    //pesanan batal
    Route::post('/pesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])->name('pesanan.batalkan');
});

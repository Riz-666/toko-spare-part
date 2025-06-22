<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\KeranjangApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\PesananApiController;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\ProfileApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Login
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//Produk
Route::get('/produk', [ProdukApiController::class, 'index']);
Route::get('/produk/{id}', [ProdukApiController::class, 'show']);
//Produk Update/Delete
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/produk', [ProdukApiController::class, 'store']);
    Route::put('/produk/{id}', [ProdukApiController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukApiController::class, 'destroy']);
});

//Kategori
Route::apiResource('/kategori', KategoriController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/kategori', KategoriController::class)->except(['index', 'show']);
});

//Chart
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/keranjang', [KeranjangApiController::class, 'index']);
    Route::post('/keranjang', [KeranjangApiController::class, 'tambah']);
    Route::put('/keranjang/{id}', [KeranjangApiController::class, 'update']);
    Route::delete('/keranjang/{id}', [KeranjangApiController::class, 'hapus']);
});

//Pesanan/checkout
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pesanan', [PesananApiController::class, 'index']);
    Route::post('/pesanan', [PesananApiController::class, 'store']);
    Route::get('/pesanan/{id}', [PesananApiController::class, 'show']);
});

//Pembayaran
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pembayaran', [PembayaranApiController::class, 'store']);
    Route::get('/pembayaran/{pesanan_id}', [PembayaranApiController::class, 'show']);
});

//Profile
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::post('/profile', [ProfileApiController::class, 'update']);
});

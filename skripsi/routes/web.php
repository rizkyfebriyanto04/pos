<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterProdukController;
use App\Http\Controllers\PenjualanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logoutaksi', [LoginController::class, 'logoutaksi'])->name('logoutaksi');
});
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::delete('delete/{id}', [UserController::class, 'delete'])->name('register.delete');

Route::get('kategori', [MasterProdukController::class, 'kategori'])->name('kategori');
Route::post('kategori', [MasterProdukController::class, 'kategori_aksi'])->name('kategori.action');
Route::post('delete-kategori/{id}', [MasterProdukController::class, 'hapus'])->name('kategori.hapus');

Route::get('produk', [MasterProdukController::class, 'produk'])->name('produk');
Route::post('produk', [MasterProdukController::class, 'produk_aksi'])->name('produk.action');
Route::post('delete-produk/{id}', [MasterProdukController::class, 'hapusproduk'])->name('produk.hapusproduk');

Route::get('penjualan', [PenjualanController::class, 'index'])->name('penjualan');
Route::post('transaksi', [PenjualanController::class, 'transaksi'])->name('penjualan.add');


Route::get('cetakbill/', [PenjualanController::class, 'cetakbill'])->name('penjualan.cetakbill');

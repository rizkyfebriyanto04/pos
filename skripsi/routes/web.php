<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterProdukController;
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
Route::delete('delete/{id}', [MasterProdukController::class, 'delete'])->name('kategori.delete');


Route::get('produk', [MasterProdukController::class, 'produk'])->name('produk');
Route::post('produk', [MasterProdukController::class, 'produk_aksi'])->name('produk.action');

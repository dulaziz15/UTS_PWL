<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
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

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::group(['prefix' => 'user'], function() {
    Route::get('/',  [UserController::class, 'index']);
    Route::post('/data', [UserController::class, 'data']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/create', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::get('{id}/delete', [UserController::class, 'confirm']);
    Route::delete('{id}/delete', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'kategori'], function() {
    Route::get('/',  [KategoriController::class, 'index']);
    Route::get('/data', [KategoriController::class, 'data']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/create', [KategoriController::class, 'store']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}/update', [KategoriController::class, 'update']);
    Route::put('/{id}/update', [KategoriController::class, 'update']);
    Route::get('{id}/delete', [KategoriController::class, 'confirm']);
    Route::delete('{id}/delete', [KategoriController::class, 'delete']);
});

Route::group(['prefix' => 'mobil'], function() {
    Route::get('/',  [MobilController::class, 'index']);
    Route::post('/data', [MobilController::class, 'data']);
    Route::get('/create', [MobilController::class, 'create']);
    Route::post('/create', [MobilController::class, 'store']);
    Route::get('/{id}', [MobilController::class, 'show']);
    Route::get('/spesifikasi/{id}', [MobilController::class, 'showSpesifikasi']);
    Route::get('/spesifikasi/{id}/edit', [MobilController::class, 'editSpesifikasi']);
    Route::put('/spesifikasi/{id}/update', [MobilController::class, 'updateSpesifikasi']);
    Route::get('/img/{id}', [MobilController::class, 'showImg']);
    Route::get('/{id}/edit', [MobilController::class, 'edit']);
    Route::put('/{id}/update', [MobilController::class, 'update']);
    Route::get('/{id}/delete', [MobilController::class, 'confirm']);
    Route::delete('/{id}/delete', [MobilController::class, 'delete']);
});

Route::group(['prefix' => 'transaksi'], function() {
    Route::get('/',  [TransaksiController::class, 'index']);
    Route::get('/create',  [TransaksiController::class, 'create']);
    Route::get('/data',  [TransaksiController::class, 'data']);
    Route::post('/create',  [TransaksiController::class, 'store']);
    Route::get('/{id}', [TransaksiController::class, 'show']);
    Route::get('/{id}/edit', [TransaksiController::class, 'edit']);
    Route::put('/{id}/update', [TransaksiController::class, 'update']);
    Route::get('/{id}/pelunasan', [TransaksiController::class, 'confirmPelunasan']);
    Route::post('/{id}/pelunasan', [TransaksiController::class, 'lunas']);
    Route::get('/{id}/delete', [TransaksiController::class, 'confirmDelete']);
    Route::post('/{id}/delete', [TransaksiController::class, 'delete']);
});

Route::group(['prefix' => 'laporan'], function() {
    Route::get('/',  [LaporanController::class, 'index']);
    Route::get('/data',  [LaporanController::class, 'data']);
});
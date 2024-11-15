<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NomenklaturController;
use App\Http\Controllers\SumberdanaController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/master/user', [UserController::class, 'index'])->name('master.user')->middleware('auth');
Route::get('/master/user/data', [UserController::class, 'getData'])->name('master.user.data');
Route::post('/master/user', [UserController::class, 'store'])->name('master.user.store');
Route::get('/master/user/{id}/edit', [UserController::class, 'edit'])->name('master.user.edit');
Route::put('/master/user/{id}', [UserController::class, 'update'])->name('master.user.update');
Route::delete('/master/user/{id}', [UserController::class, 'destroy'])->name('master.user.delete');
Route::get('/master/user/opd', [UserController::class, 'opd'])->name('master.user.opd');

Route::get('/master/nomenklatur', [NomenklaturController::class, 'index'])->name('master.nomenklatur');
Route::get('/master/nomenklatur/data', [NomenklaturController::class, 'getData'])->name('master.nomenklatur.data');
Route::post('/master/nomenklatur', [NomenklaturController::class, 'store'])->name('master.nomenklatur.store');
Route::get('/master/nomenklatur/{id}/edit', [NomenklaturController::class, 'edit'])->name('master.nomenklatur.edit');
Route::put('/master/nomenklatur/{id}', [NomenklaturController::class, 'update'])->name('master.nomenklatur.update');
Route::delete('/master/nomenklatur/{id}', [NomenklaturController::class, 'destroy'])->name('master.nomenklatur.delete');

Route::get('/master/sumberdana', [SumberdanaController::class, 'index'])->name('master.sumberdana');
Route::get('/master/sumberdana/data', [SumberdanaController::class, 'getData'])->name('master.sumberdana.data');
Route::post('/master/sumberdana', [SumberdanaController::class, 'store'])->name('master.sumberdana.store');
Route::get('/master/sumberdana/{id}/edit', [SumberdanaController::class, 'edit'])->name('master.sumberdana.edit');
Route::put('/master/sumberdana/{id}', [SumberdanaController::class, 'update'])->name('master.sumberdana.update');
Route::delete('/master/sumberdana/{id}', [SumberdanaController::class, 'destroy'])->name('master.sumberdana.delete');

Route::get('/master/dasarhukum', [DashboardController::class, 'index'])->name('master.dasarhukum');
Route::get('/laporan', [DashboardController::class, 'index'])->name('laporan');
Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi');

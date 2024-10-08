<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;


Route::get('/template', function () {
    return view('admin.template.layout');
});
Route::get('/', function () {
    return view('admin.dashboard.index');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/master/user', [UserController::class, 'index'])->name('master.user');
Route::get('/master/user/data', [UserController::class, 'getData'])->name('master.user.data');
Route::post('/master/user', [UserController::class, 'store'])->name('master.user.store');
Route::get('/master/user/{id}/edit', [UserController::class, 'edit'])->name('master.user.edit');
Route::put('/master/user/{id}', [UserController::class, 'update'])->name('master.user.update');
Route::delete('/master/user/{id}', [UserController::class, 'destroy'])->name('master.user.delete');
Route::get('/master/user/opd', [UserController::class, 'opd'])->name('master.user.opd');

Route::get('/master/dasarhukum', [DashboardController::class, 'index'])->name('master.dasarhukum');
Route::get('/master/nomenklatur', [DashboardController::class, 'index'])->name('master.nomenklatur');
Route::get('/master/sumberdana', [DashboardController::class, 'index'])->name('master.sumberdana');
Route::get('/monitoring', [DashboardController::class, 'index'])->name('realisasi');
Route::get('/realisasi', [DashboardController::class, 'index'])->name('monitoring');

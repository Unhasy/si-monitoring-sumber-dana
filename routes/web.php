<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::get('/template', function () {
    return view('admin.template.layout');
});
Route::get('/', function () {
    return view('admin.dashboard.index');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/master/user', [DashboardController::class, 'index'])->name('master.user');
Route::get('/master/dasarhukum', [DashboardController::class, 'index'])->name('master.dasarhukum');
Route::get('/master/nomenklatur', [DashboardController::class, 'index'])->name('master.nomenklatur');
Route::get('/master/sumberdana', [DashboardController::class, 'index'])->name('master.sumberdana');
Route::get('/monitoring', [DashboardController::class, 'index'])->name('realisasi');
Route::get('/realisasi', [DashboardController::class, 'index'])->name('monitoring');

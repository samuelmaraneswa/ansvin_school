<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\Profile\SejarahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profile')->name('profile.')->group(function () {
  Route::get('sejarah', [SejarahController::class, 'index'])->name('sejarah');
});

Route::get('login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('login', [AuthController::class, 'login'])->middleware('guest')->name('login.store');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
});

Route::prefix('guru')->name('guru.')->middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
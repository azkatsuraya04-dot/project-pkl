<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SiswaPerusahaanController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\HubinController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\HubinSiswaController;


/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.process');

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->middleware('auth')
 ->name('logout');


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])->group(function () {

    Route::get(
        '/siswa/dashboard',
        [SiswaDashboardController::class, 'index']
    )->name('siswa.dashboard');


    Route::get(
        '/siswa/perusahaan',
        [SiswaPerusahaanController::class, 'index']
    )->name('siswa.perusahaan');


    Route::post(
        '/siswa/perusahaan/{perusahaan}/ajukan',
        [SiswaPerusahaanController::class, 'ajukan']
    )->name('siswa.perusahaan.ajukan');


    Route::get(
        '/siswa/pengajuan',
        [SiswaPerusahaanController::class, 'pengajuan']
    )->name('siswa.pengajuan');

});


/*
|--------------------------------------------------------------------------
| KAPROG
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kaprog'])->group(function () {

    Route::get(
        '/kaprog/dashboard',
        [KaprogController::class, 'dashboard']
    )->name('kaprog.dashboard');


    Route::put(
        '/kaprog/pengajuan/{pengajuan}/setujui',
        [KaprogController::class, 'setujui']
    )->name('kaprog.setujui');


    Route::put(
        '/kaprog/pengajuan/{pengajuan}/tolak',
        [KaprogController::class, 'tolak']
    )->name('kaprog.tolak');

});


/*
|--------------------------------------------------------------------------
| HUBIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hubin'])->group(function () {

    Route::get(
        '/hubin/dashboard',
        [HubinController::class, 'dashboard']
    )->name('hubin.dashboard');


    Route::put(
        '/hubin/pengajuan/{pengajuan}/proses',
        [HubinController::class, 'proses']
    )->name('hubin.proses');


    Route::put(
        '/hubin/pengajuan/{pengajuan}/tolak',
        [HubinController::class, 'tolak']
    )->name('hubin.tolak');


    Route::get(
    '/hubin/siswa',
    [HubinSiswaController::class, 'index']
    )->name('hubin.siswa');

    Route::post(
        '/hubin/siswa',
        [HubinSiswaController::class, 'store']
    )->name('hubin.siswa.store');

    Route::put(
        '/hubin/siswa/{siswa}',
        [HubinSiswaController::class, 'update']
    )->name('hubin.siswa.update');

    Route::delete(
        '/hubin/siswa/{siswa}',
        [HubinSiswaController::class, 'destroy']
    )->name('hubin.siswa.destroy');


    /*
    |--------------------------------------------------------------------------
    | CRUD PERUSAHAAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/hubin/perusahaan',
        [PerusahaanController::class, 'index']
    )->name('hubin.perusahaan');


    Route::post(
        '/hubin/perusahaan',
        [PerusahaanController::class, 'store']
    )->name('hubin.perusahaan.store');


    Route::put(
        '/hubin/perusahaan/{perusahaan}',
        [PerusahaanController::class, 'update']
    )->name('hubin.perusahaan.update');


    Route::delete(
        '/hubin/perusahaan/{perusahaan}',
        [PerusahaanController::class, 'destroy']
    )->name('hubin.perusahaan.destroy');

});


/*
|--------------------------------------------------------------------------
| PEMBIMBING
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pembimbing'])->group(function () {

    Route::get(
        '/pembimbing/dashboard',
        [PembimbingController::class, 'dashboard']
    )->name('pembimbing.dashboard');


    Route::post(
        '/pembimbing/nilai/{id_pkl}',
        [PembimbingController::class, 'nilai']
    )->name('pembimbing.nilai');

});
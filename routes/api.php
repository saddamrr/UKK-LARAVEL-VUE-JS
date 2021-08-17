<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//LOGIN MASYARAKAT, PETUGAS, DAN ADMIN
Route::post('login', [LoginController::class, 'login']);
//INSERT MASYARAKAT
Route::post('register', [LoginController::class, 'register']);

Route::group(['middleware' => ['jwt.verify:admin,petugas,masyarakat']], function() {
    //ACTION LOGIN
    Route::get('login/cek', [LoginController::class, 'loginCek']);
    Route::post('logout', [LoginController::class, 'logout']);
});

//HALAMAN ADMIN
Route::group(['middleware' => ['jwt.verify:admin']], function () {
    //TABEL MASYARAKAT (RUD)
    Route::get('masyarakat', [MasyarakatController::class, 'getAll']);
    Route::get('masyarakat/{id_user}', [MasyarakatController::class, 'getById']);
    Route::get('masyarakat/{limit}/{offset}', [MasyarakatController::class, 'getAll']);
    Route::put('masyarakat/{id_user}', [MasyarakatController::class, 'update']);
    Route::delete('masyarakat/{id_user}', [MasyarakatController::class, 'delete']);

    //TABEL PETUGAS (CRUD)
    Route::get('petugas', [PetugasController::class, 'getAll']);
    Route::get('petugas/{id_user}', [PetugasController::class, 'getById']);
    Route::get('petugas/{limit}/{offset}', [PetugasController::class, 'getAll']);
    Route::post('petugas', [PetugasController::class, 'insert']);
    Route::put('petugas/{id_user}', [PetugasController::class, 'update']);
    Route::delete('petugas/{id_user}', [PetugasController::class, 'delete']);

    //LAPORAN
    Route::post('pengaduan/laporan', [PengaduanController::class, 'report']);
});

//HALAMAN ADMIN, PETUGAS
Route::group(['middleware' => ['jwt.verify:petugas,admin']], function () {
    //ACTION TABEL PETUGAS
    Route::get('pengaduan', [PengaduanController::class, 'getAllPengaduan']);
    Route::get('pengaduan/{id_pengaduan}', [PengaduanController::class, 'getById']);
    Route::post('pengaduan/status', [PengaduanController::class, 'changeStatus']);
    Route::post('pengaduan/tanggapan', [TanggapanController::class, 'send']);
});

//HALAMAN MASYARAKAT
Route::group(['middleware' => ['jwt.verify:masyarakat']], function () {
    //PENGADUAN
	Route::get('penduduk/pengaduan', [PengaduanController::class, 'getAllPengaduan']);
	Route::get('penduduk/pengaduan/{limit}/{offset}', [PengaduanController::class, 'getAllPengaduan']);
	Route::post('penduduk/pengaduan', [PengaduanController::class, 'insert']);
});
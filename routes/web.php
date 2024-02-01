<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriSoalController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\mentorController;

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

Route::get('/', function () {
    return view('admin.dashboard.dashboard');
});

Route::controller(KategoriSoalController::class)->group(function () {
    Route::get('/masterKategoriSoal', 'index')->name('masterKategoriSoal');
    Route::post('/postKategoriSoal', 'store')->name('postKategoriSoal');
    Route::post('/updateKategoriSoal', 'update')->name('updateKategoriSoal');
});
Route::controller(mentorController::class)->group(function () {
    Route::get('/dataTentor', 'index')->name('dataTentor');
    Route::post('/addMentor', 'store')->name('addMentor');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
});
Route::controller(SoalController::class)->group(function () {
    Route::get('/tambah/soal', 'create')->name('soal.create');
    Route::post('/addMentor', 'store')->name('addMentor');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
});
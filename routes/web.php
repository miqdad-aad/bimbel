<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriSoalController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SekolahKedinasanController;

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
Route::controller(MentorController::class)->group(function () {
    Route::get('/dataTentor', 'index')->name('dataTentor');
    Route::post('/addMentor', 'store')->name('addMentor');
    Route::post('/updateMentor', 'update')->name('updateMentor');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
});

Route::controller(KegiatanController::class)->group(function () {
    Route::get('/dataKegiatan', 'index')->name('dataKegiatan');
    Route::post('/addKegiatan', 'store')->name('addKegiatan');
    Route::get('/deleteKegiatan/{hapus}', 'destroy')->name('deleteKegiatan');
});

Route::controller(SekolahKedinasanController::class)->group(function () {
    Route::get('/dataSekolahKedinasan', 'index')->name('dataSekolahKedinasan');
    Route::post('/addSekolahkedinasan', 'store')->name('addSekolahkedinasan');
    Route::post('/updateSekolahKedinasan', 'update')->name('updateSekolahKedinasan');
    Route::get('/deleteSekolahKedinasan/{hapus}', 'destroy')->name('deleteSekolahKedinasan');
});

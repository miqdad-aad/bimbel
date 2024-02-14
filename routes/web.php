<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriSoalController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SekolahKedinasanController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\MasterPaketController;
use App\Http\Controllers\PembelajaranController;

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

Route::controller(MasterPaketController::class)->group(function () {
    Route::get('/paketSoal', 'index')->name('masterPaket');
    Route::post('/addPaket', 'store')->name('addPaket');
    Route::get('/deleteKegiatan/{hapus}', 'destroy')->name('deleteKegiatan');
});

Route::controller(SekolahKedinasanController::class)->group(function () {
    Route::get('/dataSekolahKedinasan', 'index')->name('dataSekolahKedinasan');
    Route::post('/addSekolahkedinasan', 'store')->name('addSekolahkedinasan');
    Route::post('/updateSekolahKedinasan', 'update')->name('updateSekolahKedinasan');
    Route::get('/deleteSekolahKedinasan/{hapus}', 'destroy')->name('deleteSekolahKedinasan');
    Route::get('/masterFotoSekolah', 'masterFotoSekolah')->name('masterFotoSekolah');
    Route::post('/addFotoSekolah', 'addFotoSekolah')->name('addFotoSekolah');
    Route::get('/deleteFotoSekolahKedinasan/{hapus}', 'deleteFotoSekolahKedinasan')->name('deleteFotoSekolahKedinasan');
});
Route::controller(SoalController::class)->group(function () {
    Route::get('/soal', 'index')->name('soal.view');
    Route::get('/edit/soal/{id}', 'edit')->name('soal.edit');
    Route::get('/tambah/soal', 'create')->name('soal.create');
    Route::post('/addSoal', 'store')->name('addSoal.store');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
});

Route::controller(PembelajaranController::class)->group(function () {
    Route::get('/pembelajaran', 'index')->name('pembelajaran.view');
    Route::get('pembelajaran/edit/{id}', 'edit')->name('pembelajaran.edit');
    Route::get('/tambah/pembelajaran', 'create')->name('pembelajaran.create');
    Route::post('/addpembelajaran', 'store')->name('addpembelajaran.store');
    Route::get('/deletepembelajaran/{hapus}', 'destroy')->name('deletepembelajaran');
});

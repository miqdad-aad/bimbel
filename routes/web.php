<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriSoalController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SekolahKedinasanController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\MasterPaketController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaketBimbelController;
use App\Http\Controllers\MateriTesController;
use App\Http\Controllers\JenisTesController;
use App\Http\Controllers\BabTesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MasterOrganisasiController;
use App\Http\Controllers\MasterAkunController;

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


Route::controller(SiswaController::class)->group(function () {
    Route::get('/exam', 'exam')->name('exam');
});
Route::controller(MasterOrganisasiController::class)->group(function () {
    Route::get('/masterStrukturOrganisasi', 'create')->name('masterStrukturOrganisasi');
    Route::post('/masterStrukturOrganisasi/store', 'store')->name('masterStrukturOrganisasi.store');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/loginStore', 'loginStore')->name('loginStore')->middleware('cekstatus');
    Route::get('/registerMentor', 'registerMentor')->name('registerMentor');
    Route::post('/registerMentorStore', 'registerMentorStore')->name('registerMentorStore');
    Route::get('/registerSiswa', 'registerSiswa')->name('registerSiswa');
    Route::post('/registerSiswaStore', 'registerSiswaStore')->name('registerSiswaStore');
    Route::get('/logout', 'logout')->name('logout');
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
    Route::post('/updateStatusMentor', 'updateStatusMentor')->name('updateStatusMentor');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
});

Route::controller(KegiatanController::class)->group(function () {
    Route::get('/dataKegiatan', 'index')->name('dataKegiatan');
    Route::post('/addKegiatan', 'store')->name('addKegiatan');
    Route::get('/deleteKegiatan/{hapus}', 'destroy')->name('deleteKegiatan');
});

Route::controller(JenisTesController::class)->group(function () {
    Route::get('/jenisTes', 'index')->name('jenisTes');
    Route::post('/addJenisTes', 'store')->name('addJenisTes');
    Route::post('/updateJenisTes', 'update')->name('updateJenisTes');
    Route::get('/deleteJenisTes/{hapus}', 'destroy')->name('deleteJenisTes');
    Route::post('getJenisTes', 'getJenisTes')->name('getJenisTes');
    Route::post('/getMateriTes', 'getMateriTes')->name('getMateriTes');
    Route::post('/getBabTes', 'getBabTes')->name('getBabTes');
});

Route::controller(MateriTesController::class)->group(function () {
    Route::get('/materiTes', 'index')->name('materiTes');
    Route::post('/addMateriTes', 'store')->name('addMateriTes');
    Route::post('/updateMateriTes', 'update')->name('updateMateriTes');
    Route::get('/deleteMateriTes/{hapus}', 'destroy')->name('deleteMateriTes');
});

Route::controller(BabTesController::class)->group(function () {
    Route::get('/babTes', 'index')->name('babTes');
    Route::post('/addBabTes', 'store')->name('addBabTes');
    Route::post('/updateBabTes', 'update')->name('updateBabTes');
    Route::get('/deleteBabTes/{hapus}', 'destroy')->name('deleteBabTes');
});

Route::controller(MasterPaketController::class)->group(function () {
    Route::get('/paketSoal', 'index')->name('masterPaket');
    Route::get('/addPaket', 'create')->name('addPaket');
    Route::post('/storePaket', 'store')->name('storePaket');
});

Route::controller(PaketBimbelController::class)->group(function () {
    Route::get('/paketBimbel', 'index')->name('paketBimbel');
    Route::get('/addPaketBimbel', 'create')->name('addPaketBimbel');
    Route::post('/storePaketBimbel', 'store')->name('storePaketBimbel');
    Route::get('/editPaketBimbel/{id}', 'edit')->name('editPaketBimbel');
    Route::post('/updatePaketBimbel', 'update')->name('updatePaketBimbel');
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
    Route::post('/update/soal', 'update')->name('soal.update');
    Route::get('/tambah/soal', 'create')->name('soal.create');
    Route::post('/addSoal', 'store')->name('addSoal.store');
    Route::get('/deleteMentor/{hapus}', 'destroy')->name('deleteMentor');
    Route::get('/downloadTemplateSoal', 'downloadTemplateSoal')->name('downloadTemplateSoal');
});

Route::controller(PembelajaranController::class)->group(function () {
    Route::get('/pembelajaran', 'index')->name('pembelajaran.view');
    Route::get('pembelajaran/edit/{id}', 'edit')->name('pembelajaran.edit');
    Route::get('/tambah/pembelajaran', 'create')->name('pembelajaran.create');
    Route::post('/addpembelajaran', 'store')->name('addpembelajaran.store');
    Route::get('/deletepembelajaran/{hapus}', 'destroy')->name('deletepembelajaran');
    
});

Route::controller(BookingController::class)->group(function () {
    Route::get('/bookingUser', 'index')->name('booking.view');
    Route::get('/detailBookingUser/{id}', 'show')->name('booking.detail');
    Route::post('/bookingUpdate', 'update')->name('booking.update');
    Route::post('/flagApprove', 'flagApprove')->name('booking.flagApprove');
    
});

Route::controller(MasterAkunController::class)->group(function () {
    Route::get('/listAkun', 'index')->name('akun.view');
    Route::get('/editAkun/{id}', 'edit')->name('akun.edit');
    Route::get('/editProfile/{id}', 'editProfile')->name('akun.editProfile');
    Route::post('/updateProfile', 'updateProfile')->name('akun.updateProfile');
    Route::post('/updateAkun', 'update')->name('akun.update');
});

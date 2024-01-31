<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriSoalController;
use App\Http\Controllers\dataTentorController;

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
});
Route::controller(dataTentorController::class)->group(function () {
    Route::get('/dataTentor', 'dataTentor')->name('dataTentor');
});
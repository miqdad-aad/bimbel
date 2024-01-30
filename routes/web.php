<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kategoriSoalController;

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

Route::controller(kategoriSoalController::class)->group(function () {
    Route::get('/masterKategoriSoal', 'masterKategoriSoal')->name('masterKategoriSoal');
});
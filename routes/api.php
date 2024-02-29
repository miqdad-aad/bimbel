<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sekolahKedinasanApi', [App\Http\Controllers\Api\SekolahKedinasanController::class, 'sekolahKedinasanApi']);
Route::get('mentor', [App\Http\Controllers\Api\MentorController::class, 'mentor']);
Route::get('kegiatan', [App\Http\Controllers\Api\KegiatanController::class, 'kegiatan']);
Route::get('paket_bimbel', [App\Http\Controllers\Api\PaketBimbelController::class, 'paket_bimbel']);
Route::post('register_user', [App\Http\Controllers\Api\RegisterController::class, 'index']);
Route::post('booking', [App\Http\Controllers\Api\BookingController::class, 'store']);
Route::get('soal_coba', [App\Http\Controllers\Api\PaketBimbelController::class, 'soal_coba']);

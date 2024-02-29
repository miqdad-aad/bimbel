<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketBimbelModels;
use App\Models\SoalModels;

class PaketBimbelController extends Controller
{
    
    public function paket_bimbel()
    {
        $data = PaketBimbelModels::with(['detailPaket','paket_bimbel'])->get();
        if(!empty($data)) return response(array('total_data' => count($data), 'message' => 'data ditemukan', 'data' => $data), 200);
        return response(array('total_data' => count($data), 'message' => 'data tidak ditemukan', 'data' => $data), 400);
    }
    public function soal_coba()
    {
        $data = SoalModels::with('jawabanSoal')->whereNotNull('pertanyaan')->inRandomOrder()->limit(5)->get();
        if(!empty($data)) return response(array('total_data' => count($data), 'message' => 'data ditemukan', 'data' => $data), 200);
        return response(array('total_data' => count($data), 'message' => 'data tidak ditemukan', 'data' => $data), 400);
    }

   

}

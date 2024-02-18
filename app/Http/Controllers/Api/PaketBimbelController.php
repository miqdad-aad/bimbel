<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketBimbelModels;

class PaketBimbelController extends Controller
{
    
    public function paket_bimbel()
    {
        $data = PaketBimbelModels::with('detailPaket')->get();
        if(!empty($data)) return response(array('total_data' => count($data), 'message' => 'data ditemukan', 'data' => $data), 200);
        return response(array('total_data' => count($data), 'message' => 'data tidak ditemukan', 'data' => $data), 400);
    }

    function printJSON($v){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        echo json_encode($v, JSON_PRETTY_PRINT);
        exit;
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterOrganisasiModels;

class MasterOrganisasiController extends Controller
{
    //
    public function index()
    {
        $data = MasterOrganisasiModels::first();
        
        if(!empty($data)) return response(array('total_data' => 1, 'message' => 'data ditemukan', 'data' => $data), 200);
        return response(array('total_data' => 0, 'message' => 'data tidak ditemukan', 'data' => $data), 400);
    }
}

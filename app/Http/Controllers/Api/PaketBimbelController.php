<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketBimbelModels;
use App\Models\SoalModels;
use App\Models\JawabanSoalModels;
use App\Models\BookingUserModels;
use App\Models\DetailPaketBimbel;
use Auth;

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
        $data = SoalModels::whereNull('file_tambahan')->select('pertanyaan','id_soal')->inRandomOrder()->limit(1)->get();
        $exc = array();
        foreach($data as $k){
            $jawaban = JawabanSoalModels::where('id_soal', $k->id_soal)->get();
            $jawab = array();
            foreach($jawaban as $s){
                $dataObj = new \stdClass();
                $dataObj->kode_jawaban = $s->kode_jawaban;
                $dataObj->keterangan = $s->keterangan; 
                $jawab[] = $dataObj;
            }
            $k->jawaban_soal = $jawab;
            $exc[] = $k;

        }
        
        if(!empty($exc)) return response(array('total_data' => count($exc), 'message' => 'data ditemukan', 'data' => $exc), 200);
        return response(array('total_data' => count($exc), 'message' => 'data tidak ditemukan', 'data' => $exc), 400);
    }
  
    public function soal_exam($id_siswa)
    {
        $data = SoalModels::inRandomOrder();
        
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', $id_siswa)->first();
        $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_materi_tes')->toArray();
        $data->whereIn('id_materi', $detailPaket);
        $data->limit(1)->get();
        $data = $data->get();
        $exc = array();
        foreach($data as $k){
            $jawaban = JawabanSoalModels::where('id_soal', $k->id_soal)->get();
            $jawab = array();
            foreach($jawaban as $s){
                $dataObj = new \stdClass();
                $dataObj->kode_jawaban = $s->kode_jawaban;
                $dataObj->keterangan = $s->keterangan; 
                $dataObj->url_file_tambahan = '';
                if(!empty($s->file_tambahan)){
                    $dataObj->url_file_tambahan = asset('public/jawaban/'. $s->file_tambahan);
                }
                
                $jawab[] = $dataObj;
            }
            $k->jawaban_soal = $jawab;
            $exc[] = $k;

        }
        
        if(!empty($exc)) return response(array('total_data' => count($exc), 'message' => 'data ditemukan', 'data' => $exc), 200);
        return response(array('total_data' => count($exc), 'message' => 'data tidak ditemukan', 'data' => $exc), 400);
    }

    public function jawaban_soal(Request $request)
    {
        $jawaban = JawabanSoalModels::where('id_soal', $request->soal_id)->where('is_true', 1)->first();
        
        if($jawaban->kode_jawaban == $request->jawaban ){
            return response(array('keterangan' => $jawaban->rk, 'jawaban_benar' => $jawaban->kode_jawaban, 'status' => 'benar'), 200);
        }
        return response(array('keterangan' => $jawaban->rk, 'jawaban_benar' => $jawaban->kode_jawaban, 'status' => 'salah'), 200);
    }

   

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoalModels;
use App\Models\BookingUserModels;
use App\Models\JawabanSoalModels;
use App\Models\ExamProgresModels;
use App\Models\DetailPaketBimbel;
use Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function exam()
    {
        $totalSoalTersedia = SoalModels::inRandomOrder();    
        
        $progresExam =  ExamProgresModels::where('id_siswa', Auth::user()->id_siswa)->pluck('id_soal')->toArray();
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
        $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_materi_tes')->toArray();
     
        $totalSoalTersedia->whereIn('id_materi', $detailPaket);
        $totalSoalTersedia->whereNotIn('id_soal', $progresExam);
        $totalSoalTersedia->get();
        $totalSoalTersedia = $totalSoalTersedia->count();
        
      return view('siswa.exam', compact('totalSoalTersedia'));
    }

    public function soal_exam()
    {
        $data = SoalModels::inRandomOrder();    
        
        $progresExam =  ExamProgresModels::where('id_siswa', Auth::user()->id_siswa)->pluck('id_soal')->toArray();
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
        $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_materi_tes')->toArray();
     
        $data->whereIn('id_materi', $detailPaket);
        $data->whereNotIn('id_soal', $progresExam);
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
            ExamProgresModels::insert([
                'id_soal' => $request->soal_id,
                'id_siswa' => Auth::user()->id_siswa,
                'jawaban_dipilih' => $request->jawaban,
                'score' => 5
            ]);
            return response(array('keterangan' => $jawaban->rk, 'jawaban_benar' => $jawaban->kode_jawaban, 'status' => 'benar'), 200);
        }else{
            ExamProgresModels::insert([
                'id_soal' => $request->soal_id,
                'id_siswa' => Auth::user()->id_siswa,
                'jawaban_dipilih' => $request->jawaban,
                'score' => 0
            ]);
            return response(array('keterangan' => $jawaban->rk, 'jawaban_benar' => $jawaban->kode_jawaban, 'status' => 'salah'), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

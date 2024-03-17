<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoalModels;
use App\Models\BookingUserModels;
use App\Models\JawabanSoalModels;
use App\Models\ExamProgresModels;
use App\Models\DetailPaketBimbel;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // printJSON($soal);
        if($request->ajax() ){
            $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
            $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_jenis_tes')->toArray();
            $soal = SoalModels::join('m_pembelajaran as tx', 'tx.id_materi', 'm_soal.id_materi')
            ->leftJoin('exam_progres as tv', function($join) use($booking)
            {
                $join->on('m_soal.id_soal', '=', 'tv.id_soal')->where('id_siswa', '=' ,Auth::user()->id_siswa)->where('id_booking','=' ,$booking->id); 
    
            })
            ->leftjoin('m_jenis_tes as td', 'tx.id_jenis_tes', 'td.id_jenis_tes')
            ->select(DB::RAW('td.id_jenis_tes, td.jenis_tes, count( m_soal.id_soal ) AS total_soal, sum( IFNULL( tv.score, 0 )) score, count( tv.id_soal ) total_soal_dikerjakan, sum(IF(tv.score > 0 ,1,0)) soal_benar '))
            ->whereIn('tx.id_jenis_tes', $detailPaket)
            ->groupBy('tx.id_jenis_tes')
            ->get();
             return DataTables::of($soal)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                        $btn = '';
                        if ($row->total_soal == $row->total_soal_dikerjakan) {
                            $btn .= '  <button type="button" class="btn btn-success btn-sm">Sudah Selesai</button>';
                        }else {
                            $btn .= '  <a href="'. url('soal_exam/'.$row->id_jenis_tes) .'" data-id="'. $row->id_jenis_tes .'" class="edit btn btn-info btn-sm btn-edit">Kerjakan</a>';
                        }
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
        
        // printJSON($soal);
        
        return view('siswa.list_exam');
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
    
    public function exam($id_jenis_tes)
    {
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
        $soal = SoalModels::join('m_pembelajaran as tx', 'tx.id_materi', 'm_soal.id_materi')
        ->leftJoin('exam_progres as tv', function($join) use($booking)
        {
            $join->on('m_soal.id_soal', '=', 'tv.id_soal')->where('id_siswa', '=' ,Auth::user()->id_siswa)->where('id_booking','=' ,$booking->id); 

        })
        ->leftjoin('m_jenis_tes as td', 'tx.id_jenis_tes', 'td.id_jenis_tes')
        ->select(DB::RAW('td.id_jenis_tes, td.jenis_tes, count( m_soal.id_soal ) AS total_soal, sum( IFNULL( tv.score, 0 )) score, count( tv.id_soal ) total_soal_dikerjakan, sum(IF(tv.score > 0 ,1,0)) soal_benar '))
        ->where('tx.id_jenis_tes', $id_jenis_tes)
        ->groupBy('tx.id_jenis_tes')
        ->first();
        // printJSON($soal);
        
      return view('siswa.exam', compact('soal'));
    }

    public function soal_exam($id_jenis_tes)
    {
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
        $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_jenis_tes')->toArray();

        $data = SoalModels::join('m_pembelajaran as tx', 'tx.id_materi', 'm_soal.id_materi')
        ->leftJoin('exam_progres as tv', function($join) use($booking)
        {
            $join->on('m_soal.id_soal', '=', 'tv.id_soal')->where('id_siswa', '=' ,Auth::user()->id_siswa)->where('id_booking','=' ,$booking->id); 

        })
        ->leftjoin('m_jenis_tes as td', 'tx.id_jenis_tes', 'td.id_jenis_tes')
        ->select(DB::RAW('m_soal.id_soal,m_soal.pertanyaan, m_soal.file_tambahan,tx.id_jenis_tes'))
        ->where('tx.id_jenis_tes', $id_jenis_tes)
        ->whereNull('tv.id_soal')
        ->inRandomOrder()->limit(1)->get();

        $soaldikerjakan = ExamProgresModels::where('id_jenis_tes', $id_jenis_tes)->where('id_siswa', '=' ,Auth::user()->id_siswa)->where('id_booking','=' ,$booking->id)->select('score')->get();
        

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
        
        if(!empty($exc)) return response(array('total_data' => count($exc), 'message' => 'data ditemukan', 'data' => $exc,'selesai_dikerjakan' => $soaldikerjakan), 200);
        return response(array('total_data' => count($exc), 'message' => 'data tidak ditemukan', 'data' => $exc,'selesai_dikerjakan' => $soaldikerjakan), 200);
    }

    public function jawaban_soal(Request $request)
    {
        $jawaban = JawabanSoalModels::where('id_soal', $request->soal_id)->where('is_true', 1)->first();
        $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
        
        if($jawaban->kode_jawaban == $request->jawaban ){
            ExamProgresModels::insert([
                'id_soal' => $request->soal_id,
                'id_siswa' => Auth::user()->id_siswa,
                'jawaban_dipilih' => $request->jawaban,
                'id_jenis_tes' => $request->id_jenis_tes,
                'score' => 5,
                'id_booking' => $booking->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response(array('keterangan' => $jawaban->rk, 'jawaban_benar' => $jawaban->kode_jawaban, 'status' => 'benar'), 200);
        }else{
            ExamProgresModels::insert([
                'id_soal' => $request->soal_id,
                'id_siswa' => Auth::user()->id_siswa,
                'jawaban_dipilih' => $request->jawaban,
                'id_jenis_tes' => $request->id_jenis_tes,
                'score' => 0,
                'id_booking' => $booking->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
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

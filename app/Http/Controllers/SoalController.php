<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\MasterPaketModels;
use App\models\SoalModels;
use App\models\JawabanSoalModels;
use DB;
use Str;
use DataTables;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() ){
        $data = SoalModels::with('paketSoal')->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="'. url('edit/soal/'. $row->id_soal) .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
                       $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
                    }
                    return view('admin.soal.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paket = MasterPaketModels::all();
        return view('admin.soal.add',compact('paket'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $filename = '';
            if(!empty($request->file_tambahan_soal)){
                $file = $request->file('file_tambahan_soal');
                $filename = Str::slug($request->file_tambahan_soal) . '.' . $file->getClientOriginalExtension();
                $file->move('public/soal', $filename);    
            }
            SoalModels::insert([
                'pertanyaan' => $request->pertanyaan,
                'score' => $request->score,
                'id_paket' => $request->id_paket,
                'file_tambahan' => $filename,
                'id_kategori_soal' => isset($request->id_kategori_soal) ? $request->id_kategori_soal : 0
            ]);
            $id = DB::getPdo()->lastInsertId(); 
            foreach($request->kode_jawaban as $i => $k){

                $filename = '';
                if(!empty($request->file_tambahan[$i])){
                    $file = $request->file_tambahan[$i];
                    $filename = Str::slug($request->file_tambahan_soal) . '.' . $file->getClientOriginalExtension();
                    $file->move('public/jawaban', $filename);    
                }

                JawabanSoalModels::insert([
                    'kode_jawaban' => $k,
                    'id_soal' => $id,
                    'keterangan' => $request->keterangan[$i],
                    'is_true' => isset($request->is_true[$i]) ? 1 : 0,
                    'file_tambahan' => $filename,
                ]);


            }
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    function printJSON($v){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        echo json_encode($v, JSON_PRETTY_PRINT);
        exit;
    }


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
        $soal =SoalModels::with('paketSoal')->where('id_soal', $id)->first();
        $jawab = JawabanSoalModels::where('id_soal', $id)->get();
        $paket = MasterPaketModels::all();
        
        return view('admin.soal.edit',compact('paket','soal','jawab'));

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

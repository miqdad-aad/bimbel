<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPaketModels;
use App\Models\SoalModels;
use App\Models\JawabanSoalModels;
use App\Models\Pembelajaran;
use DB;
use Str;
use Auth;
use Yajra\DataTables\Facades\DataTables;

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
            $data = SoalModels::with('paketSoal');
            if(!empty($request->id_materi)){
                $data->where('id_materi', $request->id_materi);
            }
            if(!empty($request->materi)){
                $pembelajaran = Pembelajaran::where('slug', $request->materi)->first();
                $data->where('id_materi', $pembelajaran->id_materi);
            }
            $data->get();
            $data = $data->get();

             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                        $btn = '';
                        if(Auth::user()->role != 3){
                            $btn = '  <a href="'. url('edit/soal/'. $row->id_soal) .'" class="edit btn btn-info btn-sm ">Edit</a>';
                            $btn .= '  <a href="'. url('detail/soal/'. $row->id_soal) .'" class="detail btn btn-secondary btn-sm ">Detail</a>';
                            $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
                        }
   
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
    public function create(Request $request)
    {
        $id_materi = $request->id_materi;
        $paket = MasterPaketModels::all();
        return view('admin.soal.add',compact('paket','id_materi'));
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
            
            $pembelajaran = Pembelajaran::where('slug', $request->materi)->first();
            
            
            $filename = '';
            if(!empty($request->file_tambahan_soal)){
                $file = $request->file('file_tambahan_soal');
                $filename = Str::slug($request->file_tambahan_soal) . '.' . $file->getClientOriginalExtension();
                $file->move('public/soal', $filename);    
            }
            SoalModels::insert([
                'penjelasan' => $request->penjelasan,
                'pertanyaan' => $request->pertanyaan,
                'score' => $request->score,
                'id_paket' => $request->id_paket,
                'id_materi' => $request->id_materi,
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
                    'is_true' => $request->is_true[$i],
                    'file_tambahan' => $filename,
                ]);


            }
            DB::commit();
            return redirect('soal?id_materi='. $request->id_materi);
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back();
        }
       
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
        $soal =SoalModels::with('paketSoal')->where('id_soal', $id)->first();
        $jawab = JawabanSoalModels::where('id_soal', $id)->get();
        $paket = MasterPaketModels::all();
        $pembelajaran = Pembelajaran::where('id_materi', $soal->id_materi)->first();

        
        
        return view('admin.soal.edit',compact('paket','soal','jawab','pembelajaran'));

    }
    public function detail($id)
    {
        $soal =SoalModels::with('paketSoal')->where('id_soal', $id)->first();
        $jawab = JawabanSoalModels::where('id_soal', $id)->get();
        $paket = MasterPaketModels::all();
        $pembelajaran = Pembelajaran::where('id_materi', $soal->id_materi)->first();

        
        
        return view('admin.soal.detail',compact('paket','soal','jawab','pembelajaran'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        DB::beginTransaction();
        try {
            $data = SoalModels::where('id_soal', $request->id_soal)->first();
            $filename = '';
            if($request->file('file_tambahan_soal') == ""){
                $filename=$data->file_tambahan;
            }else{
                $file = $request->file('file_tambahan_soal');
                $filename = Str::slug($request->file_tambahan_soal) . '.' . $file->getClientOriginalExtension();
                $file->move('public/soal', $filename);    
            }
            // dd($filename);
            $pembelajaran = Pembelajaran::where('slug', $request->materi)->first();
            SoalModels::where('id_soal', $request->id_soal)->update([
                'penjelasan' => $request->penjelasan,
                'pertanyaan' => $request->pertanyaan,
                'score' => $request->score,
                'id_paket' => $request->id_paket,
                'id_materi' => $request->id_materi,
                'file_tambahan' => $filename,
                'id_kategori_soal' => isset($request->id_kategori_soal) ? $request->id_kategori_soal : 0
            ]);
            JawabanSoalModels::where('id_soal', $request->id_soal)->delete();
            foreach($request->kode_jawaban as $i => $k){
                $filename = isset($request->old_file[$i]) ? $request->old_file[$i] : '';
                if(!empty($request->file_tambahan[$i])){
                    $file = $request->file_tambahan[$i];
                    $filename = Str::slug($request->file_tambahan_soal) . '.' . $file->getClientOriginalExtension();
                    $file->move('public/jawaban', $filename);    
                }

                JawabanSoalModels::insert([
                    'kode_jawaban' => $k,
                    'id_soal' => $request->id_soal,
                    'keterangan' => $request->keterangan[$i],
                    'is_true' => $request->is_true[$i],
                    'file_tambahan' => $filename,
                ]);


            }
            DB::commit();
            return redirect('soal?id_materi='. $request->id_materi);
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back();
        }
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

    
    public function downloadTemplateSoal(){
        $file="template/template_soal.xlsx";
        return response()->download(public_path($file));
    }
}

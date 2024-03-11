<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisTesModels;
use App\Models\MateriTesModels;
use App\Models\BabTesModels;
use Yajra\DataTables\Facades\DataTables;
use DB;

class JenisTesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() ){
            $data = JenisTesModels::all();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_kategori_soal .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterJenisTes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            JenisTesModels::create([
                'jenis_tes' => $request->jenis_tes,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
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
        // dd($request);
        DB::beginTransaction();
        try {
            JenisTesModels::where('id_jenis_tes', $request->id_jenis_tes)->update([
                'jenis_tes' => $request->jenis_tes,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
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

    public function getJenisTes(Request $request)
    {
        // dd($request);
        $input = $request->all();
        if ($request->term) {
            $data = JenisTesModels::select(["id_jenis_tes", "jenis_tes"])
                ->where('jenis_tes', 'like', '%'. $request->term. '%')
                ->get();
        } else {
            $data = JenisTesModels::select("*")
            ->get();
        }
        // dd($data);
       return response()->json($data, 200);
       
    }

    public function getMateriTes(Request $request){
        // dd($request);
        $input = $request->all();
        if ($request->term) {
            $data = MateriTesModels::select(["id_materi_tes", "kode_materi_tes", "nama_materi_tes"])
                ->where('nama_materi_tes', 'like', '%'. $request->term. '%')
                ->Orwhere('kode_materi_tes', 'like', '%'. $request->term. '%')
                ->where('id_jenis_tes', $request->id)
                ->get();
                // dd($data);
        } else {
            $data = MateriTesModels::select("*")
            ->where('id_jenis_tes', $request->id)
            ->get();
        }
        return response()->json($data, 200);
    }

    public function getBabTes(Request $request)
    {
        // dd($request->term);
        if ($request->term) {
            $data = BabTesModels::select(["id_bab_tes", "bab"])
            ->where('bab', 'like', '%'. $request->term. '%')
            ->where('id_materi_tes', $request->id)
            ->get();
            // dd($data);
        } else {
            $data = BabTesModels::select("*")
            ->where('id_materi_tes', $request->id)
            ->get();
        }
        return response()->json($data, 200);
    }
}

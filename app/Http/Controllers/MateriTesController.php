<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriTesModels;
use App\Models\JenisTesModels;
use Yajra\DataTables\Facades\DataTables;
use DB;

class MateriTesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $materi = JenisTesModels::all();
        if($request->ajax() ){
            $data = MateriTesModels::leftjoin('m_jenis_tes as a','a.id_jenis_tes','m_materi_tes.id_jenis_tes')->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_kategori_soal .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterMateriTes', compact('materi'));
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
            MateriTesModels::create([
                'kode_materi_tes' => $request->kode_materi_tes,
                'nama_materi_tes' => $request->materi_tes,
                'id_jenis_tes' => $request->id_jenis_tes,
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
        //
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
    //    dd($request);
        DB::beginTransaction();
        try {
            $jenis_tes = MateriTesModels::where('id_materi_tes', $request->id_materi_tes)->first();
            if ($request->id_jenis_tes == '') {
                $id_jenis_tes = $jenis_tes->id_jenis_tes;
            }else {
                $id_jenis_tes = $request->id_jenis_tes;
            }
            // dd($id_jenis_tes);
            MateriTesModels::where('id_materi_tes', $request->id_materi_tes)->update([
                'kode_materi_tes' => $request->kode_materi_tes,
                'nama_materi_tes' => $request->materi_tes,
                'id_jenis_tes' => $id_jenis_tes,
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
}

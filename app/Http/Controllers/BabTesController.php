<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriTesModels;
use App\Models\JenisTesModels;
use App\Models\BabTesModels;
use DataTables;
use DB;

class BabTesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $materi = MateriTesModels::all();
        if($request->ajax() ){
            $data = BabTesModels::leftjoin('m_materi_tes as a', 'a.id_materi_tes', 'm_bab_tes.id_materi_tes')->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_kategori_soal .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterBabTes', compact('materi'));
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
            BabTesModels::create([
                'id_materi_tes' => $request->id_materi_tes,
                'bab' => $request->nama_bab,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
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
        // dd($request);
        DB::beginTransaction();
        try {
            $materi_tes = BabTesModels::where('id_bab_tes', $request->bab_tes_id)->first();
            if ($request->id_materi_tes == '') {
                $id_materi_tes = $materi_tes->id_materi_tes;
            }else {
                $id_materi_tes = $request->id_materi_tes;
            }
            BabTesModels::where('id_bab_tes', $request->bab_tes_id)->update([
                'bab' => $request->bab,
                'id_materi_tes' => $id_materi_tes,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            dd($e->getMessage());
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

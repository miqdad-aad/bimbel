<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPaketModels;
use App\Models\KategoriSoalModels;
use App\Models\PaketBimbelModels;
use App\Models\DetailPaketBimbel;
use DataTables;
use DB;

class PaketBimbelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax() ){
            $data = PaketBimbelModels::all();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_kategori_soal .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterPaketBimbel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $kategori = KategoriSoalModels::all();
       return view('admin.master.addMasterPaket', compact('kategori'));
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
            $paket = PaketBimbelModels::insert([
                'nama_paket_bimbel' => $request->nama_paket,
                'deskripsi_paket' => $request->deskripsi_paket,
                'harga_paket_bimbel' => $request->harga,
                'kuota_peserta' => $request->kuota,
                'status_aktif' => 1,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);
            $id = DB::getPdo()->lastInsertId(); 
            for ($i=0; $i < count($request->id_kategori_soal) ; $i++) { 
                
                DetailPaketBimbel::insert([
                    'id_paket_bimbel' => $id,
                    'id_materi' => $request->id_kategori_soal[$i],
                ]); 
            }
            DB::commit();
            return redirect('homeAdmin');
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

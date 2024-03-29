<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPaketModels;
use App\Models\MateriTesModels;
use App\Models\KategoriSoalModels;
use App\Models\PaketBimbelModels;
use App\Models\DetailPaketBimbel;
use App\Models\JenisTesModels;
use App\Models\Pembelajaran;
use Yajra\DataTables\Facades\DataTables;
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
                        $btn = '  <a href="'. url('editPaketBimbel/'. $row->id_paket_bimbel) .'" class="edit btn btn-info btn-sm">Edit</a>';
   
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
        
        $materi_tes = JenisTesModels::all();
       return view('admin.master.addMasterPaket', compact('materi_tes'));
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
            for ($i=0; $i < count($request->id_materi_tes) ; $i++) { 
                
                DetailPaketBimbel::insert([
                    'id_paket_bimbel' => $id,
                    'id_jenis_tes' => $request->id_materi_tes[$i],
                ]); 
            }
            // dd($id);
            DB::commit();
            return redirect('paketBimbel');
        } catch (\Exception $e) {
            DB::rollback(); 
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
        // dd($id);
        $data = PaketBimbelModels::with('detailPaket')->where('id_paket_bimbel', $id)->first();
        $detail = DB::table('detail_paket_bimbel as a')
        ->leftjoin('m_jenis_tes as b', 'a.id_jenis_tes', 'b.id_jenis_tes')
        ->where('a.id_paket_bimbel', $id)
        ->get();
        // dd($detail);
        $materi_tes = JenisTesModels::all();
        // printJSON($materi_tes);
        return view('admin.master.editMasterPaketBimbel', compact('data', 'detail', 'materi_tes'));
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
            PaketBimbelModels::where('id_paket_bimbel', $request->id_paket_bimbel)->update([
                'nama_paket_bimbel' => $request->nama_paket,
                'deskripsi_paket' => $request->deskripsi_paket,
                'harga_paket_bimbel' => $request->harga,
                'kuota_peserta' => $request->kuota,
                'status_aktif' => 1,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);
            DetailPaketBimbel::where('id_paket_bimbel', $request->id_paket_bimbel)->delete();

            for ($i=0; $i < count($request->id_materi_tes) ; $i++) { 
                
                DetailPaketBimbel::insert([
                    'id_paket_bimbel' => $request->id_paket_bimbel,
                    'id_jenis_tes' => $request->id_materi_tes[$i],
                ]); 
            }
            DB::commit();
            return redirect('paketBimbel');
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

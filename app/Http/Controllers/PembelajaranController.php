<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPaketModels;
use App\Models\KategoriSoalModels;
use App\Models\Pembelajaran;
use DB;
use Str;
use DataTables;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->Pembelajaran = new Pembelajaran();
    }

    public function index(Request $request)
    {
        $data = Pembelajaran::with(['paketSoal','kategoriSoal'])->get();
        // $this->printJSON($data);
        if($request->ajax() ){
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="'. url('pembelajaran/edit/'. $row->id_materi) .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
                       $btn .= ' <a target="_blank" href="'. url('soal?id_materi='.$row->id_materi) .'" class=" btn btn-success btn-sm ">Manajemen Soal</a>';
                       $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
   
                        return $btn;
                     })
                     ->addColumn('totalSoal', function($row){
                        $total = count($row->paketSoal);
   
                        return $total;
                     })
                     ->rawColumns(['action','totalSoal'])
                     ->make(true);
                    }
                    return view('admin.pembelajaran.view');
    }

    function printJSON($v){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        echo json_encode($v, JSON_PRETTY_PRINT);
        exit;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paket = KategoriSoalModels::all();
        return view('admin.pembelajaran.create', compact('paket'));
    }
    public function edit($id)
    {
        $data = Pembelajaran::with(['paketSoal','kategoriSoal'])->where('id_materi', $id)->first();
        $paket = KategoriSoalModels::all();
        return view('admin.pembelajaran.create', compact('paket','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->Pembelajaran->addPembelajaran($request);

        if ($result)  return redirect('pembelajaran');
        
        return redirect('pembelajaran');
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

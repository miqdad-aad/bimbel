<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\SekolahKedinasanModels;
use DataTables;
use DB;

class SekolahKedinasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->SekolahKedinasanModels = new SekolahKedinasanModels();
    }

    public function index(Request $request)
    {
        if($request->ajax() ){
            $data = SekolahKedinasanModels::all();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_sekolah_kedinasan .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
                       $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
                       $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-tambah">Tambah Foto</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterSekolahKedinasan');
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
        $result = $this->SekolahKedinasanModels->addSekolahKedinasan($request);

        if ($result == true) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 400]);
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
        $result = $this->SekolahKedinasanModels->updateSekolahKedinasan($request);

        if ($result == true) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 400]);
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
        SekolahKedinasanModels::where('id_sekolah_kedinasan',$id)->delete();
        return response()->json(['status' => 200]);
    }
}

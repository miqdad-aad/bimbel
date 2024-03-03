<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterOrganisasiModels;
use DB;
use Str;

class MasterOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = MasterOrganisasiModels::first();
        return view('admin.master.masterStrukturOrganisasi', compact('data'));
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

            MasterOrganisasiModels::truncate();
            if(!empty($request->file_struktur)){
                $file = $request->file('file_struktur');
                $filename =  rand(10,100).'_foto_struktur_' . $file->getClientOriginalExtension();
                $file->move('struktur_organisasi', $filename);

                $data = MasterOrganisasiModels::create([
                    'file_struktur' => $filename,
                ]);
            }

            DB::commit();
            return redirect()->back();
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

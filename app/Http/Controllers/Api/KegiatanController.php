<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanModels;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function kegiatan(Request $request)
    {
        $data = KegiatanModels::all();
        // dd($data);
        $datas = [];
        if (!$data) {
            $code = 400;
            $data = array(
                'status' => false,
                'message' => 'Data Kegiatan Tidak ditemukan',
                'data' => '',
            );
        } else {
            foreach ($data as $key => $value) {
                // dd($value);
                $arrays = array(
                    'id_kegiatan' => $value->id_kegiatan,
                    'nama_kegiatan' => $value->nama_kegiatan,
                    'deskripsi' => $value->deskripsi,
                    'gambar' => $value->gambar,
                );
                array_push( $datas, $arrays);
            }
            $code = 200;
            $data = array(
                'status' => true,
                'message' => 'Data Kegiatan ditemukan',
                'data' => $datas,
            );
        }
        return response($data, $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

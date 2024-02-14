<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorModels;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mentor()
    {
        $data = MentorModels::all();
        $datas = [];
        if (!$data) {
            $code = 400;
            $data = array(
                'status' => false,
                'message' => 'Data Mentor Tidak ditemukan',
                'data' => '',
            );
        } else {
            foreach ($data as $key => $value) {
                // dd($value);
                $arrays = array(
                    'id_mentor' => $value->id_mentor,
                    'nama_mentor' => $value->nama_mentor,
                    'jabatan' => $value->jabatan,
                    'deskripsi' => $value->deskripsi,
                    'gambar' => $value->gambar,
                );
                array_push( $datas, $arrays);
            }
            $code = 200;
            $data = array(
                'status' => true,
                'message' => 'Data Mentor ditemukan',
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

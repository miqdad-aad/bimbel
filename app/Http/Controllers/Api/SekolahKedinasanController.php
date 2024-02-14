<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SekolahKedinasanModels;
use DB;

class SekolahKedinasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sekolahKedinasanApi(Request $request)
    {
        $data = SekolahKedinasanModels::get();
        // dd($data);
        $datas = [];
        if (!$data) {
            $code = 400;
            $data = array(
                'status' => false,
                'message' => 'Data Sekolah Kedinasan Tidak ditemukan',
                'data' => '',
            );
        } else {
            foreach ($data as $key => $value) {
                
                $arrays = array(
                    'id_sekolah_kedinasan' => $value->id_sekolah_kedinasan,
                    'nama_sekolah_kedinasan' => $value->nama_sekolah_kedinasan,
                );
                $detailSekolah = DB::table('m_detail_sekolah_kedinasan')->where('id_sekolah_kedinasan', $value->id_sekolah_kedinasan)->first();
                $sekolahDetail = array(
                    'detailSekolah' => $detailSekolah,
                );
                array_push( $datas, $arrays, $sekolahDetail);
                
            }
            $code = 200;
            $data = array(
                'status' => true,
                'message' => 'Data Sekolah Kedinasan ditemukan',
                'data' => $datas,
                'detail' => $sekolahDetail,
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
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}

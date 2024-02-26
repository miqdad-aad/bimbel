<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingUserModels;
use Illuminate\Support\Facades\File;
use App\Models\PaketBimbelModels;
use Illuminate\Support\Facades\Validator;
use Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'asal_sekolah'      => 'required',
            'id_paket'      => 'required',
            'jenis_pembayaran'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $paket = PaketBimbelModels::where('id_paket_bimbel', $request->id_paket)->first();

        if($request->file('file_manual') == ""){
            $filename= "";
        }else{
            $file = $request->file('file_manual');
            $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/public/user', $fileName);
        }
        // dd($filename);
        $booking = BookingUserModels::create([
            'nama'      => $request->nama,
            'asal_sekolah'      => $request->asal_sekolah,
            'id_paket'      => $request->id_paket,
            'harga'      => $paket->harga_paket_bimbel,
            'status_pembayaran'      => $request->status_pembayaran,
            'jenis_pembayaran'      => $request->jenis_pembayaran,
            'file'      => $filename,
        ]);

        if($booking) {
            return response()->json([
                'success' => true,
                'user'    => $booking,  
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
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

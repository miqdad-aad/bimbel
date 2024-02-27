<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaModels;
use App\Models\BookingUserModels;
use DB;
use Str;
use Xendit\Xendit;


class BookingController extends Controller
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
        DB::beginTransaction();
        try {
            $file = $request->file('path');
            $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move('foto_siswa', $filename);

            $data = SiswaModels::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'id_paket' => $request->id_paket,
                'asal_sekolah' => $request->asal_sekolah, 
                'foto' => $filename,
            ]);
            Xendit::setApiKey("xnd_development_D12sBLrCReY5IqRMRYYbWmbYIvOXifF8JBMldH46g4GOBkbWkv0N4Qk5IaW38n");

            // Contoh pembuatan invoice
            $invoice = \Xendit\Invoice::create([
                'external_id' => 'invoice-' . time(),
                'amount' => $request->input('amount'),
                'payer_email' => $request->input('email'),
                // Tambahkan parameter lain sesuai kebutuhan
            ]);


            DB::commit();
            return true;
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

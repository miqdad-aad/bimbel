<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaModels;
use App\Models\BookingUserModels;
use App\Models\PaketBimbelModels;
use DB;
use File;
use Str; 
use Http;
use Hash;

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
            $filename = '';
            if(!empty($request->path)){
                $file = $request->file('path');
                $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                $file->move('foto_siswa', $filename);

            }
            $paket = PaketBimbelModels::where('id_paket_bimbel', $request->id_paket)->first();

            $data = SiswaModels::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'asal_sekolah' => $request->asal_sekolah, 
                'foto' => $filename,
            ]);

            


            $secret_key = 'Basic '.config('xendit.key_auth');
            
            $idBooking = uniqid();
            
            $payment_link = '';
            $payment_status = '';
            $foto_pembayaran = '';

            if($request->jenis_pembayaran == 'ONLINE'){
                $data_request = Http::withHeaders([
                'Authorization' => $secret_key
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => $idBooking,
                    // 'customer_id' => $customerId,
                    'amount' => 1000,
                    'payer_email' => $request->email,
                    'description' => 'Booking Menu ' . $paket->nama_paket_bimbel,
                    'items' => [
                        [
                            'id' => rand(10,100),
                            'name' => $paket->nama_paket_bimbel,
                            'price' =>$paket->harga_paket_bimbel,
                            'type' => 'none', 
                            'quantity' => 1
                        ], 
                    ],
                ]);
                $response = $data_request->object();  
                // printJSON($response);
                
                if(empty($response->status)){
                    return array('status' => 'error');
                }else{
                    $payment_link = $response->invoice_url;
                    $payment_status = $response->status;
                }

            }else{

                if(!empty($request->foto_pembayaran)){
                    $file = $request->file('foto_pembayaran');
                    $foto_pembayaran = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                    $file->move('bukti_bayar', $foto_pembayaran);
    
                }
                $payment_status = 'PENDING';

            }
            
            BookingUserModels::insert([
                'id_siswa' => $data->id,
                'kode_booking' => $idBooking,
                'harga' => $paket->harga_paket_bimbel,
                'id_paket' => $request->id_paket,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'status_pembayaran' => $payment_status,
                'link_pembayaran' => $payment_link,
                'foto_pembayaran' => $foto_pembayaran,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);


            DB::commit();
            return response(array('link_payment' => $payment_link, 'message' => 'berhasil'), 200);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response(array('link_payment' => '', 'message' => 'gagal', 'noted' => $e->getMessage()), 400);
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

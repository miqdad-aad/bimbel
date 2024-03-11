<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingUserModels;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Auth;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->ajax() ){
            $data = BookingUserModels::with(['siswa_booking','paket_booking'])->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('status_approve', function($row){
                        if($row->approved == 0){
                            return '<span class="badge badge-secondary">Menunggu Persetujuan</span>';
                        } 
                        return '<span class="badge badge-success">Disetujui</span>';
                     })
                     ->addColumn('action', function($row){
                        $btn = '';
                        if($row->approved == 0){
                       $btn .= '  <a href="javascript:void(0)" data-id="'. $row->id .'" class="edit btn btn-info btn-sm btn-edit-status">Update Status</a>';
                       $btn .= '  <a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-success btn-sm btn-approve" status-approve="1">Approve</a>';
                       $btn .= '  <a href="'. url('detailBookingUser/'. $row->id) .'" class="btn btn-primary btn-sm btn-detail">Detail</a>';
                        }else{
                            $btn .= '  <a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-danger  btn-sm btn-approve" status-approve="0">Unapprove</a>';

                        }
   
                        return $btn;
                     })
                     ->rawColumns(['action','status_approve'])
                     ->make(true);
           }
        return view('admin.booking.index');
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
        // dd($id);
        $data = BookingUserModels::with(['siswa_booking','paket_booking'])->where('id', $id)->first();
        // printJSON($data);
        return view('admin.booking.detail', compact('data'));
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
        // dd($request);
        DB::beginTransaction();
        try {
            BookingUserModels::where('id', $request->booking_id)->update([
                'status_pembayaran' => $request->status_pembayaran,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back();
        }
    }
    public function flagApprove(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $booking = BookingUserModels::with('siswa_booking')->where('id', $request->booking_id)->first();
            // printJSON($booking->siswa_booking->foto);
            if($request->approve == 1){
                

                User::create([
                    'username' => $booking->siswa_booking->username,
                    'password' => $booking->siswa_booking->password,
                    'name' => $booking->siswa_booking->nama,
                    'email' => $booking->siswa_booking->email,
                    'password' => $booking->siswa_booking->password,
                    'foto_profil' => $booking->siswa_booking->foto,
                    'id_siswa' => $booking->siswa_booking->id_siswa,
                    'role' => 3,
                    'is_active' => 1,
                ]);

            }
            if($request->approve == 0){
                User::where('id_siswa', $booking->siswa_booking->id_siswa)->delete();

            }
            BookingUserModels::where('id', $request->booking_id)->update([
                'approved' => $request->approve,
            ]);
            DB::commit();
            return response()->json(['status' => 200]);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class kategoriSoalController extends Controller
{
    public function masterKategoriSoal(Request $request)
    {
        if($request->ajax() ){
           
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                      $btn = '  <a href="'. url('listDetailAbsen', $row->employee_id) .'" class="edit btn btn-info btn-sm">Detail</a>';
  
                       return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
          }
          return view('admin.master.masterKategoriSoal');
    }
}

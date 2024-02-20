<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorModels;
use App\Models\User;
use DataTables;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->MentorModels = new MentorModels();
    }

    public function index(Request $request)
    {
        if($request->ajax() ){
            $data = MentorModels::leftjoin('users as a', 'a.id_user', 'm_mentor.id_mentor')->where('role', 2)->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                       $btn = '  <a href="javascript:void(0)" data-id="'. $row->id_mentor .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
                       $btn .= '  <a href="javascript:void(0)" data-id="'. $row->id .'" class="edit btn btn-success btn-sm btn-active">aktifkan</a>';
                       $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
           return view('admin.master.masterMentor');
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
        $result = $this->MentorModels->addMentor($request);

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
        $result = $this->MentorModels->updateMentor($request);

        if ($result == true) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 400]);
        }
    }

    public function updateStatusMentor(Request $request)
    {
        User::where('id', $request->id)->update([
            'is_active' => $request->is_active,
        ]);

        return response()->json(['status' => 200]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MentorModels::where('id_mentor',$id)->delete();
        return response()->json(['status' => 200]);
    }
}

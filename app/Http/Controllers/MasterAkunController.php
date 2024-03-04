<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Str;
use Auth;
use Hash;

class MasterAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($data);
        if($request->ajax() ){
            $data = User::all();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                        $btn = '  <a href="'. url('editAkun/'. $row->id) .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
   
                        return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
           }
        return view('admin.akun.index');
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
        $data = User::where('id',$id)->firstOrFail();
        // dd($data);
        return view('admin.akun.edit', compact('data'));
    }

    public function editProfile($id)
    {
        // dd($id);
        $data = User::where('id',$id)->firstOrFail();
        // dd($data);
        return view('siswa.editProfile', compact('data'));
    }

    public function updateProfile(Request $request)
    {
            // dd($request);
            $old_password = $request->password_lama;
            $new_password = $request->password_baru;
            if (!empty($request->password_baru)) {
                if ($old_password == $new_password) {
                    return back()->with("error","Old Password and New Password don't be same");
                } else {
                    $user = User::where('id', $request->userId)->first();
                    if ($user) {
                        if (! Hash::check($old_password, $user->password)) {
                            return back()->with('error','Old Password is wrong.');
                        } else {
                            DB::beginTransaction();
                            try {
                                $user = User::where('id', $request->userId)->first();
                                if($request->file('foto_profil') == ""){
                                    $filename=$user->foto_profil;
                                }else{
                                    $file = $request->file('foto_profil');
                                    $filename = rand(10,100).Str::slug($user->name) . '.' . $file->getClientOriginalExtension();
                                    $file->move(public_path().'/foto_siswa', $filename);
                                }
                                // dd($filename);
                                DB::table('users')->where('id', $request->userId)->update([
                                    'password' =>  Hash::make($request['password_baru']),
                                    'foto_profil' =>  $filename,
                                ]);
    
                                DB::commit();
                                return redirect()->back()->with('success','Password have been change');
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }
                        }
                        
                    } else {
                        return back()->with('error','Username or Password not found !');
                    }
                    
                }
            } else {
                
                DB::beginTransaction();
                    try {
                        $user = User::where('id', $request->userId)->first();
                        if($request->file('foto_profil') == ""){
                            $filename=$user->foto_profil;
                        }else{
                            $file = $request->file('foto_profil');
                            $filename = rand(10,100).Str::slug($user->name) . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path().'/foto_siswa', $filename);
                        }
                        // dd($filename);

                        DB::table('users')->where('id', $request->userId)->update([
                            'password' =>  $user->password,
                            'foto_profil' =>  $filename,
                        ]);
                        DB::commit();
                        return redirect()->back()->with('success','Change Success');
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                # code...
            }
            
            

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
            $user = User::where('id', $request->id_user)->first();
            if (!empty($request->password)) {
                $password = Hash::make($request['password']);
            } else {
                $password = $user->password;
            }

            User::where('id', $request->id_user)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $password,
            ]);

            DB::commit();
            return redirect('listAkun');
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back();
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Auth;

class AuthController extends Controller
{
    public function registerMentor(Request $request)
    {
        return view('auth.registerMentor');
    }

    public function registerMentorStore(Request $request)
    {
        // dd($request);
        $validate = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        $totalName = DB::table('users')
        ->whereRaw("UPPER(name) = '".strtoupper($request->name) ."'  ")
        ->count();
        $totalUsername = DB::table('users')
        ->whereRaw("UPPER(username) = '".strtoupper($request->username) ."'  ")
        ->count();
        $totalEmail = DB::table('users')
        ->whereRaw("UPPER(email) = '".strtoupper($request->email) ."'  ")
        ->count();
        if ($totalName == 1) {
            $pesan = "name";
        } else if( $totalUsername == 1 ) {
            $pesan = "username";
        }else if($totalEmail == 1){
            $pesan = "email";
        }else{
            $pesan = "yes";

        }
        if ($pesan == "yes") {
            User::create([
                'username' => $request['username'],
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' => 2,
            ]);

            return view('auth.login');
        }else {
            return view('auth.registerMentor');
        }
    }

    public function login(Request $request)
    {
        
        return view('auth.login');
    }

    public function loginStore(Request $request)
    {
        $login = $request->input('email');
        $user = User::where('email', $login)->orWhere('username', $login)->first();
    
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Invalid login credentials']);
        }
    
        $request->validate([
            'password' => 'required|min:8',
        ]);
    
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password]) ||
            Auth::attempt(['username' => $user->username, 'password' => $request->password])) {
            Auth::loginUsingId($user->id);
            return redirect('/')->with('success', 'Login Sukses');
        } else {
            return back()->withInput($request->only('email', 'remember'))->with(['warning' => 'Login Gagal']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function registerSiswa(Request $request)
    {
        return view('auth.registerSiswa');
    }

    public function registerSiswaStore(Request $request)
    {
        // dd($request);
        $validate = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        $totalName = DB::table('users')
        ->where('role', 3)
        ->whereRaw("UPPER(name) = '".strtoupper($request->name) ."'  ")
        ->count();
        $totalUsername = DB::table('users')
        ->where('role', 3)
        ->whereRaw("UPPER(username) = '".strtoupper($request->username) ."'  ")
        ->count();
        $totalEmail = DB::table('users')
        ->where('role', 3)
        ->whereRaw("UPPER(email) = '".strtoupper($request->email) ."'  ")
        ->count();
        if ($totalName == 1) {
            $pesan = "name";
        } else if( $totalUsername == 1 ) {
            $pesan = "username";
        }else if($totalEmail == 1){
            $pesan = "email";
        }else{
            $pesan = "yes";

        }
        if ($pesan == "yes") {
            User::create([
                'username' => $request['username'],
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' => 3,
            ]);

            return view('auth.login');
        }else {
            return redirect()->back();
        }
    }

}

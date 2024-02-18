<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Str;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class MentorModels extends Model
{
    use HasFactory;
    protected $table ="m_mentor";
    protected $guarded = ['id'];
    protected $appends = ['url_gambar'];

    public function addMentor($request)
    {
        DB::beginTransaction();
        try {
            // dd($request);
            $file = $request->file('gambar');
            $filename = Str::slug($request->nama_mentor) . '.' . $file->getClientOriginalExtension();
            $file->move('public/mentor', $filename);

            $data = MentorModels::create([
                'nama_mentor' => $request->nama_mentor,
                'jabatan'=> $request->jabatan,
                'deskripsi'=> $request->deskripsi,
                'gambar'=> $filename,
            ]);

            User::create([
                "name" => $request->name,
                "username" => $request->username,
                "email" => $request->email,
                "password"=> Hash::make($request->password),
                "role" => 2,
                "is_active" => 1,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateMentor($request)
    {
        DB::beginTransaction();
        try {
            // dd($request);
            $data = MentorModels::where('id_mentor', $request->id_mentor)->first();

            if($request->file('featured_img') == ""){
                $filename=$data->gambar;
            }else{
                $file = $request->file('gambar1');
                $filename = Str::slug($request->nama_mentor) . '.' . $file->getClientOriginalExtension();
                $file->move('public/mentor', $filename);
            }
              MentorModels::where('id_mentor', $request->id_mentor)->update([
                'nama_mentor' => $request->nama_mentor,
                'jabatan'=> $request->jabatan,
                'deskripsi'=> $request->deskripsi,
                'gambar'=> $filename,
            ]);
            

            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getUrlGambarAttribute()
    {
        return asset('public/mentor/'. $this->gambar);

    }
}

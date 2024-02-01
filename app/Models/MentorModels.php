<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Str;
use Illuminate\Support\Facades\File;

class MentorModels extends Model
{
    use HasFactory;
    protected $table ="m_mentor";
    protected $guarded = ['id'];

    public function addMentor($request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('gambar');
            $filename = Str::slug($request->nama_mentor) . '.' . $file->getClientOriginalExtension();
            $file->move('public/mentor', $filename);

            $data = MentorModels::create([
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

    public function updateMentor($request)
    {
        DB::beginTransaction();
        try {
            $data = MentorModels::where('id_mentor', $request->id_mentor)->first();

            if($request->file('featured_img') == ""){
                $filename=$data->gambar;
            }else{
            }
            
                $file = $request->file('gambar');
                $filename = Str::slug($request->nama_mentor) . '.' . $file->getClientOriginalExtension();
                $file->move('public/mentor', $filename);
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
}

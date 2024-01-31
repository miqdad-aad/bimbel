<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Str;

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
            $file->move('public/banner', $filename);

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
}

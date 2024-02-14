<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Str;

class SekolahKedinasanModels extends Model
{
    use HasFactory;
    protected $table ="m_sekolah_kedinasan";
    protected $guarded = ['id'];

    public function addSekolahKedinasan($request)
    {
        DB::beginTransaction();
        try {

            $data = SekolahKedinasanModels::create([
                'nama_sekolah_kedinasan' => $request->nama_sekolah_kedinasan,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateSekolahKedinasan($request)
    {
        DB::beginTransaction();
        try {
            SekolahKedinasanModels::where('id_sekolah_kedinasan', $request->id_sekolah_kedinasan)->update([
                'nama_sekolah_kedinasan' => $request->nama_sekolah_kedinasan,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function addFotoSekolah($request)
    {
        DB::beginTransaction();
        try {
            $sekolah =  DB::table('m_detail_sekolah_kedinasan')->where('id_sekolah_kedinasan',$request->id_sekolah)->get();
            $total = $sekolah->count() + 1;
            // dd($total);
            $file = $request->file('gambar');
            $filename = Str::slug($request->id_sekolah) . '.' . $total . '.' .$file->getClientOriginalExtension();
            $file->move('public/fotosekolahkedinasan', $filename);

            $data = DB::table('m_detail_sekolah_kedinasan')->insert([
                'id_sekolah_kedinasan' => $request->id_sekolah,
                'gambar'=> $filename,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

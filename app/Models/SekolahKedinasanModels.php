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
}

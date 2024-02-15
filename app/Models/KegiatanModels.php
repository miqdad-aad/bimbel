<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Str;

class KegiatanModels extends Model
{
    use HasFactory;
    protected $table ="m_kegiatan";
    protected $guarded = ['id'];
    protected $appends = ['url_gambar'];

    public function addKegiatan($request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('gambar');
            $filename = Str::slug($request->nama_kegiatan) . '.' . $file->getClientOriginalExtension();
            $file->move('public/kegiatan', $filename);

            $data = KegiatanModels::create([
                'nama_kegiatan' => $request->nama_kegiatan,
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
        return asset('public/kegiatan/'. $this->gambar);

    }
}

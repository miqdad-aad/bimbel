<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SoalModels;
use App\Models\KategoriSoalModels;
use DB;
use Str;

class Pembelajaran extends Model
{
    use HasFactory;
    protected $table ="m_pembelajaran";
    protected $guarded = ['id_materi'];

    public function kategoriSoal()
    {
        return $this->belongsTo(KategoriSoalModels::class,'id_kategori_soal','id_kategori_soal');
    }

    public function paketSoal()
    {
        return $this->hasMany(SoalModels::class,'id_materi','id_materi');
    }


    public function jenis_tes()
    {
        return $this->belongsTo(JenisTesModels::class,'id_jenis_tes','id_jenis_tes');
    }
    
    public function bab_tes()
    {
        return $this->belongsTo(BabTesModels::class,'id_bab_tes','id_bab_tes');
    }

    public function materi_tes()
    {
        return $this->belongsTo(MateriTesModels::class,'id_materi_tes','id_materi_tes');
    }

    public function kategori_pembelajaran()
    {
        return $this->belongsTo(KategoriPembelajaranModels::class,'id_kategori_pembelajaran','id_kategori_pembelajaran');
    }

    
    public function addPembelajaran($request)
    {
        DB::beginTransaction();
        try {
           
            if(isset($request->id_materi)){
               $oldData = Pembelajaran::where('id_materi', $request->id_materi)->first();
               $filename = $oldData->gambar;
               if (!empty($request->file_tambahan_soal)) {
                   $file = $request->file('file_tambahan_soal');
                   $filename = 'Materi_'.rand(1000,9000) . '.' . $file->getClientOriginalExtension();
                   $file->move('public/pembelajaran', $filename);
               }
               
               Pembelajaran::where('id_materi', $request->id_materi)->update([
                    'judul_materi' => $request->judul_materi,
                    'slug' => \Str::slug($request->judul_materi),
                    'uraian_materi' => $request->uraian_materi,
                    'link_video' => $request->link_video,
                    'link_materi' => $request->link_materi, 
                    'id_kategori_pembelajaran' => $request->id_kategori_pembelajaran,
                    'gambar' => $filename,
                    'id_mentor' => $request->id_mentor,
                    'id_jenis_tes' => $request->id_jenis_tes,
                    'id_bab_tes' => $request->id_bab_tes,
                    'id_materi_tes' => $request->id_materi_tes,
                ]);

            }else{
                $filename = null;
                if (!empty($request->file_tambahan_soal)) {
                    $file = $request->file('file_tambahan_soal');
                    $filename = 'Materi_'.rand(1000,9000) . '.' . $file->getClientOriginalExtension();
                    $file->move('public/pembelajaran', $filename);
                }
    
                Pembelajaran::create([
                    'judul_materi' => $request->judul_materi,
                    'slug' => \Str::slug($request->judul_materi),
                    'uraian_materi' => $request->uraian_materi,
                    'link_video' => $request->link_video,
                    'link_materi' => $request->link_materi, 
                    'id_kategori_pembelajaran' => $request->id_kategori_pembelajaran,
                    'gambar' => $filename,
                    'id_mentor' => $request->id_mentor,
                    'id_jenis_tes' => $request->id_jenis_tes,
                    'id_bab_tes' => $request->id_bab_tes,
                    'id_materi_tes' => $request->id_materi_tes,
                ]);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    } 
}

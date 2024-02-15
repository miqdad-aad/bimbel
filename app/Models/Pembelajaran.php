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
                    'uraian_materi' => $request->uraian_materi,
                    'link_video' => $request->link_video,
                    'link_materi' => $request->link_materi,
                    'typeMateri' => $request->typeMateri,
                    'id_kategori_soal' => $request->id_soal,
                    'gambar' => $filename,
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
                    'uraian_materi' => $request->uraian_materi,
                    'link_video' => $request->link_video,
                    'link_materi' => $request->link_materi,
                    'typeMateri' => $request->typeMateri,
                    'id_kategori_soal' => $request->id_soal,
                    'gambar' => $filename,
                ]);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

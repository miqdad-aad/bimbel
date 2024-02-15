<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Pembelajaran;

class KategoriSoalModels extends Model
{
    use HasFactory;
    protected $table ="m_kategori_soal";
    protected $guarded = ['id_kategori_soal'];

    public function materi()
    {
        return $this->hasMany(Pembelajaran::class,'id_kategori_soal','id_kategori_soal');
    }

    public function postKategoriSoal($request)
    {
        DB::beginTransaction();
        try {
            // dd($request);
            $kategori = KategoriSoalModels::count() + 1;
            $kode = 'CODE' . str_pad($kategori,4,"0", STR_PAD_LEFT);
            
            $data = KategoriSoalModels::create([
                'kode_kategori_soal' => $kode,
                'uraian_kategori_soal'=> $request->nama_kategori,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateKategoriSoal($request)
    {
        DB::beginTransaction();
        try {
            // dd($request->id_kategori);
            $data = KategoriSoalModels::where('kode_kategori_soal', $request->id_kategori)->first();
            // dd($data);
            KategoriSoalModels::where('kode_kategori_soal', $data->kode_kategori_soal)->update([
                'uraian_kategori_soal'=> $request->kategori,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

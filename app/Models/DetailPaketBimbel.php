<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPaketBimbel extends Model
{
    use HasFactory;
    protected $table ="detail_paket_bimbel";
    protected $guard = '*';
    protected $appends = ['materi_tes'];

    public function getMateriTesAttribute()
    {
        return MateriTesModels::where('id_materi_tes',$this->id_materi_tes)->first();
    }
    
    public function materi()
    {
        return $this->belongsTo(PaketBimbelModels::class,'id_paket_bimbel','id_paket_bimbel');
    }

    public function paket_bimbel()
    {
        return $this->belongsTo(Pembelajaran::class,'id_materi','id_materi_tes');
    }
}

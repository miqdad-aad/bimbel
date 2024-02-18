<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPaketBimbel extends Model
{
    use HasFactory;
    protected $table ="detail_paket_bimbel";
    protected $guard = '*';
    protected $appends = ['pembelajaran'];

    public function getPembelajaranAttribute()
    {
        return Pembelajaran::where('id_materi',$this->id_materi)->first();
    }
    
    public function materi()
    {
        return $this->belongsTo(PaketBimbelModels::class,'id_paket_bimbel','id_paket_bimbel');
    }
}

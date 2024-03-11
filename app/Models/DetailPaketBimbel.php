<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembelajaran;
use App\Models\JenisTesModels;

class DetailPaketBimbel extends Model
{
    use HasFactory;
    protected $table ="detail_paket_bimbel";
    protected $guard = '*';
    protected $appends = ['jenis_tes'];

  
    public function materi()
    {
        return $this->belongsTo(PaketBimbelModels::class,'id_paket_bimbel','id_paket_bimbel');
    }

    public function paket_bimbel()
    {
        return $this->belongsTo(Pembelajaran::class,'id_materi','id_materi_tes');
    }
    public function getJenisTesAttribute(){
        return JenisTesModels::where("id_jenis_tes", $this->id_jenis_tes)->first();
    }

    public function paket_bimbel_user()
    {
        return $this->hasOne(BookingUserModels::class,'id_paket_bimbel','id_paket_bimbel');
    }
}

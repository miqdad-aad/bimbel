<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketBimbelModels extends Model
{
    use HasFactory;
    protected $table ="m_paket_bimbel";
    protected $guard = 'id_paket_bimbel';

    public function paketBimbel()
    {
        return $this->belongsTo(PaketBimbelModels::class,'id_paket_bimbel','id_paket_bimbel');
    }

    public function paket_booking()
    {
        return $this->hasMany(BookingUserModels::class,'id_paket_bimbel','id_paket');
    }
    

    public function detailPaket()
    {
        return $this->hasMany(DetailPaketBimbel::class,'id_paket_bimbel','id_paket_bimbel');
    }



}

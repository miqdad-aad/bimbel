<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingUserModels extends Model
{
    use HasFactory;
    protected $table ="booking_user";
    protected $guarded = ['id'];

    public function siswa_booking()
    {
        return $this->belongsTo(SiswaModels::class,'id_siswa','id_siswa');
    }

    public function paket_booking()
    {
        return $this->belongsTo(PaketBimbelModels::class,'id_paket','id_paket_bimbel');
    }
}

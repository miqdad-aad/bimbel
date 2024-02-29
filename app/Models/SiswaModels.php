<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModels extends Model
{
    use HasFactory;
    protected $table ="m_siswa";
    protected $guarded = ['id_siswa'];

    public function siswa_booking()
    {
        return $this->hasMany(BookingUserModels::class,'id_siswa','id_siswa');
    }
}

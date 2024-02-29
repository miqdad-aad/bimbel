<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SoalModels;

class JawabanSoalModels extends Model
{
    protected $table = 'm_jawaban_soal';
    protected $guard = '*';
    use HasFactory;

    public function soal()
    {
        return $this->belongsTo(SoalModels::class,'id_soal','id_soal');
    }

}

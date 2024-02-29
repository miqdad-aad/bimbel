<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPaketModels;
use App\Models\Pembelajaran;
use App\Models\JawabanSoalModels;

class SoalModels extends Model
{
    use HasFactory;
    protected $table = 'm_soal';
    protected $guard = '*';

    public function paketSoal()
    {
        return $this->belongsTo(MasterPaketModels::class,'id_paket','id_paket');
    }

    public function materi()
    {
        return $this->belongsTo(Pembelajaran::class,'id_materi','id_materi');
    }

    public function jawabanSoal()
    {
        return $this->hasMany(JawabanSoalModels::class,'id_soal','id_soal');
    }


}

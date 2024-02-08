<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\models\MasterPaketModels;

class SoalModels extends Model
{
    use HasFactory;
    protected $table = 'm_soal';
    protected $guard = '*';

    public function paketSoal()
    {
        return $this->belongsTo(MasterPaketModels::class,'id_paket','id_paket');
    }
}

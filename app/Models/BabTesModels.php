<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabTesModels extends Model
{
    use HasFactory;
    protected $table ="m_bab_tes";
    protected $guarded = ['id_bab_tes'];

    public function pembelajaran()
    {
        return $this->hasOne(Pembelajaran::class,'id_bab_tes','id_bab_tes');
    }
}

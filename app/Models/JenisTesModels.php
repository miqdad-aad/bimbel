<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTesModels extends Model
{
    use HasFactory;
    protected $table ="m_jenis_tes";
    protected $guarded = ['id_m_jenis_tes'];

    public function JenisTes()
    {
        return $this->hasMany(Pembelajaran::class,'id_m_jenis_tes','id_m_jenis_tes');
    }
    public function MateriTes()
    {
        return $this->belongsTo(Pembelajaran::class,'id_m_jenis_tes','id_m_jenis_tes');
    }
}

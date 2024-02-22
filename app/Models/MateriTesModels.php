<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriTesModels extends Model
{
    use HasFactory;
    protected $table ="m_materi_tes";
    protected $guarded = ['id_materi_tes'];

    public function MateriTes()
    {
        return $this->hasMany(JenisTesModels::class,'id_jenis_tes','id_jenis_tes');
    }
    public function JenisTes()
    {
        return $this->belongsTo(JenisTesModels::class,'id_jenis_tes','id_jenis_tes');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTesModels extends Model
{
    use HasFactory;
    protected $table ="m_jenis_tes";
    protected $guarded = ['id_jenis_tes'];
    protected $appends = ['url_gambar'];

    public function JenisTes()
    {
        return $this->hasMany(Pembelajaran::class,'id_jenis_tes','id_jenis_tes');
    }
    public function MateriTes()
    {
        return $this->belongsTo(Pembelajaran::class,'id_jenis_tes','id_jenis_tes');
    }

    public function pembelajaran()
    {
        return $this->hasOne(Pembelajaran::class,'id_jenis_tes','id_jenis_tes');
    }

    public function getUrlGambarAttribute()
    {
        if(empty($this->gambar)) return "https://isobarscience-1bfd8.kxcdn.com/wp-content/uploads/2020/09/default-profile-picture1.jpg";
        return asset('public/jenis_tes/'. $this->gambar);

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSekolahKedinasanModels extends Model
{
    protected $table = 'm_detail_sekolah_kedinasan';
    protected $guard = 'id_sekolah_kedinasan';
    protected $appends = ['url_gambar'];
    use HasFactory;

    public function DetailSekolahKedinasan()
    {
        return $this->hasMany(SekolahKedinasanModels::class,'id_sekolah_kedinasan','id_sekolah_kedinasan');
    }

    public function getUrlGambarAttribute()
    {
        return asset('public/fotosekolahkedinasan/'. $this->gambar);

    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSekolahKedinasanModels extends Model
{
    protected $table = 'm_detail_sekolah_kedinasan';
    protected $guard = 'id_sekolah_kedinasan';
    use HasFactory;

    public function DetailSekolahKedinasan()
    {
        return $this->hasMany(SekolahKedinasanModels::class,'id_sekolah_kedinasan','id_sekolah_kedinasan');
    }

}

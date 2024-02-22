<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembelajaranModels extends Model
{
    use HasFactory;
    protected $table ="m_kategori_pembelajaran";
    protected $guarded = ['id_kategori_pembelajaran'];

    

    public function pembelajaran()
    {
        return $this->hasOne(Pembelajaran::class,'id_kategori_pembelajaran','id_kategori_pembelajaran');
    }
}

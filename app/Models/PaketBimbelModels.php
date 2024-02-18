<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketBimbelModels extends Model
{
    use HasFactory;
    protected $table ="m_paket_bimbel";
    protected $guard = '*';

    public function detailPaket()
    {
        return $this->hasMany(DetailPaketBimbel::class,'id_paket_bimbel','id_paket_bimbel');
    }

}

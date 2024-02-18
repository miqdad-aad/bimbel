<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPaketBimbel extends Model
{
    use HasFactory;
    protected $table ="detail_paket_bimbel";
    protected $guard = '*';

    public function paketBimbel()
    {
        return $this->hasMany(PaketBimbelModels::class,'id_paket_bimbel','id_paket_bimbel');
    }
}

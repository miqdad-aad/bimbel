<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterOrganisasiModels extends Model
{
    use HasFactory;
    protected $table ="m_organisasi";
    protected $guarded = ['id'];
    protected $appends = ['url_gambar'];

    function getUrlGambarAttribute(){
        return asset('struktur_organisasi/'. $this->file_struktur);
    }
}

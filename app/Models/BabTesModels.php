<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabTesModels extends Model
{
    use HasFactory;
    protected $table ="m_bab_tes";
    protected $guarded = ['id_m_bab_tes'];
}

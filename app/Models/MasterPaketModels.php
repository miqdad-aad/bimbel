<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPaketModels extends Model
{
    use HasFactory;
    protected $table ="m_paket";
    protected $guarded = '*';
}

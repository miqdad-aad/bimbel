<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    public function isAdmin()
{
    if($this->role_id === 4)
    { 
        return true; 
    } 
    else 
    { 
        return false; 
    }
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingUserModels extends Model
{
    use HasFactory;
    protected $table ="booking_user";
    protected $guarded = ['id'];
}

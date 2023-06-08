<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
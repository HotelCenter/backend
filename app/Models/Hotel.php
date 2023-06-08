<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(Room::class, 'user_id');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
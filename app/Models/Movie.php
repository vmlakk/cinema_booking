<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'duration', 
        'rating', 
        'showtime',
        'max_rows',
        'max_seats',
        'poster'
    ];

    public function seats(){
        return $this->hasMany(Seat::class);
    }
}

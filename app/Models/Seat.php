<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'row',
        'seat',
        'movie_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public $timestamps = false;
}

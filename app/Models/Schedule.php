<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;


    use HasFactory;
    protected $fillable = [
        'movie_id',
        'start_time',
        'end_time'
    ];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}

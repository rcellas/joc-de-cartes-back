<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'year',
        'season',
        'restaurant_id',
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    public function getSeasonFormattedAttribute()
    {
        return "Temporada " . $this->season;
    }
}

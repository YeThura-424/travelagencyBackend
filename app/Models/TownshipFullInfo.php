<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TownshipFullInfo extends Model
{

    protected $table = 'township_full_info';
    use HasFactory;

    protected $fillable = [
        'region', 'town', 'name_en', 'name_mm'
    ];

    protected $casts = [
        'region' => 'json',
        'town' => 'json'
    ];
}

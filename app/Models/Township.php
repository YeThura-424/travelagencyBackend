<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id', 'town_id', 'name_en', 'name_mm'
    ];

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

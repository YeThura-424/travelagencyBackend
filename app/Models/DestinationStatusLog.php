<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'status', 'destination_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'json'
    ];
}

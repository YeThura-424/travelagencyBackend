<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DestinationStatusLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'status', 'destination_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'json'
    ];
}

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

    public static function recordStatusLog(Destination $destination, $request)
    {
        $meta = json_encode([
            'data' => $request->all(),
            'header' => $request->header(),
            'uri' => $request->path()
        ]);

        self::create([
            'code' => $destination->code,
            'status' => $destination->status,
            'destination_id' => $destination->id,
            'meta' => $meta,
        ]);
    }
}

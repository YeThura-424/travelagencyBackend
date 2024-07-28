<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourStatusLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'status', 'destination_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public static function recordStatusLog(Tour $tour, $request)
    {
        $meta = json_encode([
            'data' => $request->all(),
            'header' => $request->header(),
            'uri' => $request->path()
        ]);

        self::create([
            'code' => $tour->code,
            'status' => $tour->status,
            'tour_id' => $tour->id,
            'meta' => $meta,
        ]);
    }
}

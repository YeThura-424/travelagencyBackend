<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    const STARUS_PENDING = 'pending';
    const STATUS_ONGOING = 'ongoing';
    const STATUS_OVER = 'over';
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'start_date',
        'end_date',
        'max_people',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class)
            ->withPivot('title', 'description', 'image')
            ->withTimestamps();
    }
}

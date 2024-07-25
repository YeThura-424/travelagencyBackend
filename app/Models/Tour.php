<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';
    protected $connection = 'sqlite';

    public const STARUS_PENDING = 'pending';
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_OVER = 'over';
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
        return $this->belongsToMany(Destination::class, 'destination_tour_details')
            ->withPivot('title', 'description')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }
}

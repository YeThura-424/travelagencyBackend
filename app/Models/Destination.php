<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'destinations';
    protected $connection = 'sqlite';

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";


    protected $fillable = [
        'code',
        'name',
        'location',
        'place', // မြို့တစ်မြို့ရဲ့ အထင်ကရနေရာတွေရဲ့ နာမည် 
        'description',
        'images',
        'status',
        'remark', // for rejection
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'location' => 'json',
    ];

    public function logs()
    {
        return $this->hasMany(DestinationStatusLog::class);
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class)
            ->withPivot('title', 'description', 'image')
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

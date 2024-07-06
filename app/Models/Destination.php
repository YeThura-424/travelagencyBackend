<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'destinations';
    protected $connection = 'mysql';

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";


    protected $fillable = [
        'name','location','description','images','status','created_by','updated_by'
    ];

    protected $casts = [
        'location' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->created_by = auth()->id();
        });

        self::updating(function($model) {
            $model->updated_by = auth()->id();
        });
    }

}

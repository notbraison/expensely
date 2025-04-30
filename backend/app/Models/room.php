<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';

    protected $fillable = [
        'floor_id',
        'room_name',
        'size',
        'number_of_bedrooms',
        'type',
        'status',
        'rate',
        'currency'
    ];

    public function floor(): BelongsTo {
        return $this->belongsTo(Floor::class,'floor_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    

    protected $primaryKey = 'room_id';
}

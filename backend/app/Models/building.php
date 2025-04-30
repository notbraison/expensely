<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class building extends Model
{
    use HasFactory;
    protected $fillable = [
        'building_name',
        'location',
        'number_of_floors',
    ];

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class,'building_id');
    }

    protected $primaryKey = 'building_id';
}

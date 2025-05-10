<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the members of the group.
     */
    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }
}

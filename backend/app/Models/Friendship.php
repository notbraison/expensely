<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    // Define the table name if it's different
    protected $table = 'friendships';

    protected $fillable = [
        'user_id', 'friend_id', 'status'
    ];

    // Define the 'status' as an Enum if you want to limit values to 'pending', 'accepted', 'declined'
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const DECLINED = 'declined';

    /**
     * The user that initiated the friendship (sent the request).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The user who is the recipient of the friendship (received the request).
     */
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    /**
     * Determine if the friendship is accepted.
     */
    public function isAccepted()
    {
        return $this->status === self::ACCEPTED;
    }

    /**
     * Determine if the friendship is pending.
     */
    public function isPending()
    {
        return $this->status === self::PENDING;
    }

    /**
     * Determine if the friendship is declined.
     */
    public function isDeclined()
    {
        return $this->status === self::DECLINED;
    }
}


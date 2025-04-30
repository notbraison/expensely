<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments'; // Reference to the 'payments' table

    protected $primaryKey = 'payment_id'; // Define primary key

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id', 
        'room_id', 
        'booking_id',
        'transaction_id', 
        'paid_at', 
        'amount', 
        'payment_method', 
        'payment_account',
        'status', 
    ];
    

    // Define relationships

    // A payment belongs to a user
    public function user():BelongsTo  
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A payment is for a specific room
    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function booking():BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
        
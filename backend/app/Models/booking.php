<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Specify the table name if it's not the plural of the model name

    protected $primaryKey = 'booking_id'; // Specify the primary key if different from 'id'

    protected $fillable = [
        'user_id',
        'room_id',
        'purpose',
        'status',
        'start_date',
        'end_date',
    ];

    // Define relationships
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id'); // 'id' is the primary key in the 'users' table
}

public function room()
{
    return $this->belongsTo(Room::class, 'room_id', 'room_id'); // 'id' is the primary key in the 'room' table
}


}

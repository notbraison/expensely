<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogNotes extends Model
{
    use HasFactory;

    protected $table = 'log_notes';
    protected $primaryKey = 'note_id';

    protected $fillable = [
        'user_id',
        'payment_id',
        'room_id',
        'log_note_text',
    ];

    public function user():BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function payment():BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}

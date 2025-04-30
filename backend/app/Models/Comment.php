<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'user_id',
        'payment_id',
        'room_id',
        'comment_text',
        "admin_id"
    ];

    /* public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    } */

    /* public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    } */

    /* public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }  */
}

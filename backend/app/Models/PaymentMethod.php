<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    protected $fillable = [
        'user_id',
        'method',
        'account_id',
        'status',
    ];

    /**
     * Get the user associated with this payment method.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

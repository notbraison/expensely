<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'status', 'payment_method', 'payment_date', 'transaction_id', 'payment_details'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];
}

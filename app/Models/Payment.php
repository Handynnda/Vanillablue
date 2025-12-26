<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_code',
        'amount',
        'payment_status',
        'payment_date',
        'proof_image',
        'payment_method'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

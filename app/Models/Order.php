<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Paket;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bundling_id',
        'book_date',
        'book_time',
        'location',
        'note',
        'order_status',
        'total_price',
        'sum_order',
        'name',
        'phone'
    ];

    public function bundling()
    {
        return $this->belongsTo(Paket::class, 'bundling_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

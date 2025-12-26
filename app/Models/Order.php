<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Paket;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->order_code)) {
                $model->order_code = self::generatePrefixedCode('ORD');
            }
        });
    }

    protected static function generatePrefixedCode(string $prefix): string
    {
        do {
            $candidate = $prefix . Str::upper(Str::random(5));
        } while (self::where('order_code', $candidate)->exists());

        return $candidate;
    }

    public function bundling()
    {
        return $this->belongsTo(Paket::class, 'bundling_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

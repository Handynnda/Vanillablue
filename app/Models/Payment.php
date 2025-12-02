<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'amount',
        'payment_status',
        'payment_date',
        'proof_image',
        'payment_method'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generatePrefixedId('PYM');
            }
        });
    }

    protected static function generatePrefixedId(string $prefix): string
    {
        do {
            $candidate = $prefix . Str::upper(Str::random(5));
        } while (self::where('id', $candidate)->exists());
        return $candidate;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

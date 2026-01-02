<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    // Sesuai gambar DB, ID berisi PYM...
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'amount',
        'payment_status',
        'payment_method',
        'payment_date',
        'proof_image'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'PYM' . Str::upper(Str::random(7));
            }
        });
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
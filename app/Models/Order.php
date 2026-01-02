<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    // Sesuai gambar DB, ID berisi ORD...
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
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
            if (empty($model->id)) {
                $model->id = 'ORD' . Str::upper(Str::random(7));
            }
        });
    }

    public function bundling() {
        return $this->belongsTo(Bundling::class, 'bundling_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
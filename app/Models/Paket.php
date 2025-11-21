<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'bundlings';

    protected $fillable = [
        'name_bundling',
        'price_bundling',
        'description_bundling',
        'category',
    ];

    // Relasi ke Order
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'bundling_id');
    }
}

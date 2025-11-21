<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    // nama tabel berbeda dari default
    protected $table = 'bundlings';

    protected $fillable = [
        'name_bundling',
        'price_bundling',
        'description_bundling',
        'category',
    ];
    
}

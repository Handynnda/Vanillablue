<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'bundlings';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name_bundling',
        'price_bundling',
        'description_bundling',
        'category',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generatePrefixedId('BUN');
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

    // Relasi ke Order
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'bundling_id');
    }
}

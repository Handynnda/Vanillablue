<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundling extends Model
{
    use HasFactory;

    protected $table = 'bundlings';

    protected $fillable = [
        'name_bundling',
        'price_bundling',
        'description_bundling',
        'category',
    ];

    protected $casts = [
        'price_bundling' => 'float',
    ];

    public static function parseDescription($raw): array
    {
        if (is_array($raw)) return $raw;
        if ($raw === null || trim($raw) === '') return [];
        $json = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) return $json;
        return array_filter(array_map('trim', preg_split('/[\r\n;,]+/', $raw)));
    }
        public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

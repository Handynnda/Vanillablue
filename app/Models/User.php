<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // AKTIFKAN INI: Karena ID Anda adalah string (UID...)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', // Pastikan ID ada di sini agar bisa disimpan saat registrasi
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Aktifkan ini jika Anda ingin generate UID otomatis saat pendaftaran baru
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generatePrefixedId('UID');
            }
        });
    }

    protected static function generatePrefixedId(string $prefix): string
    {
        do {
            $candidate = $prefix . Str::upper(Str::random(7));
        } while (self::where('id', $candidate)->exists());
        return $candidate;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
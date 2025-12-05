<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'expiry_date',
        'max_uses',
        'uses_count',
        'is_active',
    ];

    // Mối quan hệ
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Helper validate code
    public static function validateCode($code)
    {
        return self::where('code', $code)
            ->where('is_active', true)
            ->where('expiry_date', '>', now())
            ->where('uses_count', '<', DB::raw('max_uses'))
            ->first();
    }
}
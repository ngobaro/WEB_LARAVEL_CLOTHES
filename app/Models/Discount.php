<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // QUAN TRỌNG: Thêm casts để chuyển expiry_date thành Carbon
    protected $casts = [
        'expiry_date' => 'date',  // Chuyển string thành Carbon instance
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
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

    // Helper validate code - Sửa lỗi logic
    public static function validateCode($code, $orderAmount = 0)
    {
        $discount = self::where('code', $code)
            ->where('is_active', true)
            ->where('expiry_date', '>', now())
            ->first();

        if (!$discount) {
            return null;
        }

        // Kiểm tra min_order_amount
        if ($discount->min_order_amount && $orderAmount < $discount->min_order_amount) {
            return null;
        }

        // Kiểm tra max_uses (nếu có)
        if ($discount->max_uses && $discount->uses_count >= $discount->max_uses) {
            return null;
        }

        return $discount;
    }

    // Tính giá trị giảm
    public function calculateDiscount($amount)
    {
        if ($this->type == 'percent') {
            $discount = $amount * ($this->value / 100);
        } else {
            $discount = $this->value;
        }
        
        // Không vượt quá số tiền
        return min($discount, $amount);
    }

    // Kiểm tra còn hiệu lực không
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if (now()->greaterThan($this->expiry_date)) {
            return false;
        }

        if ($this->max_uses && $this->uses_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    // Tăng số lần sử dụng
    public function incrementUses()
    {
        $this->increment('uses_count');
        $this->save();
    }
}
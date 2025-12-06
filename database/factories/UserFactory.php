<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Mật khẩu hiện tại đang được sử dụng bởi factory.
     */
    protected static ?string $password;

    /**
     * Định nghĩa trạng thái mặc định cho mô hình.
     *
     * Mô tả:
     * - Xây dựng và trả về một mảng các thuộc tính mặc định cho mô hình User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),  // Tên người dùng ngẫu nhiên
            'email' => fake()->unique()->safeEmail(),  // Email ngẫu nhiên, duy nhất
            'email_verified_at' => now(),  // Thời điểm xác thực email, đặt thành thời gian hiện tại
            'password' => static::$password ??= Hash::make('password'),  // Mật khẩu mặc định đã được hash
            'remember_token' => Str::random(10),  // Token ngẫu nhiên cho tính năng "ghi nhớ đăng nhập"
        ];
    }

    /**
     * Chỉ định rằng địa chỉ email của mô hình sẽ không được xác thực.
     *
     * Mô tả:
     * - Trả về một trạng thái mà địa chỉ email không có thời gian xác thực.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,  // Đặt thời gian xác thực email thành null
        ]);
    }
}
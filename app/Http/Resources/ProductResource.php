<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Biến đổi resource thành mảng.
     *
     * Hàm này sẽ được gọi khi trả về dữ liệu sản phẩm dưới dạng JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);  // sử dụng phương thức cha để chuyển đổi thành mảng
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');  // Chỉ admin được tạo/sửa sản phẩm
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',  // Tên sản phẩm bắt buộc, max 255 ký tự
            'price' => 'required|numeric|min:0',  // Giá bắt buộc, số dương
            'description' => 'required|string',  // Mô tả bắt buộc
            'stock' => 'required|integer|min:0',  // Tồn kho bắt buộc, số nguyên >= 0
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Ảnh tùy chọn, định dạng, max 2MB
            'discount_id' => 'nullable|exists:discounts,id',  // Giảm giá tùy chọn, phải tồn tại trong bảng discounts
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm bắt buộc.',
            'name.max' => 'Tên sản phẩm không quá 255 ký tự.',
            'price.required' => 'Giá sản phẩm bắt buộc.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'description.required' => 'Mô tả sản phẩm bắt buộc.',
            'stock.required' => 'Tồn kho bắt buộc.',
            'stock.min' => 'Tồn kho phải lớn hơn hoặc bằng 0.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải là jpeg, png, jpg.',
            'image.max' => 'Hình ảnh không quá 2MB.',
            'discount_id.exists' => 'Giảm giá không tồn tại.',
        ];
    }
}
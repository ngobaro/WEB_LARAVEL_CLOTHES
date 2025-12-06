<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountsController extends Controller
{
    /**
     * Hiển thị danh sách discount.
     */
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Hiển thị form tạo discount mới.
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Lưu discount mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Xử lý max_uses: nếu không nhập thì đặt giá trị mặc định lớn
        $maxUses = $request->filled('max_uses') ? $request->max_uses : 999999;
        
        // Xử lý min_order_amount
        $minOrderAmount = $request->filled('min_order_amount') ? $request->min_order_amount : 0;

        Discount::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $minOrderAmount,
            'expiry_date' => $request->expiry_date,
            'max_uses' => $maxUses,  // Luôn có giá trị
            'uses_count' => 0,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Thêm mã giảm giá thành công!');
    }

    /**
     * Hiển thị chi tiết discount.
     */
    public function show(Discount $discount)
    {
        $discount->load(['orders.user', 'products']);
        return view('admin.discounts.show', compact('discount'));
    }

    /**
     * Hiển thị form chỉnh sửa discount.
     */
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    /**
     * Cập nhật discount.
     */
   public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Xử lý max_uses: nếu không nhập thì đặt giá trị mặc định lớn
        $maxUses = $request->filled('max_uses') ? $request->max_uses : 999999;
        
        // Xử lý min_order_amount
        $minOrderAmount = $request->filled('min_order_amount') ? $request->min_order_amount : 0;

        $discount->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $minOrderAmount,
            'expiry_date' => $request->expiry_date,
            'max_uses' => $maxUses,  // Luôn có giá trị
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Xóa discount.
     */
    public function destroy(Discount $discount)
    {
        // Kiểm tra nếu discount đã được sử dụng
        if ($discount->uses_count > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa mã giảm giá đã được sử dụng!');
        }

        $discount->delete();
        
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }
}
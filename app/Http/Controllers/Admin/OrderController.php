<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Discount;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng.
     *
     * Mô tả:
     * - Lấy tất cả đơn hàng từ cơ sở dữ liệu cùng với thông tin user và discount.
     * - Đơn hàng được sắp xếp theo thời gian tạo và phân trang 12 đơn mỗi trang.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy danh sách đơn hàng cùng thông tin user và discount, sắp xếp mới nhất và phân trang (12 đơn/trang)
        $orders = Order::with(['user', 'discount'])->latest()->paginate(12);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị form để tạo đơn hàng mới.
     *
     * Mô tả:
     * - Lấy danh sách user và discount để hiển thị trong form tạo đơn hàng.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Lấy danh sách user và discount để hiển thị trong form tạo đơn hàng
        $users = User::orderBy('name')->get();
        $discounts = Discount::orderBy('code')->get();
        return view('admin.orders.create', compact('users', 'discounts'));
    }

    /**
     * Lưu đơn hàng mới vào cơ sở dữ liệu.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào từ request.
     * - Tính tổng tiền và số tiền giảm nếu có discount.
     * - Lưu thông tin đơn hàng vào cơ sở dữ liệu.
     * - Redirect về trang danh sách đơn hàng với thông báo thành công.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,shipped,cancelled',
            'payment_method' => 'nullable|in:momo,stripe,cod',
            'payment_id' => 'nullable|string|max:255',
        ]);

        // Tính số tiền giảm nếu có discount
        $discountAmount = 0;
        if ($request->discount_id) {
            $discount = Discount::find($request->discount_id);
            if ($discount) {
                if ($discount->type == 'percent') {
                    $discountAmount = $request->total_amount * ($discount->value / 100);
                } else {
                    $discountAmount = $discount->value;
                }
                $discountAmount = min($discountAmount, $request->total_amount);  // Không vượt tổng tiền
            }
        }

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $request->user_id,
            'discount_id' => $request->discount_id,
            'total_amount' => $request->total_amount,
            'discount_amount' => $discountAmount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_id' => $request->payment_id,
        ]);

        // Cập nhật uses_count cho discount nếu có
        if ($request->discount_id) {
            $discount->increment('uses_count');
        }

        // Redirect về danh sách đơn hàng với thông báo thành công
        return redirect()->route('admin.orders.index')->with('success', 'Thêm đơn hàng thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết của đơn hàng.
     *
     * Mô tả:
     * - Tải đơn hàng và thông tin liên quan (user, discount, orderItems, payments).
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['user', 'discount', 'orderItems.product', 'payments']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Hiển thị form để chỉnh sửa đơn hàng.
     *
     * Mô tả:
     * - Lấy đơn hàng cụ thể và danh sách user, discount để chỉnh sửa.
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $users = User::orderBy('name')->get();
        $discounts = Discount::orderBy('code')->get();
        return view('admin.orders.edit', compact('order', 'users', 'discounts'));
    }

    /**
     * Cập nhật thông tin đơn hàng.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào.
     * - Tính lại số tiền giảm nếu thay đổi discount.
     * - Cập nhật đơn hàng trong cơ sở dữ liệu.
     *
     * @param \Illuminate\Http\Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,shipped,cancelled',
            'payment_method' => 'nullable|in:momo,stripe,cod',
            'payment_id' => 'nullable|string|max:255',
        ]);

        // Tính số tiền giảm mới nếu thay đổi discount
        $discountAmount = 0;
        if ($request->discount_id) {
            $discount = Discount::find($request->discount_id);
            if ($discount) {
                if ($discount->type == 'percent') {
                    $discountAmount = $request->total_amount * ($discount->value / 100);
                } else {
                    $discountAmount = $discount->value;
                }
                $discountAmount = min($discountAmount, $request->total_amount);
            }
        }

        // Cập nhật đơn hàng
        $order->update([
            'user_id' => $request->user_id,
            'discount_id' => $request->discount_id,
            'total_amount' => $request->total_amount,
            'discount_amount' => $discountAmount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_id' => $request->payment_id,
        ]);

        // Cập nhật uses_count cho discount mới nếu thay đổi
        if ($request->discount_id && $request->discount_id != $order->getOriginal('discount_id')) {
            $discount->increment('uses_count');
        }

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    /**
     * Xóa đơn hàng khỏi cơ sở dữ liệu.
     *
     * Mô tả:
     * - Xóa đơn hàng và các orderItems, payments liên quan.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // Xóa orderItems và payments liên quan (cascade delete nếu có)
        $order->orderItems()->delete();
        $order->payments()->delete();

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }
}
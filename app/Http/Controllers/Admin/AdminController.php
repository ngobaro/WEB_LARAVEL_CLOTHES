<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Hiển thị dashboard cho admin.
     *
     * Mô tả chạy:
     * - Controller này được gọi khi route admin dashboard được truy cập (thường do routes/admin.php).
     * - Nó thu thập các số liệu tóm tắt từ model: tổng sản phẩm, tổng đơn hàng, tổng người dùng.
     * - Tính doanh thu của tháng hiện tại bằng cách lấy tổng `total_amount` của các đơn hàng
     *   có `created_at` thuộc tháng hiện tại.
     * - Lấy 5 đơn hàng mới nhất kèm thông tin user liên quan để hiển thị trong bảng "recent orders".
     * - Cuối cùng trả về view `admin.dashboard` và truyền các biến cần hiển thị.
     *
     * Ghi chú kỹ thuật:
     * - `Product::count()`/`Order::count()`/`User::count()` là các truy vấn Eloquent trả về số bản ghi.
     * - `Order::with('user')->latest()->take(5)->get()` dùng eager loading để tránh N+1 khi lấy user của mỗi đơn hàng.
     * - `compact(...)` là cách nhanh để tạo mảng dữ liệu truyền vào view.
     */
    public function index()
    {
        // Tổng số sản phẩm trong database
        $totalProducts = Product::count();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số người dùng
        $totalUsers = User::count();

        // Doanh thu trong tháng hiện tại (tổng trường `total_amount` của các đơn hàng trong tháng)
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_amount');

        // 5 đơn hàng gần nhất, kèm thông tin user (eager loaded)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Trả về view admin.dashboard và truyền các biến để view hiển thị
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'monthlyRevenue',
            'recentOrders'
        ));
    }
}
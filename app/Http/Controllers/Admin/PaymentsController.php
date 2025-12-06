<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    /**
     * Hiển thị danh sách thanh toán.
     */
    public function index(Request $request)
    {
        $query = Payment::with('order.user')->latest();
        
        // Lọc
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('paid_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }
        
        $payments = $query->paginate(20);
        
        // Tính doanh thu
        $revenue = [
            'today' => $this->getRevenueByDays(1),
            'last_7_days' => $this->getRevenueByDays(7),
            'last_30_days' => $this->getRevenueByDays(30),
            'total' => Payment::where('status', 'success')->sum('amount'),
        ];
        
        return view('admin.payments.index', compact('payments', 'revenue'));
    }
    
    /**
     * Tính doanh thu theo số ngày.
     */
    private function getRevenueByDays($days)
    {
        return Payment::where('status', 'success')
            ->where('paid_at', '>=', now()->subDays($days))
            ->sum('amount');
    }
    
    /**
     * Thống kê doanh thu chi tiết.
     */
    // Trong PaymentsController
    public function revenue(Request $request)
    {
        $days = $request->get('days', 30);
        
        // Doanh thu theo ngày
        $dailyRevenue = Payment::select(
                DB::raw('DATE(paid_at) as date'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('status', 'success')
            ->where('paid_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        
        // Doanh thu theo phương thức
        $paymentMethodRevenue = Payment::select(
                'payment_method',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('status', 'success')
            ->where('paid_at', '>=', now()->subDays($days))
            ->groupBy('payment_method')
            ->get();
        
        // Tổng doanh thu
        $totalRevenue = $dailyRevenue->sum('total');
        $totalTransactions = $dailyRevenue->sum('count');
        
        return view('admin.payments.revenue', compact(
            'dailyRevenue', 
            'paymentMethodRevenue', 
            'totalRevenue',
            'totalTransactions',
            'days'
        ));
    }

    /**
     * Hiển thị chi tiết thanh toán.
     */
    public function show(Payment $payment)
    {
        $payment->load('order.user');
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Cập nhật trạng thái thanh toán (chỉ từ pending sang các trạng thái khác).
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        // Chỉ cho phép cập nhật nếu đang là pending
        if ($payment->status != 'pending') {
            return redirect()->back()
                ->with('error', 'Chỉ có thể thay đổi trạng thái của thanh toán đang chờ!');
        }
        
        $request->validate([
            'status' => 'required|in:success,failed,cancelled',
        ]);
        
        $payment->update([
            'status' => $request->status,
            'paid_at' => $request->status == 'success' ? now() : null,
        ]);
        
        // Cập nhật trạng thái order
        $order = $payment->order;
        if ($request->status == 'success') {
            $order->update(['status' => 'paid']);
        }
        
        return redirect()->route('admin.payments.index')
            ->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }
}
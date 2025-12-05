@extends('admin.layouts.admin')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Tổng Sản Phẩm</h5>
                        <h2>{{ $totalProducts ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-box fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Tổng Đơn Hàng</h5>
                        <h2>{{ $totalOrders ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-shopping-bag fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Tổng Users</h5>
                        <h2>{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Doanh Thu Tháng</h5>
                        <h2>{{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }} VNĐ</h2>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section (dùng Chart.js đơn giản) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Biểu Đồ Đơn Hàng Tháng Này</h5>
            </div>
            <div class="card-body">
                <canvas id="ordersChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Đơn Hàng Gần Đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Ngày</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders ?? [] as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">Xem</a>
                                        <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có đơn hàng nào!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart đơn hàng (data giả)
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
            datasets: [{
                label: 'Đơn Hàng',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
@endsection
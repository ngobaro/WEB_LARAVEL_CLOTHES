@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thống Kê Doanh Thu</h2>
    <div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<!-- Chọn khoảng thời gian -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label">Xem doanh thu</label>
                <select name="days" class="form-control" onchange="this.form.submit()">
                    <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 ngày qua</option>
                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 ngày qua</option>
                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>90 ngày qua</option>
                    <option value="365" {{ $days == 365 ? 'selected' : '' }}>1 năm qua</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Thống kê tổng -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Tổng Doanh Thu</h6>
                <h3 class="mb-0">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Tổng Số Giao Dịch</h6>
                <h3 class="mb-0">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Trung Bình / Giao Dịch</h6>
                <h3 class="mb-0">
                    @if($totalTransactions > 0)
                        {{ number_format($totalRevenue / $totalTransactions, 0, ',', '.') }} VNĐ
                    @else
                        0 VNĐ
                    @endif
                </h3>
            </div>
        </div>
    </div>
</div>

<!-- Doanh thu theo phương thức -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Doanh Thu Theo Phương Thức</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Phương Thức</th>
                                <th>Số Giao Dịch</th>
                                <th>Doanh Thu</th>
                                <th>Tỷ Lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentMethodRevenue as $method)
                                <tr>
                                    <td>
                                        @switch($method->payment_method)
                                            @case('momo')<span class="badge bg-purple">MoMo</span>@break
                                            @case('stripe')<span class="badge bg-primary">Stripe</span>@break
                                            @case('cod')<span class="badge bg-secondary">COD</span>@break
                                            @case('bank_transfer')<span class="badge bg-info">Chuyển Khoản</span>@break
                                        @endswitch
                                    </td>
                                    <td>{{ $method->count }}</td>
                                    <td>{{ number_format($method->total, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        @if($totalRevenue > 0)
                                            {{ number_format(($method->total / $totalRevenue) * 100, 1) }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Biểu Đồ Phương Thức Thanh Toán</h5>
            </div>
            <div class="card-body">
                <canvas id="paymentMethodChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Doanh thu theo ngày -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Doanh Thu Theo Ngày ({{ $days }} ngày qua)</h5>
    </div>
    <div class="card-body">
        @if($dailyRevenue->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Số Giao Dịch</th>
                            <th>Doanh Thu</th>
                            <th>Trung Bình / Giao Dịch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyRevenue as $day)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                <td>{{ $day->count }}</td>
                                <td>{{ number_format($day->total, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    @if($day->count > 0)
                                        {{ number_format($day->total / $day->count, 0, ',', '.') }} VNĐ
                                    @else
                                        0 VNĐ
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted mb-0">Không có dữ liệu doanh thu trong khoảng thời gian này.</p>
        @endif
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dữ liệu cho biểu đồ phương thức thanh toán
        const paymentMethodData = {
            labels: {!! json_encode($paymentMethodRevenue->pluck('payment_method')->map(function($method) {
                switch($method) {
                    case 'momo': return 'MoMo';
                    case 'stripe': return 'Stripe';
                    case 'cod': return 'COD';
                    case 'bank_transfer': return 'Chuyển Khoản';
                    default: return $method;
                }
            })) !!},
            datasets: [{
                data: {!! json_encode($paymentMethodRevenue->pluck('total')) !!},
                backgroundColor: [
                    '#6f42c1', // purple for momo
                    '#007bff', // blue for stripe
                    '#6c757d', // gray for cod
                    '#17a2b8'  // cyan for bank transfer
                ]
            }]
        };
        
        // Tạo biểu đồ tròn
        const ctx = document.getElementById('paymentMethodChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: paymentMethodData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / total) * 100);
                                return `${label}: ${new Intl.NumberFormat('vi-VN').format(value)} VNĐ (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script> -->

<style>
    .bg-purple {
        background-color: #6f42c1 !important;
    }
</style>
@endsection
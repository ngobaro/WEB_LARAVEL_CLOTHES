@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản Lý Thanh Toán</h2>
    <a href="{{ route('admin.payments.revenue') }}" class="btn btn-success">
        <i class="fas fa-chart-line"></i> Thống Kê Doanh Thu
    </a>
</div>

<!-- Thống kê nhanh -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Hôm Nay</h6>
                <h4 class="mb-0">{{ number_format($revenue['today'], 0, ',', '.') }} VNĐ</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">7 Ngày Qua</h6>
                <h4 class="mb-0">{{ number_format($revenue['last_7_days'], 0, ',', '.') }} VNĐ</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">30 Ngày Qua</h6>
                <h4 class="mb-0">{{ number_format($revenue['last_30_days'], 0, ',', '.') }} VNĐ</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Tổng Doanh Thu</h6>
                <h4 class="mb-0">{{ number_format($revenue['total'], 0, ',', '.') }} VNĐ</h4>
            </div>
        </div>
    </div>
</div>

<!-- Form lọc -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Trạng Thái</label>
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Thành công</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Phương Thức</label>
                <select name="payment_method" class="form-control" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>MoMo</option>
                    <option value="stripe" {{ request('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Khoảng thời gian</label>
                <div class="input-group">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    <span class="input-group-text">đến</span>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bảng danh sách -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Đơn Hàng</th>
                <th>Khách Hàng</th>
                <th>Số Tiền</th>
                <th>Phương Thức</th>
                <th>Trạng Thái</th>
                <th>Thời Gian</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $payment->order_id) }}">
                            #{{ $payment->order_id }}
                        </a>
                    </td>
                    <td>{{ $payment->order->user->name }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                    <td>
                        @switch($payment->payment_method)
                            @case('momo')<span class="badge bg-purple">MoMo</span>@break
                            @case('stripe')<span class="badge bg-primary">Stripe</span>@break
                            @case('cod')<span class="badge bg-secondary">COD</span>@break
                            @case('bank_transfer')<span class="badge bg-info">Chuyển Khoản</span>@break
                        @endswitch
                    </td>
                    <td>
                        @if($payment->status == 'pending')
                            <form action="{{ route('admin.payments.updateStatus', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" selected>Đang chờ</option>
                                    <option value="success">Thành công</option>
                                    <option value="failed">Thất bại</option>
                                    <option value="cancelled">Đã hủy</option>
                                </select>
                            </form>
                        @else
                            @switch($payment->status)
                                @case('success')<span class="badge bg-success">Thành công</span>@break
                                @case('failed')<span class="badge bg-danger">Thất bại</span>@break
                                @case('cancelled')<span class="badge bg-secondary">Đã hủy</span>@break
                            @endswitch
                        @endif
                    </td>
                    <td>
                        @if($payment->paid_at)
                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}
                        @else
                            <span class="text-muted">Chưa thanh toán</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Chưa có thanh toán nào!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $payments->links() }}

<style>
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    .form-select-sm {
        width: auto;
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
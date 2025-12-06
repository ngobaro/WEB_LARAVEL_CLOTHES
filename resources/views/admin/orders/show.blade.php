@extends('layouts.admin')

@section('content')
<h2>Chi Tiết Đơn Hàng: #{{ $order->id }}</h2>

<div class="row">
    <div class="col-md-6">
        <p><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Tổng Tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
        <p><strong>Số Tiền Giảm:</strong> {{ number_format($order->discount_amount, 0, ',', '.') }} VNĐ</p>
        <p><strong>Trạng Thái:</strong> <span class="badge bg-{{ $order->status == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Phương Thức Thanh Toán:</strong> {{ ucfirst($order->payment_method ?? 'Không') }}</p>
        <p><strong>ID Thanh Toán:</strong> {{ $order->payment_id ?? 'Không' }}</p>
        <p><strong>Ngày Tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Giảm Giá:</strong> {{ $order->discount?->code ?? 'Không' }}</p>
    </div>
    <div class="col-md-6">
        <h5>Chi Tiết Sản Phẩm</h5>
        <ul class="list-group">
            @foreach ($order->orderItems as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                    <span>{{ number_format($item->price_at_time * $item->quantity, 0, ',', '.') }} VNĐ</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h5>Lịch Sử Thanh Toán</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Số Tiền</th>
                        <th>Phương Thức</th>
                        <th>Trạng Thái</th>
                        <th>Thời Gian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->payments as $payment)
                        <tr>
                            <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td><span class="badge bg-{{ $payment->status == 'success' ? 'success' : 'warning' }}">{{ ucfirst($payment->status) }}</span></td>
                            <td>{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : 'Chưa thanh toán' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Chưa có thanh toán nào!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">Sửa</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection
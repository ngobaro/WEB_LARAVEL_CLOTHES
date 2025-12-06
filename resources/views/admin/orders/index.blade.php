@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh Sách Đơn Hàng</h2>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Mới
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

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
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'paid' ? 'success' : ($order->status == 'shipped' ? 'info' : 'warning') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa đơn hàng?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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

{{ $orders->links() }}
@endsection
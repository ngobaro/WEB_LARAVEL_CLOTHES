@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh Sách Mã Giảm Giá</h2>
    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Mới
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã Code</th>
                <th>Loại</th>
                <th>Giá Trị</th>
                <th>Đơn Tối Thiểu</th>
                <th>Hạn Sử Dụng</th>
                <th>Số Lần Dùng</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($discounts as $discount)
                <tr>
                    <td>{{ $discount->id }}</td>
                    <td><strong>{{ $discount->code }}</strong></td>
                    <td>
                        @if($discount->type == 'percent')
                            <span class="badge bg-info">Phần trăm</span>
                        @else
                            <span class="badge bg-success">Cố định</span>
                        @endif
                    </td>
                    <td>
                        @if($discount->type == 'percent')
                            {{ $discount->value }}%
                        @else
                            {{ number_format($discount->value, 0, ',', '.') }} VNĐ
                        @endif
                    </td>
                    <td>
                        @if($discount->min_order_amount)
                            {{ number_format($discount->min_order_amount, 0, ',', '.') }} VNĐ
                        @else
                            <span class="text-muted">Không yêu cầu</span>
                        @endif
                    </td>
                    <td>
                        @if($discount->expiry_date->isPast())
                            <span class="badge bg-danger">Hết hạn</span>
                        @endif
                    </td>
                    <td>
                        {{ $discount->uses_count }}
                        @if($discount->max_uses)
                            /{{ $discount->max_uses }}
                        @else
                            /∞
                        @endif
                    </td>
                    <td>
                        @if($discount->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Không hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.discounts.show', $discount) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa mã giảm giá này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Chưa có mã giảm giá nào!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $discounts->links() }}
@endsection
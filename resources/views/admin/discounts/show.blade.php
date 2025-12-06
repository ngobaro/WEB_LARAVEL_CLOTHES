@extends('admin.layouts.admin')  <!-- ĐÃ SỬA -->

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi Tiết Mã Giảm Giá: {{ $discount->code }}</h4>
        <div>
            <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Mã Code:</th>
                        <td><strong class="text-primary">{{ $discount->code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Loại Giảm Giá:</th>
                        <td>
                            @if($discount->type == 'percent')
                                <span class="badge bg-info">Phần trăm</span>
                            @else
                                <span class="badge bg-success">Cố định</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Giá Trị:</th>
                        <td>
                            @if($discount->type == 'percent')
                                <strong>{{ $discount->value }}%</strong>
                            @else
                                <strong>{{ number_format($discount->value, 0, ',', '.') }} VNĐ</strong>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Đơn Hàng Tối Thiểu:</th>
                        <td>
                            @if($discount->min_order_amount)
                                {{ number_format($discount->min_order_amount, 0, ',', '.') }} VNĐ
                            @else
                                <span class="text-muted">Không yêu cầu</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Hạn Sử Dụng:</th>
                        <td>
                            {{ \Carbon\Carbon::parse($discount->expiry_date)->format('d/m/Y') }}  
                            @if(\Carbon\Carbon::parse($discount->expiry_date)->isPast())  
                                <span class="badge bg-danger ms-2">Hết hạn</span>
                            @else
                                @php
                                    $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($discount->expiry_date), false); 
                                @endphp
                                @if($daysLeft >= 0)
                                    <span class="badge bg-info ms-2">Còn {{ $daysLeft }} ngày</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Số Lần Đã Dùng:</th>
                        <td>
                            {{ $discount->uses_count }}
                            @if($discount->max_uses)
                                / {{ $discount->max_uses }}
                                @php
                                    $remaining = $discount->max_uses - $discount->uses_count;
                                @endphp
                                @if($remaining <= 0)
                                    <span class="badge bg-danger ms-2">Hết lượt</span>
                                @else
                                    <span class="badge bg-success ms-2">Còn {{ $remaining }} lượt</span>
                                @endif
                            @else
                                / ∞
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Trạng Thái:</th>
                        <td>
                            @if($discount->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Không hoạt động</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày Tạo:</th>
                        <td>{{ $discount->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Ngày Cập Nhật:</th>
                        <td>{{ $discount->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tab thống kê -->
        <div class="row mt-4">
            <div class="col-12">
                <ul class="nav nav-tabs" id="discountTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button">
                            Đơn Hàng Đã Dùng ({{ $discount->orders->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button">
                            Sản Phẩm Áp Dụng ({{ $discount->products->count() }})
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-3 border border-top-0" id="discountTabContent">
                    <!-- Tab đơn hàng -->
                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                        @if($discount->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID Đơn</th>
                                            <th>Khách Hàng</th>
                                            <th>Tổng Tiền</th>
                                            <th>Giảm Giá</th>
                                            <th>Ngày Đặt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($discount->orders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order) }}">
                                                        #{{ $order->id }}
                                                    </a>
                                                </td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ number_format($order->discount_amount, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Chưa có đơn hàng nào sử dụng mã giảm giá này.</p>
                        @endif
                    </div>
                    
                    <!-- Tab sản phẩm -->
                    <div class="tab-pane fade" id="products" role="tabpanel">
                        @if($discount->products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Giá</th>
                                            <th>Tồn Kho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($discount->products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <a href="{{ route('admin.products.show', $product) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </td>
                                                <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ $product->stock }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Không có sản phẩm nào áp dụng mã giảm giá này.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endsection
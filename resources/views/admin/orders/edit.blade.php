@extends('layouts.admin')

@section('content')
<h2>Sửa Đơn Hàng: #{{ $order->id }}</h2>

<form action="{{ route('admin.orders.update', $order) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">User</label>
        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
            <option value="">Chọn User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tổng Tiền (VNĐ)</label>
        <input type="number" name="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $order->total_amount) }}" required min="0">
        @error('total_amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Giảm Giá (Tùy Chọn)</label>
        <select name="discount_id" class="form-control">
            <option value="">Không</option>
            @foreach ($discounts as $discount)
                <option value="{{ $discount->id }}" {{ old('discount_id', $order->discount_id) == $discount->id ? 'selected' : '' }}>
                    {{ $discount->code }} ({{ $discount->type }}: {{ $discount->value }})
                </option>
            @endforeach
        </select>
        @error('discount_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Trạng Thái</label>
        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Phương Thức Thanh Toán</label>
        <select name="payment_method" class="form-control">
            <option value="">Không</option>
            <option value="momo" {{ old('payment_method', $order->payment_method) == 'momo' ? 'selected' : '' }}>MoMo</option>
            <option value="stripe" {{ old('payment_method', $order->payment_method) == 'stripe' ? 'selected' : '' }}>Stripe</option>
            <option value="cod" {{ old('payment_method', $order->payment_method) == 'cod' ? 'selected' : '' }}>COD</option>
        </select>
        @error('payment_method')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">ID Thanh Toán (Tùy Chọn)</label>
        <input type="text" name="payment_id" class="form-control" value="{{ old('payment_id', $order->payment_id) }}">
        @error('payment_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Cập Nhật</button>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
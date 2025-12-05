@extends('admin.layouts.admin')

@section('content')
<h2>Chi Tiết Sản Phẩm: {{ $product->name }}</h2>

<div class="row">
    <div class="col-md-6">
        <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="img-fluid rounded">
    </div>
    <div class="col-md-6">
        <p><strong>Tên:</strong> {{ $product->name }}</p>
        <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
        <p><strong>Mô Tả:</strong> {{ $product->description }}</p>
        <p><strong>Tồn Kho:</strong> {{ $product->stock }}</p>
        <p><strong>Giảm Giá:</strong> {{ $product->discount?->code ?? 'Không' }} ({{ $product->discount?->value ?? 0 }}%)</p>
        <p><strong>Đánh Giá TB:</strong> {{ $product->averageRating() }} sao</p>
        <p><strong>Ngày Tạo:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Sửa</a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>
@endsection
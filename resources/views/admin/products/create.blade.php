@extends('admin.layouts.admin')

@section('content')
<h2>Thêm Sản Phẩm Mới</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên Sản Phẩm</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Giá (VNĐ)</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required min="0">
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Mô Tả</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tồn Kho</label>
        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" required min="0">
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Hình Ảnh</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Giảm Giá (Tùy Chọn)</label>
        <select name="discount_id" class="form-control">
            <option value="">Không</option>
            @foreach ($discounts as $discount)
                <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                    {{ $discount->code }} ({{ $discount->type }}: {{ $discount->value }})
                </option>
            @endforeach
        </select>
        @error('discount_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
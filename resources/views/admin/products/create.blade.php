@extends('admin.layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Thêm Sản Phẩm Mới</h4>
    </div>
    <div class="card-body">
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
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên Sản Phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                           value="{{ old('price') }}" required min="0" step="1000">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Mô Tả <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số Lượng Tồn Kho <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                           value="{{ old('stock') }}" required min="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Hình Ảnh</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Chấp nhận: JPG, PNG, GIF, WebP (tối đa 5MB)</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mã Giảm Giá (Tùy Chọn)</label>
                    <select name="discount_id" class="form-control">
                        <option value="">Không có giảm giá</option>
                        @foreach ($discounts as $discount)
                            <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                {{ $discount->code }} 
                                @if($discount->type == 'percent')
                                    ({{ $discount->value }}%)
                                @else
                                    ({{ number_format($discount->value, 0, ',', '.') }} VNĐ)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('discount_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm Sản Phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
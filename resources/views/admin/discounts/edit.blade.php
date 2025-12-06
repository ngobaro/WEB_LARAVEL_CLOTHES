@extends('admin.layouts.admin')  <!-- ĐÃ SỬA: admin.layouts.admin → layouts.admin -->

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Chỉnh Sửa Mã Giảm Giá: {{ $discount->code }}</h4>
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

        <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mã Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                           value="{{ old('code', $discount->code) }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Loại Giảm Giá <span class="text-danger">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="percent" {{ old('type', $discount->type) == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                        <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>Số tiền cố định</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá Trị <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="value" class="form-control @error('value') is-invalid @enderror" 
                               value="{{ old('value', $discount->value) }}" required step="0.01" min="0">
                        <span class="input-group-text">
                            <span id="value-type">
                                {{ $discount->type == 'percent' ? '%' : 'VNĐ' }}
                            </span>
                        </span>
                    </div>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Đơn Hàng Tối Thiểu (VNĐ)</label>
                    <input type="number" name="min_order_amount" class="form-control" 
                           value="{{ old('min_order_amount', $discount->min_order_amount) }}" min="0">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Hạn Sử Dụng <span class="text-danger">*</span></label>
                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" 
                           value="{{ old('expiry_date', \Carbon\Carbon::parse($discount->expiry_date)->format('Y-m-d')) }}" required>  <!-- ĐÃ SỬA -->
                    @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số Lần Sử Dụng Tối Đa</label>
                    <input type="number" name="max_uses" class="form-control" 
                           value="{{ old('max_uses', $discount->max_uses) }}" min="1">
                    <small class="text-muted">Để trống = không giới hạn</small>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" 
                               {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập Nhật
                </button>
                <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Đổi đơn vị hiển thị khi chọn loại giảm giá
    document.querySelector('select[name="type"]').addEventListener('change', function() {
        const type = this.value;
        const valueType = document.getElementById('value-type');
        if (type === 'percent') {
            valueType.textContent = '%';
        } else {
            valueType.textContent = 'VNĐ';
        }
    });
</script>
@endsection
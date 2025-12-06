@extends('admin.layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Chỉnh Sửa Người Dùng: {{ $user->name }}</h4>
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

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mật Khẩu Mới (Để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           min="8">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Nhập mật khẩu mới nếu muốn thay đổi</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Xác Nhận Mật Khẩu Mới</label>
                    <input type="password" name="password_confirmation" class="form-control" min="8">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Vai Trò <span class="text-danger">*</span></label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập Nhật
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
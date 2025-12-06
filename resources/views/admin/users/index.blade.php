@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản Lý Người Dùng</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Người Dùng
    </a>
</div>

<!-- Form tìm kiếm -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ request('name') }}" placeholder="Tìm theo tên...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" 
                       value="{{ request('email') }}" placeholder="Tìm theo email...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Vai Trò</label>
                <select name="role" class="form-control" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm Kiếm
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Xóa Lọc</a>
            </div>
        </form>
    </div>
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
                <th>Tên</th>
                <th>Email</th>
                <th>Vai Trò</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-primary">Khách hàng</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Xóa người dùng này?')"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Chưa có người dùng nào!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $users->links() }}
@endsection
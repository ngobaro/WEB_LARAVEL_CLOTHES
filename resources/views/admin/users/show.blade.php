@extends('admin.layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi Tiết Người Dùng: {{ $user->name }}</h4>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">ID:</th>
                        <td><strong>#{{ $user->id }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tên:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Vai Trò:</th>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">Khách hàng</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Ngày Tạo:</th>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Cập Nhật Lần Cuối:</th>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
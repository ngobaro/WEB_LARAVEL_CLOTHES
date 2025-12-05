@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh Sách Sản Phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Mới
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Tồn Kho</th>
                <th>Giảm Giá</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->discount?->code ?? 'Không' }}</td>
                    <td>
                        <img src="{{ $product->image_url ? Storage::url($product->image_url) : 'https://via.placeholder.com/50' }}" alt="{{ $product->name }}" width="50">
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Chưa có sản phẩm nào!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $products->links() }}  <!-- Phân trang -->
@endsection
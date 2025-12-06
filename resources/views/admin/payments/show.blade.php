@extends('admin.layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi Tiết Thanh Toán #{{ $payment->id }}</h4>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">ID Thanh Toán:</th>
                        <td><strong>#{{ $payment->id }}</strong></td>
                    </tr>
                    <tr>
                        <th>Đơn Hàng:</th>
                        <td>
                            <a href="{{ route('admin.orders.show', $payment->order_id) }}">
                                #{{ $payment->order_id }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Khách Hàng:</th>
                        <td>{{ $payment->order->user->name }} ({{ $payment->order->user->email }})</td>
                    </tr>
                    <tr>
                        <th>Số Tiền:</th>
                        <td><strong class="text-success">{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</strong></td>
                    </tr>
                    <tr>
                        <th>Phương Thức:</th>
                        <td>
                            @switch($payment->payment_method)
                                @case('momo')<span class="badge bg-purple">MoMo</span>@break
                                @case('stripe')<span class="badge bg-primary">Stripe</span>@break
                                @case('cod')<span class="badge bg-secondary">COD</span>@break
                                @case('bank_transfer')<span class="badge bg-info">Chuyển Khoản</span>@break
                            @endswitch
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Trạng Thái:</th>
                        <td>
                            @switch($payment->status)
                                @case('pending')<span class="badge bg-warning">Đang chờ</span>@break
                                @case('success')<span class="badge bg-success">Thành công</span>@break
                                @case('failed')<span class="badge bg-danger">Thất bại</span>@break
                                @case('cancelled')<span class="badge bg-secondary">Đã hủy</span>@break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Mã Giao Dịch:</th>
                        <td>{{ $payment->transaction_id ?: '<span class="text-muted">Chưa có</span>' }}</td>
                    </tr>
                    <tr>
                        <th>Thời Gian Tạo:</th>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Thời Gian Thanh Toán:</th>
                        <td>
                            @if($payment->paid_at)
                                {{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Chưa thanh toán</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                @if($payment->status == 'pending')
                    <div class="mt-3">
                        <h6>Thay đổi trạng thái:</h6>
                        <form action="{{ route('admin.payments.updateStatus', $payment) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <select name="status" class="form-control">
                                    <option value="success">Thành công</option>
                                    <option value="failed">Thất bại</option>
                                    <option value="cancelled">Đã hủy</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
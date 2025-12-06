<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header bg-success text-white text-center">
                        <h3>Xác Thực OTP {{ $type == 'register' ? 'Đăng Ký' : 'Đăng Nhập' }}</h3>
                        <p>Gửi đến: {{ $email }}</p>
                    </div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-info">{{ session('message') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="mb-3">
                                <label class="form-label">Mã OTP</label>
                                <input type="text" name="otp" class="form-control @error('otp') is-invalid @enderror" required maxlength="6">
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100">Xác Thực</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="btn btn-secondary">Quay Lại Đăng Nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
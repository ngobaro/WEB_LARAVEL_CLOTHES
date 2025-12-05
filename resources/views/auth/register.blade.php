<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Tài Khoản</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 8px 14px;
            background: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-secondary {
            background: #7f8c8d;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Đăng Ký Tài Khoản Mới</h1>

        {{-- Hiển thị lỗi --}}
        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Tên:</label>
                <input type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>Xác nhận Mật khẩu:</label>
                <input type="password" name="password_confirmation">
            </div>

            <button class="btn" type="submit">Đăng Ký</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="{{ route('login') }}" class="btn btn-secondary">Đã có tài khoản? Đăng nhập</a>
        </div>
    </div>
</body>
</html>